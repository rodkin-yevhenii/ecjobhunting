<?php

namespace EcJobHunting\Service\Chat;

use DateTime;
use EcJobHunting\Entity\Chat;
use EcJobHunting\Front\EcResponse;
use WP_Comment;
use WP_Comment_Query;
use WP_Query;

/**
 * Class ChatService
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Chat
 */
class ChatService
{
    private EcResponse $response;

    /**
     * @param int $id
     */
    public static function renderContactsList(int $id): void
    {
        if (empty($id)) {
            return;
        }

        $chatsIds = self::getUserChats($id)
        ?>

        <?php
    }

    /**
     * Get user chats by user ID.
     *
     * @param int $id User ID.
     *
     * @return array
     */
    public static function getUserChats(int $id): array
    {
        $chats = [];
        $args = [
            'post_type' => 'chat',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => 'contacts_$_user',
                    'value' => $id,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ]
            ],
            'meta_key' => 'last_update_date',
            'orderby' => ['last_update_date' => 'DESC']
        ];

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            return [];
        }

        foreach ($query->posts as $id) {
            $chats[] = new Chat($id);
        }

        return $chats;
    }

    /**
     * Get messages by chat ID.
     *
     * @param int $chatId
     * @param int $paged
     *
     * @return array
     */
    public static function getChatMessages(int $chatId, int $paged = 1): array
    {
        $query = new WP_Comment_Query(
            [
                'post_id' => $chatId,
                'number' => 20,
                'paged' => $paged,
                'orderby' => 'comment_date',
                'order' => 'ASC'
            ]
        );

        return $query->comments;
    }

    public function __invoke()
    {
        $this->response = new EcResponse();

        // Ajax actions
        add_action("wp_ajax_send_chat_message", [$this, 'sendMessageAjaxCallback']);
        add_action("wp_ajax_nopriv_send_chat_message", [$this, 'sendMessageAjaxCallback']);

        add_action("wp_ajax_load_chat_messages", [$this, 'loadMessagesAjaxCallback']);
        add_action("wp_ajax_nopriv_load_chat_messages", [$this, 'loadMessagesAjaxCallback']);

        add_action("wp_ajax_reload_contacts", [$this, 'reloadContactsAjaxCallback']);
        add_action("wp_ajax_nopriv_reload_contacts", [$this, 'reloadContactsAjaxCallback']);

        // Other actions
        add_filter('posts_where', [$this, 'replaceContactsRepeaterField']);
        add_filter('duplicate_comment_id', '__return_false');
        add_filter('comment_flood_filter', '__return_false');
    }

    /**
     * Add new message ajax callback.
     */
    public function sendMessageAjaxCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'send_message')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['message'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Message is required')
                ->send();
        }

        if (empty($_POST['chat']) || 'chat' !== get_post_type($_POST['chat'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Correct Chat ID is required')
                ->send();
        }

        $chatId = abs($_POST['chat']);
        $user = wp_get_current_user();
        $commentData = array(
            'comment_post_ID' => $chatId,
            'comment_author' => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_author_url' => $user->user_url,
            'comment_content' => $_POST['message'],
            'comment_type' => 'comment',
            'comment_parent' => 0,
            'user_ID' => $user->ID,
        );

        $commentId = wp_new_comment($commentData);

        if (is_wp_error($commentId) || !$commentId) {
            $this->response
                ->setStatus(500)
                ->setMessage('Massage was n\'t sent')
                ->send();
        }

        $date = new DateTime();
        update_field('last_update_date', $date->format('Y-m-d H:i:s'), $chatId);
        $contacts = get_field('contacts', $chatId);

        foreach ($contacts as &$contact) {
            if ((int)$contact['user'] !== $user->ID) {
                $contact['is_viewed'] = false;
            }
        }

        update_field('contacts', $contacts, $chatId);

        $this->response
            ->setStatus(200)
            ->send();
    }

    /**
     * Load chat messages ajax callback.
     */
    public function loadMessagesAjaxCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_messages')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['chatId']) || 'chat' !== get_post_type($_POST['chatId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Correct Chat ID is required')
                ->send();
        }

        $chatId = $_POST['chatId'];
        $query = new WP_Comment_Query(
            [
                'post_id' => $_POST['chatId'],
                'number' => 0,
                'orderby' => 'comment_date',
                'order' => 'DESC'
            ]
        );

        if (empty($query->comments)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Comments not found')
                ->send();
        }

        ob_start();
        $startDate = '';

        for ($i = count($query->comments) - 1; $i >= 0; $i--) {
            $comment = $query->comments[$i];

            /**
             * @var $comment WP_Comment
             */
            $date = new DateTime($comment->comment_date);
            $formattedDate = $date->format('F j, Y');

            if ($startDate !== $formattedDate) {
                $startDate = $formattedDate;
                $this->renderMessageMarkup($comment, $formattedDate);
            } else {
                $this->renderMessageMarkup($comment);
            }
        }

        $html = ob_get_clean();
        $contacts = get_field('contacts', $chatId);

        foreach ($contacts as &$contact) {
            if ((int)$contact['user'] === get_current_user_id()) {
                $contact['is_viewed'] = true;
            }
        }

        update_field('contacts', $contacts, $chatId);

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }

    /**
     * Render message markup.
     *
     * @param WP_Comment $comment
     * @param string|null $date
     */
    private function renderMessageMarkup(WP_Comment $comment, string $date = null): void
    {
        ob_start();

        if (!empty($date)) :
            ?>
            <time class="color-secondary text-center d-block"><?php
                echo $date; ?></time>
            <?php
        endif;
        ?>
        <div class="messages-answer-item <?php
        echo get_current_user_id() === (int)$comment->user_id ? 'self' : ''; ?>">
            <span><?php
                echo $comment->comment_content; ?></span>
        </div>
        <?php
        echo ob_get_clean();
    }

    public function reloadContactsAjaxCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'reload_contacts')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $currentUserId = get_current_user_id();
        $chats = ChatService::getUserChats($currentUserId);
        $activeChat = $_POST['activeChatId'] ?? null;

        ob_start();
        get_template_part(
            'template-parts/chat/contacts',
            'list',
            [
                'chats' => $chats,
                'active_chat' => $activeChat
            ]
        );
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }

    /**
     * Update chat contacts repeater field for SQL query.
     *
     * @param $where
     *
     * @return array|string|string[]
     */
    public function replaceContactsRepeaterField($where)
    {
        return str_replace("meta_key = 'contacts_$", "meta_key LIKE 'contacts_%", $where);
    }
}

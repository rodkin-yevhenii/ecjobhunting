<?php

use EcJobHunting\Service\Chat\ChatService;

$currentUserId = get_current_user_id();
$chats = ChatService::getUserChats($currentUserId);
get_header();
?>
<div class="page employer messages">
        <div class="container">
            <div class="row" data-tab>
                <div class="col-12 col-md-5 col-xl-4 js-contacts-container">
                    <?php
                    get_template_part(
                        'template-parts/chat/contacts',
                        'list',
                        [
                            'chats' => $chats,
                        ]
                    );
                    ?>
                </div>
                <div class="col-12 col-md-7 col-xl-8 position-static">
                    <div
                        class="messages-content js-messages"
                        style="display: none"
                        data-tab-content="1"
                        data-nonce="<?php echo wp_create_nonce('load_messages'); ?>"
                    >
                        <div class="messages-answer-back d-md-none" data-tab-back>
                            <div class="messages-answer-back-arrow">
                                <img
                                    src="/wp-content/themes/job-hunting/assets/public/images/icons/arrow-back.png"
                                    alt="Open chats list"
                                >
                            </div>
                            <span class="d-block">Leave message to</span>
                            <span class="text-large js-contact-name"></span>
                        </div>
                        <div class="messages-answer js-messages-container">

                        </div>
                        <form
                            id="chat-form"
                            data-chat-id
                            data-paged="1"
                            data-nonce="<?php echo wp_create_nonce('send_message'); ?>"
                        >
                            <label>
                                <input class="field-text" type="text" placeholder="Reply to Christopher Kallini">
                            </label>
                            <button class="btn btn-primary d-block" type="submit">send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();

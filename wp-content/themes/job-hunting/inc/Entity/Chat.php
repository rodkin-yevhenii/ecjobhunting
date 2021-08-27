<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;

class Chat
{
    private int $id;
    private int $authorId;
    private UserAbstract $opponent;
    private bool $isViewed;
    private bool $isHide;
    private bool $isClosed;

    public function __construct(int $id)
    {
        $post = get_post($id);
        $this->id = $id;
        $this->authorId = $post->post_author;

        $contacts = get_field('contacts', $id);
        $currentUserId = get_current_user_id();

        foreach ($contacts as $contact) {
            if ($currentUserId === $contact['user']) {
                $this->isViewed = $contact['is_viewed'];
                $this->isHide = $contact['is_closed'];

                continue;
            }

            $this->opponent = UserService::getUser($contact['user']);
        }

        $this->isClosed = $contacts[0]['is_closed'] && $contacts[1]['is_closed'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|string
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @return int|mixed
     */
    public function getOpponent()
    {
        return $this->opponent;
    }

    /**
     * @return bool|mixed
     */
    public function isViewed()
    {
        return $this->isViewed;
    }

    /**
     * @return bool|mixed
     */
    public function isHide()
    {
        return $this->isHide;
    }

    /**
     * @return bool|mixed
     */
    public function isClosed()
    {
        return $this->isClosed;
    }
}

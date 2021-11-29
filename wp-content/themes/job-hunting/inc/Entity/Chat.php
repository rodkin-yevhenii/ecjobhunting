<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;

class Chat
{
    private int $id;
    private int $authorId;
    private int $opponentId;
    private bool $isViewed;
    private bool $isHide;
    private bool $isClosed;
    private Vacancy $vacancy;

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
            }

            if ($this->authorId !== $contact['user']) {
                $this->opponentId = $contact['user'];
            }
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
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return int|mixed
     */
    public function getOpponentId(): int
    {
        return $this->opponentId;
    }

    /**
     * @return Vacancy
     */
    public function getVacancy(): Vacancy
    {
        if (empty($this->vacancy)) {
            $vacancyId = get_field('vacancy', $this->id);
            $this->vacancy = new Vacancy($vacancyId);
        }
        return $this->vacancy;
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

    /**
     * @param int $currentUserId
     *
     * @return int
     */
    public function getInterlocutor(int $currentUserId): int
    {
        return $this->authorId !== $currentUserId ? $this->authorId : $this->opponentId;
    }
}

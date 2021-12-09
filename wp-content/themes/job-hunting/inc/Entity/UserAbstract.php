<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Interfaces\SiteUser;
use EcJobHunting\Service\User\UserService;
use WP_User;

abstract class UserAbstract implements SiteUser
{
    private ?int $id;
    private ?WP_User $user;
    private string $role;

    public function __construct($user)
    {
        $this->user = $user;
        $this->id = $this->user->ID ?? null;

        if (in_array('candidate', $user->roles)) {
            $this->role = 'candidate';
        } elseif (in_array('employer', $user->roles)) {
            $this->role = 'employer';
        } else {
            $this->role = 'admin';
        }
    }

    public function getUserId()
    {
        return $this->id;
    }

    public function getPhoto()
    {
        return UserService::getPhotoUrl($this->id);
    }

    public function getName()
    {
        return ucwords($this->user->display_name ?? "John Dou");
    }

    public function getProfileUrl()
    {
        return get_edit_profile_url($this->id);
    }

    public function getEmail()
    {
        return $this->user->user_email;
    }

    public function setPassword($password)
    {
        // TODO: Implement setPassword() method.
    }

    /**
     * Get user jobs bookmarks.
     *
     * @return array
     */
    public function getJobsBookmarks(): array
    {
        $jobBookmarks = get_user_meta($this->id, 'jobs_bookmarks', true);

        if (!is_array($jobBookmarks)) {
            $jobBookmarks = [];
        }

        return $jobBookmarks;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }
}

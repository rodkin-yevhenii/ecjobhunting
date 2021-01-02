<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Interfaces\SiteUser;
use EcJobHunting\Service\User\UserService;
use WP_User;

abstract class UserAbstract implements SiteUser
{
    private ?int $id;
    private ?WP_User $user;

    public function __construct($user)
    {
     $this->user = $user;
     $this->id = $this->user->id ?? null;
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

    public function setPassword($password)
    {
        // TODO: Implement setPassword() method.
    }
}
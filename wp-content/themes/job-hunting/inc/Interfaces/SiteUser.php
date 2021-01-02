<?php

namespace EcJobHunting\Interfaces;

interface SiteUser
{
    public function getUserId();

    public function getPhoto();

    public function getName();

    public function getProfileUrl();

    public function setPassword($password);
}
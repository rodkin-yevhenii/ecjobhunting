<?php

namespace EcJobHunting\Service\Redirection;

class UserRedirect
{
    public static function redirectToJobs()
    {
        wp_redirect(get_post_type_archive_link('vacancy'), 301);
        exit();
    }
}

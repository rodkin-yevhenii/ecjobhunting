<?php

namespace EcJobHunting\Service\User;

class UserService
{
    private static string $candidateRoleName = 'candidate';
    private static string $employerRoleName = 'employer';

    public function __invoke()
    {
        $this->hooks();
    }

    private static function getCurrentUserRole()
    {
        if (!is_user_logged_in()) {
            return false;
        }
        $user = wp_get_current_user();
        return ( array )$user->roles;
    }

    public static function isCandidate()
    {
        if (!is_user_logged_in()) {
            return false;
        }
        return in_array(static::$candidateRoleName, self::getCurrentUserRole()) ?? false;
    }

    public static function isEmployer()
    {
        if (!is_user_logged_in()) {
            return false;
        }
        return in_array(static::$employerRoleName, self::getCurrentUserRole()) ?? false;
    }

    public static function getPhotoUrl($userId = null)
    {
        if(!$userId){
            $userId = get_current_user_id();
        }
        $photo = get_field('photo', 'user_' . $userId);

        return empty($photo) ? IMG_URI . 'account.jpg' : $photo;
    }

    private function hooks()
    {
        add_action('template_redirect', [$this, 'redirectIfLogin']);
        add_filter('edit_profile_url', [$this, 'editProfileUrl'], 10, 3);
        add_filter('login_url', [$this, 'editLoginUrl'], 10, 3);
    }

    /**
     * Redirect user to their profile if they logged in
     */
    public function redirectIfLogin()
    {
        if (is_user_logged_in() && is_page_template('page-signup.php')) {
            wp_redirect(get_edit_profile_url(), 301);
            exit();
        }
    }

    public function editProfileUrl($url, $user_id, $scheme)
    {
        if (static::isCandidate()) {
            return CANDIDATE_PROFILE_URL;
        } elseif (static::isEmployer()) {
            return EMPLOYER_PROFILE_URL;
        }
        return $url;
    }

    public function editLoginUrl()
    {
        return site_url('/login/');
    }
}
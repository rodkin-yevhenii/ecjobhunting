<?php

namespace EcJobHunting\Service\User;

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\EcJobUser;
use Exception;
use WP_User;

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
        if (!$userId) {
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

    public static function getUser($id = null)
    {
        if (!$id) {
            $user = wp_get_current_user();
        } else {
            $user = get_user_by('id', $id);
        }
        if (in_array('candidate', $user->roles)) {
            return new Candidate($user);
        } elseif (in_array('employer', $user->roles)) {
            return new Company($user);
        }
        return new EcJobUser($user);
    }

    /**
     * Reset user password.
     *
     * @param WP_User $user
     * @param string $pwd
     * @param string $pwdConfirmation
     *
     * @throws Exception    Passwords empty or it are different.
     */
    public static function resetPassword(WP_User $user, string $pwd, string $pwdConfirmation): void
    {
        if (empty($pwd)) {
            throw new Exception('password_reset_empty');
        }

        if ($pwd !== $pwdConfirmation) {
            throw new Exception('password_reset_mismatch');
        }

        reset_password($user, $pwd);
    }
}

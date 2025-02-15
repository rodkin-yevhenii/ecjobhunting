<?php

namespace EcJobHunting\Service\User;

use WP_Error;
use WP_User;

/**
 * Class Login
 *
 * @author Rodkin Yevhenii <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\User
 */
class Login
{
    /**
     * Get error message by error code.
     *
     * @param string $errorCode
     *
     * @return string
     */
    public static function getErrorMessage(string $errorCode): string
    {
        switch ($errorCode) {
            case 'gglcptch_error':
                return __('The CAPTCHA answer is wrong.', 'ecjobhunting');

            case 'empty_username':
                return __('Do you have an email address, right?', 'ecjobhunting');

            case 'empty_password':
                return __('You need to enter a password to login.', 'ecjobhunting');

            case 'invalid_username':
                return __(
                    'We don\'t have any users with that email address. Maybe you used a different one when signing up?',
                    'ecjobhunting'
                );

            case 'incorrect_password':
                return __(
                    'The password you entered wasn\'t quite right.
                    <a href=\'' . wp_lostpassword_url() . '\'>Did you forget your password</a>?',
                    'ecjobhunting'
                );

            case 'password_reset_empty':
                return __("Sorry, we don't accept empty passwords.", 'ecjobhunting');

            default:
                return __('An unknown error occurred. Please try again later.', 'ecjobhunting');
        }
    }

    /**
     * Register hooks.
     */
    public function __invoke()
    {
        add_action('login_form_login', [$this, 'redirectToCustomLogin']);
        add_action('wp_logout', [$this, 'redirectToCustomLogin']);
        add_action('login_form_register', [$this, 'redirectToCustomSignUp']);
        add_filter('authenticate', [$this, 'redirectToCustomLoginAfterAuthenticate'], 100, 1);
        add_filter('wp_login', [$this, 'redirectToDashboardAfterLogin'], 10, 2);
    }

    /**
     * Redirect user to login page.
     */
    public function redirectToCustomLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $redirect_to = $_REQUEST['redirect_to'] ?? null;

            if (is_user_logged_in()) {
                wp_redirect(home_url($redirect_to));
                exit;
            }

            if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                $login_url = home_url('login');
                if (!empty($redirect_to)) {
                    $login_url = add_query_arg('redirect_to', $redirect_to, $login_url);
                }

                wp_redirect($login_url);
                exit;
            }
        }
    }

    /**
     * Redirect user to login page.
     */
    public function redirectToCustomSignUp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $redirect_to = $_REQUEST['redirect_to'] ?? null;

            if (is_user_logged_in()) {
                wp_redirect(home_url($redirect_to));
                exit;
            }

            // The rest are redirected to the signup page
            $sign_up = home_url('signup');
            if (!empty($redirect_to)) {
                $sign_up = add_query_arg('redirect_to', $redirect_to, $sign_up);
            }

            wp_redirect($sign_up);
            exit;
        }
    }

    /**
     * Redirect the user after authentication if there were any errors.
     *
     * @param Wp_User|Wp_Error $user The signed in user, or the errors that have occurred during login.
     *
     * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
     */
    public function redirectToCustomLoginAfterAuthenticate($user)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (is_wp_error($user)) {
                $error_codes = join(',', $user->get_error_codes());

                $login_url = home_url('login');
                $login_url = add_query_arg('errors', $error_codes, $login_url);

                wp_redirect($login_url);
                exit;
            }
        }

        return $user;
    }

    /**
     * Redirect users to dashboard after login.
     *
     * @param string $login
     * @param WP_User $user
     *
     * @return string
     */
    public function redirectToDashboardAfterLogin(string $login, WP_User $user): void
    {
        if (!is_wp_error($user) && $user->has_cap('manage_options')) {
            wp_redirect(site_url('wp-admin'));
            exit();
        } elseif (UserService::isEmployer($user->ID) || UserService::isCandidate($user->ID)) {
            wp_redirect(site_url('dashboard'));
            exit();
        } else {
            wp_redirect(home_url());
            exit();
        }
    }
}

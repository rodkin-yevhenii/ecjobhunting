<?php

namespace EcJobHunting\Service\User;

use Exception;
use WP_User;

/**
 * Class RetrievePassword
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\User
 */
class RetrievePassword
{
    private array $errors = [];

    /**
     * RetrievePassword constructor.
     */
    public function __construct()
    {

    }

    /**
     * Register hooks.
     */
    public function __invoke()
    {
        add_filter('login_form_lostpassword', [$this, 'redirectToCustomLostPasswordPage']);
        add_action('login_form_rp', [$this, 'redirectToCustomLostPasswordPage']);
        add_action('login_form_resetpass', [$this, 'redirectToCustomLostPasswordPage']);
        add_action('login_form_lostpassword', [$this, 'retrievePassword']);
        add_action('login_form_rp', [$this, 'doPasswordReset']);
        add_action('login_form_resetpass', [$this, 'doPasswordReset']);
    }

    /**
     * Change lost password page url.
     *
     * @return string
     */
    public function redirectToCustomLostPasswordPage(): void
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            if (is_user_logged_in()) {
                wp_redirect(home_url());
                exit;
            }

            $redirect_url = home_url( 'forgot-password' );

            if (!empty($_REQUEST['key']) && !empty($_REQUEST['login'])) {
                $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );

                if ( ! $user || is_wp_error( $user ) ) {
                    if ( $user && $user->get_error_code() === 'expired_key' ) {
                        $redirect_url = add_query_arg( 'errors', 'expiredkey', $redirect_url );
                    } else {
                        $redirect_url = add_query_arg( 'errors', 'invalidkey', $redirect_url );
                    }
                    wp_redirect($redirect_url);
                    exit;
                }

                $redirect_url = add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
                $redirect_url = add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);
            }

            wp_redirect($redirect_url);
            exit;
        }
    }

    public function doPasswordReset(): void
    {
        if (
            'POST' == $_SERVER['REQUEST_METHOD']
            && isset($_POST['pwd'], $_POST['pwd_confirmation'], $_REQUEST['key'], $_REQUEST['login'])
        ) {
            $key = $_REQUEST['key'];
            $login = $_REQUEST['login'];
            $user = check_password_reset_key( $key, $login );

            if ( ! $user || is_wp_error( $user ) ) {
                $redirect_url = home_url( 'forgot-password' );

                if ( $user && $user->get_error_code() === 'expired_key' ) {
                    $redirect_url = add_query_arg( 'errors', 'expiredkey', $redirect_url );
                } else {
                    $redirect_url = add_query_arg( 'errors', 'invalidkey', $redirect_url );
                }
                wp_redirect($redirect_url);
                exit;
            }

            try {
                UserService::resetPassword($user, $_POST['pwd'], $_POST['pwd_confirmation']);
                $redirect_url = home_url('login');
                $redirect_url = add_query_arg( 'password', 'changed', $redirect_url );
                wp_redirect(home_url('login'));
                exit;
            } catch (Exception $exception) {
                $redirect_url = add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);
                $redirect_url = add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
                $redirect_url = add_query_arg('errors', $exception->getMessage(), $redirect_url);
                wp_redirect($redirect_url);
                exit;
            }
        }
    }

    /**
     * Retrieve password and redirect user to next page.
     */
    public function retrievePassword(): void
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $errors = retrieve_password();

            if (is_wp_error($errors)) {
                // Errors found
                $redirect_url = home_url('forgot-password');
                $redirect_url = add_query_arg('errors', join(',', $errors->get_error_codes()), $redirect_url);
            } else {
                // Email sent
                $redirect_url = home_url('login');
                $redirect_url = add_query_arg('checkemail', 'confirm', $redirect_url);
            }

            wp_redirect($redirect_url);
            exit;
        }
    }

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
            case 'expiredkey':
            case 'invalidkey':
                return __( 'The password reset link you used is not valid anymore.', 'ecjobhunting' );

            case 'empty_username':
                return __( 'You need to enter your email address to continue.', 'ecjobhunting' );

            case 'invalid_email':
            case 'invalidcombo':
                return __( 'There are no users registered with this email address.', 'ecjobhunting' );
        }
    }
}

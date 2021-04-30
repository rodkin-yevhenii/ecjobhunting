<?php

namespace EcJobHunting\Service\User;

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
        add_filter('login_form_lostpassword', [$this, 'changeLostPasswordUrl']);
        add_action('login_form_lostpassword', [$this, 'retrievePassword']);
    }

    /**
     * Change lost password page url.
     *
     * @return string
     */
    public function changeLostPasswordUrl(): void
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            if (is_user_logged_in()) {
                wp_redirect(home_url());
                exit;
            }

            wp_redirect(home_url('forgot-password'));
            exit;
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
            case 'empty_username':
                return __( 'You need to enter your email address to continue.', 'ecjobhunting' );

            case 'invalid_email':
            case 'invalidcombo':
                return __( 'There are no users registered with this email address.', 'ecjobhunting' );
        }
    }
}

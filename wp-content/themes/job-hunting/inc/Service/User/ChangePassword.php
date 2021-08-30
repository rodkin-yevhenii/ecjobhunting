<?php

namespace EcJobHunting\Service\User;

use EcJobHunting\Front\EcResponse;

/**
 * class ChangePassword
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\User
 */
class ChangePassword
{
    private EcResponse $response;

    /**
     * ChangePassword class constructor
     */
    public function __invoke()
    {
        $this->response = new EcResponse();
        $this->registerHooks();
    }

    private function registerHooks(): void
    {
        add_action('wp_ajax_check_user_password', [$this, 'checkUserPassword']);
        add_action('wp_ajax_nopriv_check_user_password', [$this, 'checkUserPassword']);

        add_action('wp_ajax_change_user_password', [$this, 'changePassword']);
        add_action('wp_ajax_nopriv_change_user_password', [$this, 'changePassword']);
    }

    public function checkUserPassword(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'change-user-password')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['password'])) {
            $this->response
                ->setStatus(403)
                ->setMessage('Current password shouldn\'t be empty.')
                ->send();
        }

        $user = wp_get_current_user();

        if (!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
            $this->response
                ->setStatus(403)
                ->setMessage('Incorrect current user password.')
                ->send();
        }

        $this->response
            ->setStatus(200)
            ->send();
    }

    public function changePassword(): void
    {
        if (empty($_POST['password'])) {
            $this->response
                ->setStatus(403)
                ->setMessage('Current password shouldn\'t be empty.')
                ->send();
        }

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'change-user-password')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $user = wp_get_current_user();

        if (!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
            $this->response
                ->setStatus(403)
                ->setMessage('Incorrect current user password.')
                ->send();
        }

        if (empty($_POST['newPassword']) || empty($_POST['passwordConfirmation'])) {
            $this->response
                ->setStatus(403)
                ->setMessage('New & confirmation passwords shouldn\'t be empty.')
                ->send();
        }

        if ($_POST['newPassword'] !== $_POST['passwordConfirmation']) {
            $this->response
                ->setStatus(403)
                ->setMessage('New & confirmation passwords are different.')
                ->send();
        }


        $new_pass = trim(wp_unslash($_POST['newPassword']));
        wp_set_password($new_pass, get_current_user_id());

        $this->response
            ->setStatus(200)
            ->send();
    }
}

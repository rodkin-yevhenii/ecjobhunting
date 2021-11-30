<?php

namespace EcJobHunting\Service\User;

use EcJobHunting\Entity\Email;
use EcJobHunting\Front\EcResponse;
use EcJobHunting\Interfaces\AjaxResponse;
use EcJobHunting\Service\Email\EmailMessages;
use EcJobHunting\Service\Email\EmailService;

class Registration
{
    private AjaxResponse $response;

    /**
     * Registration constructor.
     */
    public function __construct()
    {
        $this->response = new EcResponse();
    }

    /**
     * Register hooks & actions
     */
    public function __invoke()
    {
        if (wp_doing_ajax()) {
            add_action('wp_ajax_register_user', [$this, 'createNewUser']);
            add_action('wp_ajax_nopriv_register_user', [$this, 'createNewUser']);
        }

        add_filter('password_hint', [$this, 'changePasswordHint']);
    }

    /**
     * Check user registration information.
     */
    private function checkUserRegistrationInfo()
    {
        require_once ABSPATH . WPINC . '/user.php';

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'sign_up')) {
            $this->response->setStatus(403)
                ->setMessage(__('Authentication failed', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['email'])) {
            $this->response->setStatus(204)
                ->setMessage(__('Email is required', 'ecjobhunting'))
                ->send();
        }

        if (email_exists($_POST['email'])) {
            $this->response->setStatus(204)
                ->setMessage(__('The email has already taken', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['username'])) {
            $this->response->setStatus(204)
                ->setMessage(__('Username is required', 'ecjobhunting'))
                ->send();
        }

        if (username_exists($_POST['username'])) {
            $this->response->setStatus(204)
                ->setMessage(__('Username has already taken', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['password'])) {
            $this->response->setStatus(204)
                ->setMessage(__('Password is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['pwd_confirmation'])) {
            $this->response->setStatus(204)
                ->setMessage(__('Confirm password is required', 'ecjobhunting'))
                ->send();
        }

        if ($_POST['password'] !== $_POST['pwd_confirmation']) {
            $this->response->setStatus(204)
                ->setMessage(__('Password are different', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['role'])) {
            $this->response->setStatus(204)
                ->setMessage(__('User role is required', 'ecjobhunting'))
                ->send();
        }

        if (!in_array($_POST['role'], ['candidate', 'employer'])) {
            $this->response->setStatus(204)
                ->setMessage(__('User role isn\'t correct', 'ecjobhunting'))
                ->send();
        }
    }

    /**
     * Register new user.
     */
    public function createNewUser()
    {
        $this->checkUserRegistrationInfo();

        $roles = wp_roles();
        $email = $_POST['email'];
        $login = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (!array_key_exists(strtolower($role), $roles->role_names)) {
            $this->response->setStatus(204)
                ->setMessage(__('Incorrect user role', 'ecjobhunting'))
                ->send();
        }

        if (!preg_match('/^[a-zA-Z_\d]{4,}$/', $login)) {
            $this->response->setStatus(204)
                ->setMessage('Incorrect user login. The login  should be at least four characters long. To make it
                stronger, use upper and lower case letters, numbers, and _ symbol')
                ->send();
        }

        if (!preg_match('/^[a-zA-Z_\-\!\"\?\$\%\^\&\)\(\d]{8,}$/', $password)) {
            $this->response->setStatus(204)
                ->setMessage(wp_get_password_hint())
                ->send();
        }

        $id = wp_create_user($login, $password, $email);

        if (is_wp_error($id)) {
            $this->response->setStatus(406)
                ->setMessage(
                    __('An error has occurred. Try again later or contact your administrator.', 'ecjobhunting')
                )
                ->send();
        }

        $user = new \WP_User($id);
        $user->set_role($role);
        $emailMessages = new EmailMessages();
        $emailObj = new Email();
        $emailObj
            ->setSubject('EC jobhunting > Account registration')
            ->setMessage($emailMessages->getRegistrationMessage($login))
            ->setToEmail($email);
        EmailService::sendEmail($emailObj);

        $this->response->setStatus(200)
            ->setMessage(__('User registered successfully', 'ecjobhunting'))
            ->send();
    }

    /**
     * @param string $hint
     *
     * @return string
     */
    public function changePasswordHint(string $hint): string
    {
        return str_replace(['twelve', '!'], ['eight', '_ - !'], $hint);
    }
}

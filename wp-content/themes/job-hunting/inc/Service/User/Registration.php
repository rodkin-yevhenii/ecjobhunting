<?php

namespace EcJobHunting\Service\User;

use EcJobHunting\Entity\Email;
use EcJobHunting\Front\EcResponse;
use EcJobHunting\Interfaces\AjaxResponse;
use EcJobHunting\Service\Email\EmailMessages;
use EcJobHunting\Service\Email\EmailService;

use function Aws\map;

class Registration
{
    /**
     * New user email.
     *
     * @var string
     */
    private string $email = '';

    /**
     * New user login.
     *
     * @var string
     */
    private string $username = '';

    /**
     * New user password.
     *
     * @var string
     */
    private string $password;

    /**
     * New user password confirmation.
     *
     * @var string
     */
    private string $passwordConfirmation;

    /**
     * New user role.
     * Valid values: candidate or employer.
     *
     * @var string
     */
    private string $role;

    /**
     * Store of errors codes.
     *
     * @var array
     */
    private array $errorsCodes;

    /**
     * Registration constructor.
     */
    public function __construct()
    {
        $this->errorsCodes = [];
    }

    public function __invoke()
    {
        add_filter('password_hint', [$this, 'changePasswordHint']);
    }

    /**
     * Get user data from $_POST array and write to userData property.
     *
     * @return array
     */
    private function getUserData(): array
    {
        $args = [
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL,
                'flags' => FILTER_NULL_ON_FAILURE,
            ],
            'username' => [
                FILTER_CALLBACK,
                [
                    'options' => function ($value): ?string {
                        if (validate_username($value)) {
                            return $value;
                        }

                        return null;
                    }
                ]
            ],
            'candidate_pwd' => [
                FILTER_CALLBACK,
                [
                    'options' => [$this, 'validatePassword']
                ]
            ],
            'employer_pwd' => [
                FILTER_CALLBACK,
                [
                    'options' => [$this, 'validatePassword']
                ]
            ],
            'candidate_pwd_confirmation' => [
                FILTER_CALLBACK,
                [
                    'options' => [$this, 'validatePassword']
                ]
            ],
            'employer_pwd_confirmation' => [
                FILTER_CALLBACK,
                [
                    'options' => [$this, 'validatePassword']
                ]
            ],
            'role' => [
                FILTER_CALLBACK,
                [
                    'options' => function ($value): ?string {
                        if (in_array($value, ['candidate', 'employer'])) {
                            return $value;
                        }

                        return null;
                    }
                ]
            ]
        ];

        $userData = filter_input_array(INPUT_POST, $args);
        $userData['password'] = $userData['candidate_pwd']
            ?? $userData['employer_pwd'];
        $userData['password_confirmation']  = $userData['candidate_pwd_confirmation']
            ?? $userData['employer_pwd_confirmation'];

        unset(
            $userData['candidate_pwd'],
            $userData['employer_pwd'],
            $userData['candidate_pwd_confirmation'],
            $userData['employer_pwd_confirmation'],
        );

        return $userData;
    }

    public function isUserDataValid(): bool
    {
        $userData = $this->getUserData();

        if (! $userData['email']) {
            $this->errorsCodes[] = 'ecj_invalid_user_email';
        }

        if (get_user_by('email', $userData['email'])) {
            $this->errorsCodes[] = 'ecj_email_already_taken';
        }

        if (! $userData['username']) {
            $this->errorsCodes[] = 'ecj_invalid_username';
        }

        if (get_user_by('login', $userData['username'])) {
            $this->errorsCodes[] = 'ecj_username_already_taken';
        }

        if (! $userData['password']) {
            $this->errorsCodes[] = 'ecj_invalid_user_pwd';
        }

        if ($userData['password'] !== $userData['password_confirmation']) {
            $this->errorsCodes[] = 'ecj_different_pwds';
        }

        if (! $userData['role']) {
            $this->errorsCodes[] = 'ecj_invalid_user_role';
        }

        if (! wp_verify_nonce(filter_input(INPUT_POST, 'nonce'), 'sign_up')) {
            $this->errorsCodes[] = 'ecj_invalid_access';
        }

        $captchaResult = apply_filters(
            'gglcptch_verify_recaptcha',
            true,
            false,
            'ecj_register_' . $userData['role'] . '_form'
        );

        if (! $captchaResult) {
            $this->errorsCodes[] = 'gglcptch_error';
        }

        return empty($this->errorsCodes);
    }

    public function getErrors(): array
    {
        return array_map(
            function ($code) {
                return $this->getErrorMessage($code);
            },
            $this->errorsCodes
        );
    }

    /**
     * @return void
     */
    public function setUserData(): void
    {
        $data = $this->getUserData();

        $this->email = $data['email'] ?? '';
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->role = $data['role'] ?? '';
    }

    /**
     * Get error message by error code.
     *
     * @param string $errorCode
     *
     * @return string
     */
    public function getErrorMessage(string $errorCode): string
    {
        switch ($errorCode) {
            case 'gglcptch_error':
                return __('The CAPTCHA answer is wrong.', 'ecjobhunting');

            case 'ecj_invalid_user_email':
                return __('Please, use correct email address.', 'ecjobhunting');

            case 'ecj_email_already_taken':
                return __(
                    'This email already taken',
                    'ecjobhunting'
                );

            case 'ecj_invalid_username':
                return __(
                    'Incorrect user login. The login  should be at least four characters long. To make it
                    stronger, use upper and lower case letters, numbers, and _ symbol',
                    'ecjobhunting'
                );

            case 'ecj_username_already_taken':
                return __(
                    'This username already taken',
                    'ecjobhunting'
                );

            case 'ecj_invalid_user_pwd':
                return wp_get_password_hint();

            case 'ecj_different_pwds':
                return __("Passwords are different.", 'ecjobhunting');

            case 'ecj_invalid_user_role':
                return __("Invalid user role. Please use candidate or employer", 'ecjobhunting');

            case 'ecj_invalid_access':
                return __("Access denied", 'ecjobhunting');

            default:
                return __('An unknown error occurred. Please try again later', 'ecjobhunting');
        }
    }

    /**
     * Register new user.
     */
    public function registerNewUser()
    {
        $id = wp_create_user($this->username, $this->password, $this->email);

        if (is_wp_error($id)) {
            throw new \Exception('An unknown error occurred. Please try again later');
        }

        $user = new \WP_User($id);
        $user->set_role($this->role);
        $emailMessages = new EmailMessages();
        $emailObj = new Email();
        $emailObj
            ->setSubject('EC jobhunting > Account registration')
            ->setMessage($emailMessages->getRegistrationMessage($this->username))
            ->setToEmail($this->email);
        EmailService::sendEmail($emailObj);

        wp_redirect(add_query_arg(['username' => $this->username], site_url('login')));
    }

    /**
     * Validate new user password.
     *
     * @param string $password  New user password.
     *
     * @return null|string
     */
    private function validatePassword(string $password): ?string
    {
        if (!preg_match('/^[a-zA-Z_\-\!\"\?\$\%\^\&\)\(\d]{8,}$/', $password)) {
            return $password;
        }

        return null;
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

    /**
     * Checking the availability of data for user registration.
     *
     * @return bool
     */
    public function isDoingRegistration(): bool
    {
        return ! empty($_POST);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}

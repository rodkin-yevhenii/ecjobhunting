<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\Cv\EmailConfirmation;
use EcJobHunting\Service\User\UserService;
use Exception;

/**
 * Class AjaxFormContacts
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormContacts extends AjaxFormAbstract
{

    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_save_contacts_form', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_save_contacts_form', [$this, 'getCallback']);

        add_action('wp_ajax_load_contacts_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_contacts_form', [$this, 'getCallback']);

        add_action('wp_ajax_send_email_confirmation', [$this, 'sendEmailConfirmationCallback']);
        add_action('wp_ajax_nopriv_send_email_confirmation', [$this, 'sendEmailConfirmationCallback']);
    }

    /**
     * @inheritDoc
     */
    public function saveCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ecjob_nonce')) {
            $this->response
                ->setStatus(403)
                ->setMessage(__('Access forbidden', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['cvId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Cv ID is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['new_email'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Email is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['user'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('User is required', 'ecjobhunting'))
                ->send();
        }

        $cvId = (int)$_POST['cvId'];
        $isEmailUpdated = $_POST['new_email'] !== get_field('public_email', $cvId);

        update_field('phone', $_POST['phone'] ?? '', $cvId);

        if ($isEmailUpdated) {
            update_field('new_email', $_POST['new_email'], $cvId);
            update_field('is_email_confirmed', false, $cvId);
        } else {
            update_field('new_email', '', $cvId);
            update_field('is_email_confirmed', true, $cvId);
        }

        $candidate = UserService::getUser($_POST['userId']);

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            'contact-information',
            ['candidate' => $candidate, 'isOwner' => true]
        );

        try {
            if ($isEmailUpdated) {
                EmailConfirmation::sendCvEmailConfirmation();
            }

            $this->response
                ->setStatus(200)
                ->setMessage(__('Profile updated', 'ecjobhunting'))
                ->setResponseBody(ob_get_clean())
                ->send();
        } catch (Exception $exception) {
            ob_get_clean();
            $this->response
                ->setMessage($exception->getMessage())
                ->setStatus($exception->getCode())
                ->send();
        }
    }

    /**
     * Send email with verification code.
     *
     * @throws \Exception
     */
    public function sendEmailConfirmationCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ecjob_nonce')) {
            $this->response
                ->setStatus(403)
                ->setMessage(__('Access forbidden', 'ecjobhunting'))
                ->send();
        }

        try {
            EmailConfirmation::sendCvEmailConfirmation();

            $this->response
                ->setStatus(200)
                ->setMessage(__('Confirmation mail was sent', 'ecjobhunting'))
                ->send();
        } catch (Exception $exception) {
            $this->response
                ->setMessage($exception->getMessage())
                ->setStatus($exception->getCode())
                ->send();
        }
    }
}

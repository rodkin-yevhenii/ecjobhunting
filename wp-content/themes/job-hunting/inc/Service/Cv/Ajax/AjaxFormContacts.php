<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

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
    }

    /**
     * @inheritDoc
     */
    public function saveCallback(): void
    {
        if (empty($_POST['cvId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Cv ID is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['email'])) {
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
        $data = [
            'phone' => $_POST['phone'] ?? '',
            'public_email' => $_POST['email'],
        ];

        update_field('public_email', $data['public_email'], $cvId);
        update_field('phone', $data['phone'], $cvId);
        update_field('is_email_confirmed', false, $cvId);

        $candidate = UserService::getUser($_POST['userId']);

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            'contact-information',
            ['candidate' => $candidate]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }
}

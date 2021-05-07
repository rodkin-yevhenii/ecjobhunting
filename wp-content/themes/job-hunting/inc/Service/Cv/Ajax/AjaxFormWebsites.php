<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormWebsites
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormWebsites extends AjaxFormAbstract
{
    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_save_websites_form', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_save_websites_form', [$this, 'saveCallback']);

        add_action('wp_ajax_load_websites_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_websites_form', [$this, 'getCallback']);
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

        if (empty($_POST['user'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('User is required', 'ecjobhunting'))
                ->send();
        }

        $cvId = (int)$_POST['cvId'];
        update_field('website', $_POST['website'] ?? '', $cvId);
        update_field('twitter', $_POST['twitter'] ?? '', $cvId);
        update_field('linkedin', $_POST['linkedin'] ?? '', $cvId);
        update_field('facebook', $_POST['facebook'] ?? '', $cvId);

        $candidate = UserService::getUser($_POST['userId']);

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            'websites',
            ['candidate' => $candidate]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }
}

<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormExecutiveSummary
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormExecutiveSummary extends AjaxFormAbstract
{

    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_save_executive_summary_form', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_save_executive_summary_form', [$this, 'getCallback']);

        add_action('wp_ajax_load_executive_summary_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_executive_summary_form', [$this, 'getCallback']);
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
        $result = wp_update_post(
            [
                'ID' => $cvId,
                'post_content' => $_POST['summary'] ?? '',
            ]
        );

        if (is_wp_error($result)) {
            $this->response
                ->setStatus(500)
                ->setMessage(__('Updating failed', 'ecjobhunting'))
                ->send();
        }

        $candidate = UserService::getUser($_POST['userId']);

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            'executive-summary',
            ['candidate' => $candidate, 'isOwner' => true]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }
}

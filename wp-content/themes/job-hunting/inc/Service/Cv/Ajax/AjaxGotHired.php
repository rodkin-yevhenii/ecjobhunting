<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxGotHired
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxGotHired
{
    private EcResponse $response;

    /**
     * AjaxGotHired constructor.
     */
    public function __construct()
    {
        $this->registerHooks();
        $this->response = new EcResponse();
    }

    /**
     * Register ajax hooks.
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_profile_deactivate', [$this, 'profileDeactivate']);
        add_action('wp_ajax_nopriv_profile_deactivate', [$this, 'profileDeactivate']);
    }

    /**
     * Deactivate profile ajax callback.
     */
    public function profileDeactivate(): void
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

        $cvId = (int)$_POST['cvId'];
        $result = wp_update_post(
            [
                'ID' => $cvId,
                'post_status' => 'draft',
                'post_date_gmt' => date('Y-m-d H:i:s')
            ]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->send();
    }
}

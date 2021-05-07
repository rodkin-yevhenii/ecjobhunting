<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormAbstract
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
abstract class AjaxFormAbstract
{
    protected EcResponse $response;

    /**
     * AjaxFormAboutMe constructor.
     */
    public function __construct()
    {
        $this->response = new EcResponse();
        $this->registerHooks();
    }

    /**
     * Register ajax hooks
     */
    abstract protected function registerHooks(): void;

    /**
     * Save Cv data to database.
     */
    abstract public function saveCallback(): void;

    /**
     * Cv data from database.
     */
    public function getCallback(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ecjob_nonce')) {
            $this->response
                ->setStatus(403)
                ->setMessage(__('Access forbidden', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['formId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Form ID is required', 'ecjobhunting'))
                ->send();
        }

        $candidate = UserService::getUser(get_current_user_id());

        ob_start();
        $result = get_template_part(
            'template-parts/candidate/dashboard/modal-forms/form',
            $_POST['formId'],
            ['candidate' => $candidate]
        );
        $html = ob_get_clean();

        if ($result === false) {
            $this->response
                ->setStatus(404)
                ->setMessage(__('Form not found', 'ecjobhunting'))
                ->send();
        }

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }
}

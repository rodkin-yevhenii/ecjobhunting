<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormExecutiveSummary
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxHiddenFormAbstract extends AjaxFormAbstract
{
    protected string $formId = '';
    protected string $fieldName = '';

    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action("wp_ajax_save_{$this->formId}_form", [$this, 'saveCallback']);
        add_action("wp_ajax_nopriv_save_{$this->formId}_form", [$this, 'getCallback']);

        add_action("wp_ajax_remove_{$this->formId}_form", [$this, 'removeCallback']);
        add_action("wp_ajax_nopriv_remove_{$this->formId}_form", [$this, 'removeCallback']);

        add_action("wp_ajax_load_{$this->formId}_form", [$this, 'getCallback']);
        add_action("wp_ajax_nopriv_load_{$this->formId}_form", [$this, 'getCallback']);
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

        if (empty($_POST['content'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('The field is required', 'ecjobhunting'))
                ->send();
        }

        $cvId = (int)$_POST['cvId'];
        update_field($this->fieldName, $_POST['content'] ?? '', $cvId);
        $candidate = UserService::getUser(get_current_user_id());

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            $this->formId,
            ['candidate' => $candidate, 'isOwner' => true]
        );
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody($html)
            ->send();
    }

    /**
     * Delete field data.
     */
    public function removeCallback()
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
        delete_field($this->fieldName, $cvId);

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->send();
    }
}

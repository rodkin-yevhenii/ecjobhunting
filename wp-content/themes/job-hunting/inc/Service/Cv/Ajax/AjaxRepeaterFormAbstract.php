<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxRepeaterFormAbstract
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
abstract class AjaxRepeaterFormAbstract
{
    protected EcResponse $response;
    protected string $fieldName;
    protected string $formId = '';

    /**
     * AjaxFormAboutMe constructor.
     */
    public function __construct()
    {
        add_action("wp_ajax_load_add_{$this->formId}_subitem_form", [$this, 'getCallback']);
        add_action("wp_ajax_nopriv_load_add_{$this->formId}_subitem_form", [$this, 'getCallback']);

        add_action("wp_ajax_load_edit_{$this->formId}_subitem_form", [$this, 'getCallback']);
        add_action("wp_ajax_nopriv_load_edit_{$this->formId}_subitem_form", [$this, 'getCallback']);

        add_action("wp_ajax_delete_{$this->formId}_subitem", [$this, 'deleteSubItemCallback']);
        add_action("wp_ajax_nopriv_delete_{$this->formId}_subitem", [$this, 'deleteSubItemCallback']);

        add_action("wp_ajax_save_{$this->formId}_subitem", [$this, 'saveCallback']);
        add_action("wp_ajax_nopriv_save_{$this->formId}_subitem", [$this, 'saveCallback']);

        $this->response = new EcResponse();
    }

    /**
     * Check POST data for save callback
     */
    abstract protected function isValidSavePostData(): void;

    /**
     * Generate repeater row.
     *
     * @return array
     */
    abstract protected function getRow(): array;

    /**
     * Save Cv data to database.
     */
    public function saveCallback(): void
    {
        $this->isValidSavePostData();
        $row = $this->getRow();
        $currentUserId = get_current_user_id();

        if ('edit' === $_POST['doAction']) {
            update_row($this->fieldName, $_POST['rowNumber'], $row, $_POST['cvId']);
        } else {
            add_row($this->fieldName, $row, $_POST['cvId']);
        }

        $candidate = UserService::getUser($currentUserId);
        $isOwner = $currentUserId === $candidate->getUserId();

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            $this->formId,
            ['candidate' => $candidate, 'isOwner' => $isOwner]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }

    /**
     * Check POST data for delete callback
     */
    protected function isValidDeletePostData(): void
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

        if (!isset($_POST['rowNumber'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Row number is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['blockId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Form ID is required', 'ecjobhunting'))
                ->send();
        }
    }

    /**
     * Delete repeater sub item.
     */
    public function deleteSubItemCallback(): void
    {
        $this->isValidDeletePostData();
        $currentUserId = get_current_user_id();
        delete_row($this->fieldName, ++$_POST['rowNumber'], $_POST['cvId']);

        $candidate = UserService::getUser($currentUserId);
        $isOwner = $currentUserId === $candidate->getUserId();

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            $_POST['blockId'],
            ['candidate' => $candidate, 'isOwner' => $isOwner]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }

    /**
     * Check POST data for get callback
     */
    protected function isValidGetPostData(): void
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
    }

    /**
     * Cv data from database.
     */
    public function getCallback(): void
    {
        $this->isValidGetPostData();

        $currentUserId = get_current_user_id();
        $candidate = UserService::getUser($currentUserId);
        $isOwner = $currentUserId === $candidate->getUserId();

        if ("load_edit_{$this->formId}_subitem_form" === $_POST['action']) {
            $args = [
                'candidate' => $candidate,
                'action' => 'edit',
                'row' => $_POST['rowNumber'] ?? 0,
                'isOwner' => $isOwner,
            ];
        } else {
            $args = [
                'candidate' => $candidate,
                'action' => 'add',
                'isOwner' => $isOwner,
            ];
        }

        ob_start();
        $result = get_template_part(
            'template-parts/candidate/dashboard/modal-forms/form',
            $_POST['formId'],
            $args
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

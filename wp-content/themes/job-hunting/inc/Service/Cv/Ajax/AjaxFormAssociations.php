<?php

namespace EcJobHunting\Service\Cv\Ajax;

/**
 * Class AjaxFormAssociations
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormAssociations extends AjaxRepeaterFormAbstract
{
    protected string $formId = 'associations';
    protected string $fieldName = 'associations';

    /**
     * Check POST data for save callback
     */
    protected function isValidSavePostData(): void
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
                ->setMessage(__('Field is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['doAction']) || !in_array($_POST['doAction'], ['edit', 'add'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Incorrect action name.', 'ecjobhunting'))
                ->send();
        }

        if ('edit' === $_POST['doAction'] && empty($_POST['rowNumber'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Order is required', 'ecjobhunting'))
                ->send();
        }
    }

    /**
     * Generate repeater row.
     *
     * @return array
     */
    protected function getRow(): array
    {
        return [
            'text' => $_POST['content']
        ];
    }
}


<?php

namespace EcJobHunting\Service\Cv\Ajax;

/**
 * Class AjaxFormEducation
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormEducation extends AjaxRepeaterFormAbstract
{
    protected string $formId = 'education';
    protected string $fieldName = 'education';

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

        if (empty($_POST['name'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Name of the educational institution is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['degree'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Degree is required', 'ecjobhunting'))
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
                ->setMessage(__('Work order is required', 'ecjobhunting'))
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
            'name' => $_POST['name'],
            'degree' => $_POST['degree'],
            'fields_of_study' => $_POST['fieldsOfStudy'] ?? '',
            'description' => $_POST['description'] ?? '',
            'period' => [
                'from' => $_POST['from'],
                'to' => isset($_POST['isInProgress']) && $_POST['isInProgress']  === 'true' ? '' : $_POST['to'],
                'is_in_progress' => isset($_POST['isInProgress']) && $_POST['isInProgress'] === 'true',
            ],
        ];
    }
}

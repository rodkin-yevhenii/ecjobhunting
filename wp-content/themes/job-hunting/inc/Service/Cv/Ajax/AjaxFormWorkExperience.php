<?php

namespace EcJobHunting\Service\Cv\Ajax;

/**
 * Class AjaxFormWorkExperience
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormWorkExperience extends AjaxRepeaterFormAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->fieldName = 'work_experience';
    }

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

        if (empty($_POST['from'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Date "From" is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['to'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Date "To" is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['position'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Position is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['company'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Company is required', 'ecjobhunting'))
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
            'job_position' => $_POST['position'],
            'company_name' => $_POST['company'],
            'period' => [
                'from' => $_POST['from'],
                'to' => $_POST['to'],
            ],
            'description' => $_POST['description'],
        ];
    }
}

<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormMoreInformation
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormMoreInformation extends AjaxFormAbstract
{
    protected string $formId = 'more-information';

    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_save_' . $this->formId . '_form', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_save_' . $this->formId . '_form', [$this, 'getCallback']);

        add_action('wp_ajax_load_' . $this->formId . '_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_' . $this->formId . '_form', [$this, 'getCallback']);
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

        $cvId = (int)$_POST['cvId'];
        $desiredSalary = $_POST['desired_salary'] ?? 0;
        $yearsOfExperience = $_POST['years_of_experience'] ?? '';
        $highestDegreeEarned = $_POST['highest_degree_earned'] ?? '';
        $veteranStatus = $_POST['veteran_status'] ?? '';
        $category = $_POST['category'] ?? '';

        if (!empty($category)) {
            $term = get_term_by('name', $category, 'job-category');

            if (!$term) {
                wp_create_term($category, 'job-category');
            }

            wp_set_post_terms($cvId, $term->term_id, 'job-category');
        } else {
            wp_set_post_terms($cvId, '', 'job-category');
        }

        update_field('salary', $desiredSalary, $cvId);
        update_field('years_of_experience', $yearsOfExperience, $cvId);
        update_field('degree_earned', $highestDegreeEarned, $cvId);
        update_field('veteran_status', $veteranStatus, $cvId);

        $candidate = UserService::getUser(get_current_user_id());

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            $this->formId,
            ['candidate' => $candidate, 'isOwner' => true]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }
}

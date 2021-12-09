<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\Cv\EmailConfirmation;
use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormSkills
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormSkills extends AjaxFormAbstract
{
    protected string $formId = 'skills';

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
        $skills = $_POST['skills'] ?? [];

        if (!empty($skills)) {
            $terms = [];

            foreach ($skills as $skill) {
                $term = get_term_by('name', $skill, 'skill');

                if (!$term) {
                    wp_create_term($skill, 'skill');
                }

                $terms[] = $skill;
            }

            wp_set_post_terms($cvId, $terms, 'skill');
        } else {
            wp_set_post_terms($cvId, '', 'skill');
        }

        $candidate = UserService::getUser($_POST['userId']);

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

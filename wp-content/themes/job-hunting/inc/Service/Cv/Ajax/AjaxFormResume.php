<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormResume
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormResume extends AjaxFormAbstract
{
    protected string $formId = 'resume';

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

        if (!function_exists('media_handle_upload') && current_user_can('edit_post', $cvId)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
        }

        $attachment_id = media_handle_upload('file', $cvId);

        if (is_wp_error($attachment_id)) {
            $this->response
                ->setStatus(500)
                ->setMessage(__('Resume loading failed', 'ecjobhunting'))
                ->send();
        }

        update_field('resume_file', $attachment_id, $cvId);

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
        delete_field('resume_file', $cvId);

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

    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_load_resume_file', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_load_resume_file', [$this, 'saveCallback']);

        add_action('wp_ajax_load_' . $this->formId . '_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_' . $this->formId . '_form', [$this, 'getCallback']);

        add_action('wp_ajax_remove_' . $this->formId . '_form', [$this, 'removeCallback']);
        add_action('wp_ajax_nopriv_remove_' . $this->formId . '_form', [$this, 'removeCallback']);
    }
}

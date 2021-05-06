<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormAboutMe
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormAboutMe extends AjaxFormAbstract
{
    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_save_about_me_form', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_save_about_me_form', [$this, 'getCallback']);

        add_action('wp_ajax_load_about_me_form', [$this, 'getCallback']);
        add_action('wp_ajax_nopriv_load_about_me_form', [$this, 'getCallback']);
    }

    /**
     * @inheritDoc
     */
    public function saveCallback(): void
    {
        if (empty($_POST['cvId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Cv ID is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['fullName'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Full name is required', 'ecjobhunting'))
                ->send();
        }

        if (empty($_POST['user'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('User is required', 'ecjobhunting'))
                ->send();
        }

        $cvId = (int)$_POST['cvId'];
        $data = [
            'full_name' => $_POST['fullName'],
            'headline' => $_POST['headline'] ?? '',
            'location' => $_POST['location'] ?? null,
            'zip_code' => $_POST['zip'] ?? '',
            'relocate' => ($_POST['isReadyToRelocate'] === 'false') ? false : true,
        ];

        if (!empty($data['location'])) {
            $term = get_term_by('name', $data['location'], 'location');

            if (!$term) {
                wp_create_term($data['location'], 'location');
            }

            wp_set_post_terms($cvId, $data['location'], 'location');
        }

        update_field('full_name', $data['full_name'], $cvId);
        update_field('headline', $data['headline'], $cvId);
        update_field('zip_code', $data['zip_code'], $cvId);
        update_field('relocate', $data['relocate'], $cvId);

        $candidate = UserService::getUser($_POST['userId']);

        ob_start();
        get_template_part(
            'template-parts/candidate/dashboard/blocs/block',
            'about-me',
            ['candidate' => $candidate]
        );

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setResponseBody(ob_get_clean())
            ->send();
    }
}

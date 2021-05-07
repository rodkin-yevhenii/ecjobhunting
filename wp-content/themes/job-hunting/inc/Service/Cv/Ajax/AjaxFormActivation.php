<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormActivation
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormActivation extends AjaxFormAbstract
{
    /**
     * @inheritDoc
     */
    protected function registerHooks(): void
    {
        add_action('wp_ajax_profile_activation', [$this, 'saveCallback']);
        add_action('wp_ajax_nopriv_profile_activation', [$this, 'saveCallback']);
    }

    /**
     * @inheritDoc
     */
    public function saveCallback(): void
    {
        if (empty($_POST['user'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('User is required', 'ecjobhunting'))
                ->send();
        }

        $candidate = UserService::getUser($_POST['userId']);
        $newCvStatus = $candidate->isPublished() ? 'draft' : 'publish';

        $result = wp_update_post(
            [
                'ID' => $candidate->getCvId(),
                'post_status' => $newCvStatus,
                'post_date_gmt' => date('Y-m-d H:i:s')
            ]
        );

        if (is_wp_error($result)) {
            $this->response
                ->setStatus(500)
                ->setMessage(__('Updating failed', 'ecjobhunting'))
                ->send();
        }

        if ('publish' === $newCvStatus) :
            $text = __(
                'Public: Your profile is publicly accessible.',
                'ecjobhunting'
            );
        else :
            $text = __(
                'Private: Your profile is not publicly accessible. However, it is viewable as a part of your
                    applications.',
                'ecjobhunting'
            );
        endif;

        $this->response
            ->setStatus(200)
            ->setMessage(__('Profile updated', 'ecjobhunting'))
            ->setData(
                [
                    'status' => $newCvStatus,
                    'message' => $text
                ]
            )
            ->send();
    }
}

<?php

namespace EcJobHunting\Service\Ajax;

use EcJobHunting\Entity\Company;
use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\Ajax\Callbacks\Autocomplete;
use EcJobHunting\Service\User\UserService;

/**
 * Class Ajax
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax
 */
class Ajax extends AjaxCallbackAbstract
{
    /**
     * Ajax constructor
     */
    public function __construct()
    {
        new Autocomplete();

        // Register Actions
        $this->actions['rate_candidate'] = 'rateEmployee';

        parent::__construct();
    }

    public function rateEmployee(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'rate_user')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['userId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('User ID is required')
                ->send();
        }

        if (empty($_POST['rating'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Rating value is required')
                ->send();
        }

        $userMeta = get_userdata($_POST['userId']);

        if ('candidate' !== $userMeta->roles[0]) {
            $this->response
                ->setStatus(204)
                ->setMessage('Incorrect User ID.')
                ->send();
        }

        $company = new Company(wp_get_current_user());
        $ratedCandidates = $company->getRatedCandidates();

        if (
            array_key_exists($_POST['userId'], $ratedCandidates)
            && $_POST['rating'] === $ratedCandidates[$_POST['userId']]
        ) {
            $this->response
                ->setStatus(204)
                ->setMessage('The candidate has already rated.')
                ->send();
        }

        $row = [
            'employee' => $_POST['userId'],
            'rating' => $_POST['rating']
        ];

        add_row('rated_candidates', $row, 'user_' . get_current_user_id());

        $this->response
            ->setStatus(200)
            ->send();
    }
}

<?php

namespace EcJobHunting\Service\Payments;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\User\UserService;

/**
 * Class PaymentService
 *
 * @package EcJobHunting\Service\Payments;
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 */
class PaymentService
{
    private EcResponse $response;

    public function __construct()
    {
        $this->response = new EcResponse();

        $this->registerSubscriptionsSettings();
        $this->registerPayPalSettings();
        $this->registerAcfFields();
        $this->registerHooks();
    }

    /**
     * Register settings fields for subscriptions plans.
     */
    private function registerSubscriptionsSettings(): void
    {
        new SubscriptionsPlans();
    }

    /**
     * Register settings fields for subscriptions plans.
     */
    private function registerPayPalSettings(): void
    {
        new PayPalService();
    }

    /**
     * Register subscriptions settings fields.
     */
    private function registerAcfFields(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        // User payments fields
        acf_add_local_field_group(
            [
                'key' => 'group_616c220ba6a26',
                'title' => 'Payments Settings',
                'fields' => [
                    [
                        'key' => 'field_5ff1f319b9bd4',
                        'label' => 'Is Activated',
                        'name' => 'is_activated',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => 'Premium',
                        'ui_off_text' => 'Standart',
                    ],
                    [
                        'key' => 'field_616c2250ed0da',
                        'label' => 'Is trial used?',
                        'name' => 'is_trial_used',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ],
                    [
                        'key' => 'field_next_payment',
                        'label' => 'Next payment date',
                        'name' => 'next_user_payment_date',
                        'type' => 'date_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'display_format' => 'F j, Y',
                        'return_format' => 'F j, Y',
                        'first_day' => 0,
                    ],
                ],
                'location' => [
                    [
                        [
                            'param' => 'user_role',
                            'operator' => '==',
                            'value' => 'employer',
                        ],
                    ],
                ],
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ]
        );
    }

    /**
     * Register hooks
     */
    private function registerHooks(): void
    {
        add_action("wp_ajax_activate_subscription_trial", [$this, 'activateSubscriptionTrial']);
        add_action("wp_ajax_nopriv_activate_subscription_trial", [$this, 'activateSubscriptionTrial']);
        add_action('wp', [$this, 'registerCronJobs']);
        add_action('deactivate_subscriptions', [$this, 'deactivateSubscriptions']);
    }

    /**
     * Activate trial period
     */
    public function activateSubscriptionTrial(): void
    {
        if (empty($_POST['subscriptionId'])) {
            $this->response
                ->setStatus(204)
                ->send();
        }

        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'activate_subscription_trial')) {
            $this->response
                ->setStatus(403)
                ->send();
        }

        if (!UserService::isEmployer()) {
            $this->response
                ->setStatus(403)
                ->send();
        }

        $subscriptionId = $_POST['subscriptionId'];
        $employer = UserService::getUser();
        $subscriptionPlan = SubscriptionsPlans::getSubscriptionPlan($subscriptionId);
        $trialPeriod = $_POST['trialPeriod'] ?? 1;

        if ($employer->isActivated() || $employer->isUsedTrial() || !$subscriptionPlan['is_trial_enabled']) {
            $this->response
                ->setStatus(403)
                ->send();
        }

        $timezone = new \DateTimeZone('UTC');
        $date = new \DateTime('now', $timezone);
        $date->modify("+$trialPeriod week");

        update_field('is_activated', true, 'user_' . $employer->getUserId());
        update_field('is_trial_used', true, 'user_' . $employer->getUserId());
        update_field('next_user_payment_date', $date->format('Ymd'), 'user_' . $employer->getUserId());
    }

    /**
     * Register cron jobs.
     */
    public function registerCronJobs(): void
    {
        if (!wp_next_scheduled('deactivate_subscriptions')) {
            wp_schedule_event(time(), 'twicedaily', 'deactivate_subscriptions');
        }
    }

    /**
     * Deactivate subscription for user whose next
     * payment date was yesterday.
     *
     * @throws \Exception
     */
    public function deactivateSubscriptions(): void
    {
        $timezone = new \DateTimeZone('UTC');
        $date = new \DateTime('now', $timezone);
        $date->modify('-1 day'); //yesterday

        $usersArgs = [
            'role' => 'employer',
            'meta_query' => [
                [
                    'key' => 'is_activated',
                    'value' => '1',
                ],
                [
                    'key' => 'next_user_payment_date',
                    'value' => $date->format('Ymd'),
                ]
            ],
            'fields' => 'ids',
        ];

        $usersList = get_users($usersArgs);

        foreach ($usersList as $userId) {
             update_field('is_activated', false, "user_$userId");
        }
    }
}

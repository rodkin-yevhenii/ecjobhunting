<?php

namespace EcJobHunting\Service\Payments;

use EcJobHunting\Entity\Company;
use EcJobHunting\Service\User\UserService;

/**
 * Class PayPalService
 *
 * Generate subscription button shortcode.
 * Update order meta.
 * Activate/deactivate subscription for user.
 *
 * @package EcJobHunting\Service\Payments;
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 */
class PayPalService
{
    /**
     * PayPalService construct
     */
    public function __construct()
    {
        if (!class_exists('WP_PAYPAL')) {
            return;
        }

        $this->registerHooks();
        $this->registerShortcodes();
        $this->registerAcfFields();
    }

    /**
     * Register PayPal hooks.
     */
    protected function registerHooks(): void
    {
        add_action('wp_paypal_ipn_processed', [$this, 'addPayPalOrderMeta']);
        add_filter('acf/load_field/key=field_order_subscription', [$this, 'subscriptionChoices']);
    }

    /**
     * Register PayPal shortcodes.
     */
    protected function registerShortcodes(): void
    {
        add_shortcode('subscription_btn', [$this, 'subscriptionsBtnShortcode']);
    }

    /**
     * Update order & user meta.
     *
     * @param array $ipn_response
     */
    public function addPayPalOrderMeta(array $ipn_response): void
    {
        if (empty($ipn_response) || empty($ipn_response['order_id'])) {
            return;
        }

        $orderId = $ipn_response['order_id'];
        $userId = (int) $ipn_response['custom'];
        $subscriptionId = (int) $ipn_response['item_number'];
        $subscriptionPlan = SubscriptionsPlans::getSubscriptionPlan($subscriptionId);
        $period = (int) $subscriptionPlan['duration'];
        $timezone = new \DateTimeZone('UTC');
        $date = new \DateTime($ipn_response['payment_date']);
        $date->setTimezone($timezone);
        $date->modify("+$period month");

        update_field('order_employer', $userId, $orderId);
        update_field('order_subscription', $subscriptionId, $orderId);
        update_field('is_activated', true, 'user_' . $userId);
        update_field('is_trial_used', true, 'user_' . $userId);
        update_field('next_user_payment_date', $date->format('Ymd'), 'user_' . $userId);
    }

    /**
     * Register subscriptions settings fields.
     */
    private function registerAcfFields(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(
            [
                'key' => 'group_paypal_oerder_meta',
                'title' => 'Order Meta',
                'fields' => [
                    [
                        'key' => 'field_6175263c3cd42',
                        'label' => 'Employer',
                        'name' => 'order_employer',
                        'type' => 'user',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],
                        'role' => [
                            0 => 'employer',
                        ],
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'id',
                    ],
                    [
                        'key' => 'field_order_subscription',
                        'label' => 'Subscription',
                        'name' => 'order_subscription',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],
                        'choices' => [
                        ],
                        'default_value' => false,
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ],
                    [
                        'key' => 'field_payment_date',
                        'label' => 'Payment date',
                        'name' => 'payment_date',
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
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'wp_paypal_order',
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
     * Generate select choices with created subscriptions plans.
     *
     * @param $field
     * @return array
     */
    public function subscriptionChoices($field)
    {
        $subscriptionsPlans = SubscriptionsPlans::getSubscriptionsPlans();

        foreach ($subscriptionsPlans as $plan) {
            $key = (int) $plan['id'];
            $val = $plan['title'];
            $field['choices'][$key] = $val;
        }

        return $field;
    }

    /**
     * Generate WP PayPal shortcode with attributes.
     *
     * @param array $atts
     * @return string
     */
    public function subscriptionsBtnShortcode(array $atts): string
    {
        if (
            ! UserService::isEmployer()
            || empty($atts['subscription_id'])
        ) {
            return '';
        }

        $employer = UserService::getUser();
        $subscriptionId = $atts['subscription_id'];
        $currentPlan = SubscriptionsPlans::getSubscriptionPlan($subscriptionId);

        if (empty($currentPlan)) {
            return '';
        }

        $shortcode = '[wp_paypal button="subscribe" ';
        $shortcode .= 'name="' . $currentPlan['title'] . '" ';

        // Trial
        if (
            !$employer->isUsedTrial()
            && $currentPlan['is_trial_enabled']
        ) {
            $shortcode .= 'a1="' . ($currentPlan['trial_price'] ?? 0) . '" ';
            $shortcode .= 'p1="' . ($currentPlan['trial_duration'] ?? 7) . '" ';
            $shortcode .= 't1="W" ';
        }

        // Subscription
        $shortcode .= 'a3="' . $currentPlan['price'] . '" ';
        $shortcode .= 'p3="' . ($currentPlan['duration'] ?? 1) . '" ';
        $shortcode .= 't3="M" ';
        $shortcode .= 'src="1" ';

        // Subscription ID
        $shortcode .= 'item_number="' . $subscriptionId . '" ';

        // User ID
        $shortcode .= 'custom="' . $employer->getUserId() . '" ';

        // End
        $shortcode .= 'no_shipping="1" target="_blank"]';

        ob_start();
        echo do_shortcode($shortcode);
        return ob_get_clean();
    }
}

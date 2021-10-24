<?php

namespace EcJobHunting\Service\Payments;

/**
 * Class PaymentService
 *
 * @package EcJobHunting\Service\Payments;
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 */
class PaymentService
{
    public function __construct()
    {
        $this->registerSubscriptionsSettings();
        $this->registerPayPalSettings();
        $this->registerAcfFields();
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
}

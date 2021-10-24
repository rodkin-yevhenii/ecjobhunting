<?php

namespace EcJobHunting\Service\Payments;

/**
 * Class SubscriptionsPlans
 *
 * Create and update options page with settings for
 * subscriptions plans.
 *
 * @package EcJobHunting\Service\Payments;
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 */
class SubscriptionsPlans
{
    public function __construct()
    {
        if (!class_exists('ACF')) {
            return;
        }

        $this->registerOptionPageSubpage();
        $this->registerHooks();
        $this->registerAcfFields();
    }

    /**
     * Register options page for payments settings.
     */
    private function registerOptionPageSubpage(): void
    {
        acf_add_options_sub_page(
            [
                'page_title' => __('Payments Settings'),
                'menu_title' => __('Payments Settings'),
                'menu_slug' => 'payments-settings',
                'capability' => 'edit_posts',
                'parent_slug' => 'site-settings',
            ]
        );
    }

    /**
     * Register hooks for working with ACF fields.
     */
    private function registerHooks(): void
    {
        add_filter('acf/load_field/key=field_payment_plan_id', [$this, 'disableField']);
        add_action('acf/save_post', [$this, 'generatePaymentsIds'], 5);
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
                'key' => 'group_payments_settings',
                'title' => 'Payments settings',
                'fields' => [
                    [
                        'key' => 'field_616cb51898784',
                        'label' => 'Subscription plan',
                        'name' => 'subscriptions_plan',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'collapsed' => '',
                        'min' => 1,
                        'max' => 1,
                        'layout' => 'block',
                        'button_label' => '',
                        'sub_fields' => [
                            [
                                'key' => 'field_payment_plan_id',
                                'label' => 'Payment plan unique ID',
                                'name' => 'id',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '20',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 1,
                                'max' => '',
                                'step' => '',
                            ],
                            [
                                'key' => 'field_616cb56098785',
                                'label' => 'Title',
                                'name' => 'title',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '80',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ],
                            [
                                'key' => 'field_616cb56c98786',
                                'label' => 'Description',
                                'name' => 'description',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ],
                            [
                                'key' => 'field_616cb7fce8576',
                                'label' => 'Subscription',
                                'name' => '',
                                'type' => 'tab',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'placement' => 'top',
                                'endpoint' => 0,
                            ],
                            [
                                'key' => 'field_616cb57798787',
                                'label' => 'Regular subscription price',
                                'name' => 'price',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 1,
                                'max' => '',
                                'step' => '',
                            ],
                            [
                                'key' => 'field_616cb5ed98788',
                                'label' => 'Regular subscription duration between each billing, months',
                                'name' => 'duration',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 1,
                                'max' => 24,
                                'step' => '',
                            ],
                            [
                                'key' => 'field_616cb812e8577',
                                'label' => 'Trial',
                                'name' => '',
                                'type' => 'tab',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'placement' => 'top',
                                'endpoint' => 0,
                            ],
                            [
                                'key' => 'field_616cb6f99878a',
                                'label' => 'Add trial period',
                                'name' => 'is_trial_enabled',
                                'type' => 'true_false',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '10',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'message' => '',
                                'default_value' => 0,
                                'ui' => 0,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ],
                            [
                                'key' => 'field_616cb63398789',
                                'label' => 'Trial period price',
                                'name' => 'trial_price',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => [
                                    [
                                        [
                                            'field' => 'field_616cb6f99878a',
                                            'operator' => '==',
                                            'value' => '1',
                                        ]
                                    ]
                                ],
                                'wrapper' => [
                                    'width' => '45',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => 0,
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 0,
                                'max' => '',
                                'step' => '',
                            ],
                            [
                                'key' => 'field_616cb7509878b',
                                'label' => 'Trial period duration, weeks',
                                'name' => 'trial_duration',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => [
                                    [
                                        [
                                            'field' => 'field_616cb6f99878a',
                                            'operator' => '==',
                                            'value' => '1',
                                        ]
                                    ]
                                ],
                                'wrapper' => [
                                    'width' => '45',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => 1,
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 1,
                                'max' => 53,
                                'step' => '',
                            ],
                        ],
                    ]
                ],
                'location' => [
                    [
                        [
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'payments-settings',
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
     * Set readonly attribute for field.
     *
     * @param array $field
     *
     * @return array
     */
    public function disableField(array $field): array
    {
        $field['readonly'] = true;
        return $field;
    }

    /**
     * Generate ID for payments plans.
     */
    public function generatePaymentsIds(): void
    {
        $repeaterKey = 'field_616cb51898784';

        if (
            !is_admin()
            || empty($_GET['page'])
            || 'payments-settings' !== $_GET['page']
            || empty($_POST['acf'][$repeaterKey])
        ) {
            return;
        }

        $time = time();

        foreach ($_POST['acf'][$repeaterKey] as &$row) {
            if (empty($row['field_payment_plan_id'])) {
                $row['field_payment_plan_id'] = $time++;
            }
        }
    }

    /**
     * Get created subscriptions plans.
     *
     * @return array
     */
    public static function getSubscriptionsPlans(): array
    {
        return get_field('subscriptions_plan', 'option');
    }

    /**
     * Get subscription plan by ID.
     *
     * @param int $subscriptionId
     * @return array
     */
    public static function getSubscriptionPlan(int $subscriptionId): array
    {
        $subscriptionsPlans = self::getSubscriptionsPlans();

        if (empty($subscriptionsPlans) || !is_array($subscriptionsPlans)) {
            return [];
        }

        foreach ($subscriptionsPlans as $plan) {
            if ($subscriptionId === (int) $plan['id']) {
                return $plan;
            }
        }

        return [];
    }
}

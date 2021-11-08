<?php

namespace EcJobHunting\Service\Email;

use EcJobHunting\Entity\Email;

class EmailService
{
    public function __invoke()
    {
        $this->registerAcfFields();
        $this->registerOptionsPage();
        add_filter('comment_moderation_recipients', [$this, 'disableCommentsNotification'], 11);
        add_filter('comment_notification_recipients', [$this, 'disableCommentsNotification'], 11);
    }

    private function registerOptionsPage(): void
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(
                [
                    'page_title' => __('Email marketing settings'),
                    'menu_title' => __('Emails Settings'),
                    'menu_slug' => 'emails-settings',
                    'capability' => 'edit_posts',
                    'parent_slug' => 'site-settings',
                ]
            );
        }
    }

    public static function sendEmail(Email $email): bool
    {
        return wp_mail(
            $email->getToEmail(),
            $email->getSubject(),
            $email->getMessage(),
            $email->getHeaders()
        );
    }

    public function registerAcfFields(): void
    {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(
                [
                    'key' => 'group_6175f34e796d4',
                    'title' => 'Email Settings',
                    'fields' => [
                        [
                            'key' => 'field_6186e15b79bf6',
                            'label' => 'Email',
                            'name' => 'from_email',
                            'type' => 'email',
                            'instructions' => 'Used for "from" email header',
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
                        ],
                        [
                            'key' => 'field_6186e1b979bf7',
                            'label' => 'User name',
                            'name' => 'from_user_name',
                            'type' => 'text',
                            'instructions' => 'Used for "from" email header',
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
                            'maxlength' => '',
                        ],
                        [
                            'key' => 'field_6186df9a79bf5',
                            'label' => 'Emails Templates',
                            'name' => 'email_templates',
                            'type' => 'group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => [
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ],
                            'layout' => 'block',
                            'sub_fields' => [
                                [
                                    'key' => 'field_6186e25179bf8',
                                    'label' => 'Apply message',
                                    'name' => 'apply_message',
                                    'type' => 'textarea',
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
                                    'maxlength' => '',
                                    'rows' => 8,
                                    'new_lines' => 'br',
                                ],
                                [
                                    'key' => 'field_6186e34679bfa',
                                    'label' => 'New Chat Message for Employer',
                                    'name' => 'new_chat_message_for_employer',
                                    'type' => 'textarea',
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
                                    'maxlength' => '',
                                    'rows' => 8,
                                    'new_lines' => 'br',
                                ],
                                [
                                    'key' => 'field_61880c82dc93e',
                                    'label' => 'New Chat Message for Employee',
                                    'name' => 'new_chat_message_for_employee',
                                    'type' => 'textarea',
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
                                    'maxlength' => '',
                                    'rows' => 8,
                                    'new_lines' => 'br',
                                ],
                            ],
                        ],
                    ],
                    'location' => [
                        [
                            [
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => 'emails-settings',
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

    public function disableCommentsNotification(array $emails): array
    {
        return [];
    }
}

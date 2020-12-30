<?php

namespace EcJobHunting\Admin\Registry;

class AcfFields
{
    public function __construct()
    {
        if (function_exists('acf_add_local_field_group')) {
            $this->vacancyFields();
            $this->siteSettingsFields();
        }
    }

    private function vacancyFields()
    {
        acf_add_local_field_group(
            [
                'key' => 'group_5fecd546cb707',
                'title' => 'Vacancy Details',
                'fields' => [
                    [
                        'key' => 'field_5fecd57ec26b9',
                        'label' => 'Benefits',
                        'name' => 'benefits',
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
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'New Benefit',
                        'sub_fields' => [
                            [
                                'key' => 'field_5fecd64bc26ba',
                                'label' => 'Benefit',
                                'name' => 'benefit',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => [
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ],
                                'default_value' => 'Medical Insurance',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => 118,
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_5fecd6a9c26bb',
                        'label' => 'Compensation Range',
                        'name' => 'compensation_range',
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
                                'key' => 'field_5fecd6e2c41c7',
                                'label' => 'From',
                                'name' => 'from',
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
                                'key' => 'field_5fecd6efc41c8',
                                'label' => 'To',
                                'name' => 'to',
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
                        ],
                    ],
                    [
                        'key' => 'field_5fecd722c41c9',
                        'label' => 'Street Address',
                        'name' => 'street_address',
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
                        'key' => 'field_5fecd75ac41ca',
                        'label' => 'Hiring Company',
                        'name' => 'hiring_company',
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
                        'key' => 'field_5fecd775c41cb',
                        'label' => 'Why Work at This Company',
                        'name' => 'why_work_at_this_company',
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
                        'key' => 'field_5fecd781c41cc',
                        'label' => 'Hiring Company Description',
                        'name' => 'hiring_company_description',
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
                        'key' => 'field_5fecd79fc41cd',
                        'label' => 'Send New Candidates To',
                        'name' => 'send_new_candidates_to',
                        'type' => 'checkbox',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'choices' => [
                        ],
                        'allow_custom' => 0,
                        'default_value' => [
                        ],
                        'layout' => 'vertical',
                        'toggle' => 0,
                        'return_format' => 'value',
                        'save_custom' => 0,
                    ],
                    [
                        'key' => 'field_5fecd7d5c41ce',
                        'label' => 'Alert emails with new candidates will be sent to',
                        'name' => 'emails_to_inform',
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
                        'key' => 'field_5fecd839c41cf',
                        'label' => 'Additional options',
                        'name' => 'additional_options',
                        'type' => 'checkbox',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'choices' => [
                            'covid' => 'Add a FREE label indicating this job is extending offers during the COVID-19 crisis',
                            'closest' => 'Only show me candidates within 100 miles of this job\'s location',
                            'accept_all' => 'Accept applications without a resume',
                        ],
                        'allow_custom' => 0,
                        'default_value' => [
                            0 => 'covid',
                            1 => 'closest',
                            2 => 'accept_all',
                        ],
                        'layout' => 'vertical',
                        'toggle' => 0,
                        'return_format' => 'value',
                        'save_custom' => 0,
                    ],
                ],
                'location' => [
                    [
                        [
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'vacancy',
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

    private function siteSettingsFields()
    {
        acf_add_local_field_group(
            [
                'key' => 'group_5fecf4a46d935',
                'title' => 'General theme settings',
                'fields' => [
                    [
                        'key' => 'field_5fecf67f428a4',
                        'label' => 'Header Settings',
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
                        'key' => 'field_5fecf4b8b7889',
                        'label' => 'Logo',
                        'name' => 'logo',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                        'return_format' => 'url',
                        'preview_size' => 'full',
                        'library' => 'uploadedTo',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ],
                ],
                'location' => [
                    [
                        [
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'site-settings',
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
<?php

namespace EcJobHunting\Admin\Registry;

class CustomTaxonomies
{
    public function __construct()
    {
        $this->registerCompany();
        $this->registerType();
        $this->registerSkills();
        $this->registerLocation();
    }

    private function registerCompany()
    {
        register_taxonomy(
            'company',
            ['vacancy'],
            [
                'label' => 'Company',
                'labels' => [
                    'name' => 'Companies',
                    'singular_name' => 'Company',
                    'add_new' => 'Add Company',
                    'add_new_item' => 'Create new Company',
                    'edit_item' => 'Edit Company',
                    'new_item' => 'New Company',
                    'view_item' => 'View Company',
                    'search_items' => 'Find Companies',
                    'not_found' => 'Companies not found',
                    'not_found_in_trash' => 'Companies not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Companies',

                ],
                'description' => '',
                'public' => true,
                'hierarchical' => false,
                'rewrite' => true,
                'capabilities' => [],
                'meta_box_cb' => null,
                'show_admin_column' => false,
                'show_in_rest' => null,
                'rest_base' => null,
            ]
        );
    }

    private function registerType()
    {
        register_taxonomy(
            'type',
            ['vacancy', 'cv'],
            [
                'label' => 'Employment Type',
                'labels' => [
                    'name' => 'Employment Type',
                    'singular_name' => 'Employment Type',
                    'add_new' => 'Add Type',
                    'add_new_item' => 'Create new Type',
                    'edit_item' => 'Edit Type',
                    'new_item' => 'New Type',
                    'view_item' => 'View Type',
                    'search_items' => 'Find Types',
                    'not_found' => 'Types not found',
                    'not_found_in_trash' => 'Types not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Types',

                ],
                'description' => '',
                'public' => true,
                'hierarchical' => false,
                'rewrite' => true,
                'capabilities' => [],
                'meta_box_cb' => null,
                'show_admin_column' => false,
                'show_in_rest' => null,
                'rest_base' => null,
            ]
        );
    }

    private function registerSkills()
    {
        register_taxonomy(
            'skill',
            ['vacancy', 'cv'],
            [
                'label' => 'Skills',
                'labels' => [
                    'name' => 'Skills',
                    'singular_name' => 'Skill',
                    'add_new' => 'Add Skill',
                    'add_new_item' => 'Create new Skill',
                    'edit_item' => 'Edit Skill',
                    'new_item' => 'New Skill',
                    'view_item' => 'View Skill',
                    'search_items' => 'Find Skill',
                    'not_found' => 'Skills not found',
                    'not_found_in_trash' => 'Skills not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Skills',

                ],
                'description' => '',
                'public' => true,
                'hierarchical' => false,
                'rewrite' => true,
                'capabilities' => [],
                'meta_box_cb' => null,
                'show_admin_column' => false,
                'show_in_rest' => null,
                'rest_base' => null,
            ]
        );
    }

    private function registerLocation()
    {
        register_taxonomy(
            'location',
            ['vacancy', 'cv'],
            [
                'label' => 'Locations',
                'labels' => [
                    'name' => 'Locations',
                    'singular_name' => 'Location',
                    'add_new' => 'Add Location',
                    'add_new_item' => 'Create new Location',
                    'edit_item' => 'Edit Location',
                    'new_item' => 'New Location',
                    'view_item' => 'View Location',
                    'search_items' => 'Find Location',
                    'not_found' => 'Locations not found',
                    'not_found_in_trash' => 'Locations not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Locations',

                ],
                'description' => '',
                'public' => true,
                'hierarchical' => false,
                'rewrite' => true,
                'capabilities' => [],
                'meta_box_cb' => null,
                'show_admin_column' => false,
                'show_in_rest' => null,
                'rest_base' => null,
            ]
        );
    }
}
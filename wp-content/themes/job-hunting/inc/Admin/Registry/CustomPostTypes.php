<?php

namespace EcJobHunting\Admin\Registry;

class CustomPostTypes
{
    public function __construct()
    {
        $this->registerVacancy();
        $this->registerResume();
        $this->registerChat();
    }

    private function registerVacancy()
    {
        register_post_type(
            'vacancy',
            [
                'labels' => [
                    'name' => 'Vacancies',
                    'singular_name' => 'Vacancy',
                    'add_new' => 'Add Vacancy',
                    'add_new_item' => 'Create new Vacancy',
                    'edit_item' => 'Edit Vacancy',
                    'new_item' => 'New Vacancy',
                    'view_item' => 'View Vacancy',
                    'search_items' => 'Find Vacancies',
                    'not_found' => 'Vacancies not found',
                    'not_found_in_trash' => 'Vacancies not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Vacancies',

                ],
                'public' => true,
                'has_archive' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'rest_base' => 'vacancies',
                'show_in_nav_menus' => true,
                'menu_icon' => 'dashicons-admin-post',
                'rewrite' => ['feeds' => false],
                'supports' => [
                    'editor',
                    'custom-fields',
                    'author',
                    'comments',
                ],
            ]
        );
    }

    private function registerResume()
    {
        register_post_type(
            'cv',
            [
                'labels' => [
                    'name' => 'CV',
                    'singular_name' => 'CV',
                    'add_new' => 'Add CV',
                    'add_new_item' => 'Create new CV',
                    'edit_item' => 'Edit CV',
                    'new_item' => 'New CV',
                    'view_item' => 'View CV',
                    'search_items' => 'Find CVs',
                    'not_found' => 'CVs not found',
                    'not_found_in_trash' => 'CVs not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'CVs',

                ],
                'public' => true,
                'has_archive' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'rest_base' => 'cvs',
                'show_in_nav_menus' => true,
                'menu_icon' => 'dashicons-admin-post',
                'rewrite' => ['feeds' => false],
                'supports' => [
                    'editor',
                    'custom-fields',
                    'author',
                    'comments',
                ],
            ]
        );
    }

    private function registerChat()
    {
        register_post_type(
            'chat',
            [
                'labels' => [
                    'name' => 'Chat',
                    'singular_name' => 'Chat',
                    'add_new' => 'Create Chat',
                    'add_new_item' => 'Create new Chat',
                    'edit_item' => 'Edit Chat',
                    'new_item' => 'New Chat',
                    'view_item' => 'View Chat',
                    'search_items' => 'Find Chats',
                    'not_found' => 'Chats not found',
                    'not_found_in_trash' => 'Chats not found in trash',
                    'parent_item_colon' => '',
                    'menu_name' => 'Chats',

                ],
                'public' => true,
                'has_archive' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'rest_base' => 'chats',
                'show_in_nav_menus' => true,
                'menu_icon' => 'dashicons-admin-post',
                'rewrite' => ['feeds' => false],
                'supports' => [
                    'custom-fields',
                    'author',
                    'comments',
                ],
            ]
        );
    }
}

<?php


namespace EcJobHunting\Admin\Registry;


class ThemeSettings
{
    public function __construct()
    {
    }

    public static function afterThemeSetup()
    {
        register_nav_menus(
            [
                'top' => 'Top Bar',
                'primary' => 'Primary',
            ]
        );
    }

    public static function init()
    {
        if (function_exists('acf_add_options_page')) {
            $option_page = acf_add_options_page(
                [
                    'page_title' => __('Site Settings'),
                    'menu_title' => __('Site Settings'),
                    'menu_slug' => 'site-settings',
                    'capability' => 'edit_posts',
                    'redirect' => false,
                ]
            );
        }
    }
}
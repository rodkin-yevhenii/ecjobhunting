<?php

namespace EcJobHunting\Admin\Registry;

class ThemeSettings
{
    public function __construct()
    {
    }

    public static function afterThemeSetup()
    {
        static::registerMenu();
        //Disable Admin panel for non admin users
        static::disableAdminBar();
        static::registerImageSizes();
    }

    private static function registerMenu()
    {
        register_nav_menus(
            [
                'top' => 'Top Bar',
                'employer' => 'Employer',
                'candidate' => 'Job Seeker',
                'footer-left' => 'Footer left',
                'footer-center' => 'Footer center',
                'footer-right' => 'Footer right',
            ]
        );
    }

    private static function disableAdminBar()
    {
        if (!current_user_can('administrator') && !wp_doing_ajax()) {
            show_admin_bar(false);
            add_action(
                'admin_init',
                function () {
                    if (is_admin()) {
                        wp_redirect(site_url('dashboard'), 301);
                    }
                }
            );
        }
    }

    private static function registerImageSizes(): void
    {
        add_image_size('card-vacancy-logo', 9999, 40, false);
        add_image_size('single-vacancy-logo', 255, 255, false);
        add_image_size('results-image', 65, 65, false);
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

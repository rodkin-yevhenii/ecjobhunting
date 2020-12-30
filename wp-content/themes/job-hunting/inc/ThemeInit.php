<?php

namespace EcJobHunting;

use EcJobHunting\Admin\AdminInit;
use EcJobHunting\Front\FrontInit;
use EcJobHunting\Front\SiteSettings;
use EcJobHunting\Service\Widget\WidgetInit;

final class ThemeInit
{
    private static $instance;

    private function __construct()
    {
        $this->registerAdminHooks();
        $this->registerFrontHooks();
        $this->registerWidgets();
        $this->afterThemeSetup();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    private function registerAdminHooks()
    {
        add_action('init', new AdminInit());
        add_action('acf/init', ['EcJobHunting\Admin\Registry\ThemeSettings', 'init']);
    }

    private function registerFrontHooks()
    {
        add_action('init', new FrontInit());
    }

    private function registerWidgets()
    {
        add_action('widgets_init', new WidgetInit());
    }

    private function afterThemeSetup(){
        add_action('after_setup_theme', ['EcJobHunting\Admin\Registry\ThemeSettings', 'afterThemeSetup']);
    }
}
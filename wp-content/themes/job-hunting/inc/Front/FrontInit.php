<?php

namespace EcJobHunting\Front;

use EcJobHunting\Front\Registry\Assets;

class FrontInit
{
    public function __invoke()
    {
        add_theme_support('title-tag');
        add_action('wp_enqueue_scripts', new Assets());
        add_action('acf/init', [$this, 'init']);
        add_filter('walker_nav_menu_start_el', [$this, 'addClassName'], 10, 4);
        add_filter('nav_menu_css_class', [$this, 'setActiveStateForItem'], 10, 4);
        add_filter('body_class', [$this, 'resetDefaultClasses'], 10, 2);
        add_filter(
            'excerpt_more',
            function ($more) {
                return '...';
            }
        );
        add_filter(
            'excerpt_length',
            function () {
                return 30;
            }
        );
    }

    public function addClassName($item_output, $item, $depth, $args)
    {
        if ($item->current && $args->theme_location === 'top') {
            return str_replace('href', 'class="active" href', $item_output);
        }
        return $item_output;
    }


    public function setActiveStateForItem($classes, $item, $args, $depth)
    {
        if ($item->current && ($args->theme_location === 'employer' || $args->theme_location === 'candidate')) {
            return ['profile-menu', 'active-item'];
        }

        return ['profile-menu'];
    }

    public function resetDefaultClasses($classes)
    {
        $key = array_search('page', $classes);
        if ($key !== false) {
            unset($classes[$key]);
        }
        return $classes;
    }
}
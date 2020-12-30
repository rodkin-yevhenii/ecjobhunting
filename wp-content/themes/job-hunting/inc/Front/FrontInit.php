<?php

namespace EcJobHunting\Front;

use EcJobHunting\Front\Registry\Assets;

class FrontInit
{
    public function __invoke()
    {
        add_action('wp_enqueue_scripts', new Assets());
        add_action('acf/init', [$this, 'init']);
    }

}
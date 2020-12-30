<?php

require_once get_stylesheet_directory() . "/vendor/autoload.php";
/**
 * Define constants
 */
if(!defined('IMG_URI')){
    define('IMG_URI', get_stylesheet_directory_uri() . '/assets/public/images/');
}

use EcJobHunting\Front\SiteSettings;
use EcJobHunting\ThemeInit;

// basic functional
$themeInit = ThemeInit::getInstance();

// global site settings
global $ec_site;
$ec_site = new SiteSettings();


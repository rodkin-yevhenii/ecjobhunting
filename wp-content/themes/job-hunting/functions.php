<?php

require_once get_stylesheet_directory() . "/vendor/autoload.php";
/**
 * Define constants
 */
if (!defined('IMG_URI')) {
    define('IMG_URI', get_stylesheet_directory_uri() . '/assets/public/images/');
}
if (!defined('SIGNUP_URL')) {
    define('SIGNUP_URL', site_url('/signup/'));
}
if (!defined('CANDIDATE_PROFILE_URL')) {
    define('CANDIDATE_PROFILE_URL', site_url('/candidate/'));
}
if (!defined('EMPLOYER_PROFILE_URL')) {
    define('EMPLOYER_PROFILE_URL', site_url('/employer/'));
}

use EcJobHunting\Front\SiteSettings;
use EcJobHunting\ThemeInit;

// basic functional
$themeInit = ThemeInit::getInstance();

// global site settings
global $ec_site;
$ec_site = new SiteSettings();


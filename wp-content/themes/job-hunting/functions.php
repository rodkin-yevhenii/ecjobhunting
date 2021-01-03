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

//// HELPERS ////

function getEnvelopIcon(){
    return "<img src='". IMG_URI . "icons/envelope.png' alt='Envelop Icon' />";
}

function getPhoneIcon(){
    return "<img src='". IMG_URI . "icons/mobile.png' alt='Phone Icon' />";
}

function getTwitterIcon(){
    return "<img src='". IMG_URI . "icons/twitter.png' alt='twitter Icon' />";
}

function getLinkedinIcon(){
    return "<img src='". IMG_URI . "icons/instagram.png' alt='Linkedin Icon' />";
}
function getFacebookIcon(){
    return "<img src='". IMG_URI . "icons/facebook.png' alt='facebook Icon' />";
}

function getDatePeriod($period){
    return sprintf(
        '%1$s - %2$s',
        date(
            'F Y',
            strtotime($period['from'])
        ),
        date(
            'F Y',
            strtotime($period['to'])
        )
    );
}
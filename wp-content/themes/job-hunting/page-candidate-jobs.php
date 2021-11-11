<?php

/**
 * Template Name: Candidate jobs
 */

use EcJobHunting\Service\User\UserService;

if (!UserService::isCandidate()) {
    wp_redirect(home_url('dashboard'));
}

get_header();
get_template_part('template-parts/candidate/jobs');
get_footer();

<?php

/**
 * Template Name: My candidates
 */

use EcJobHunting\Service\User\UserService;

if (!UserService::isCandidate() && !UserService::isEmployer()) {
    wp_redirect(get_post_type_archive_link('vacancy'), 301);
    exit();
}

get_header();
if (UserService::isCandidate()) {
    get_template_part('template-parts/candidate/dashboard');
} else {
    get_template_part('template-parts/employer/dashboard', 'candidates');
}
get_footer();

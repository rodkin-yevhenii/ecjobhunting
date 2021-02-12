<?php
/**
 * Template Name: My candidates
 */

use EcJobHunting\Service\User\UserService;

get_header();
if (UserService::isCandidate()) {
    get_template_part('template-parts/candidate/dashboard');
} elseif (UserService::isEmployer()) {
    get_template_part('template-parts/employer/dashboard', 'candidates');
} else {
    wp_redirect(get_post_type_archive_link('vacancy'), 301);
}
get_footer();

<?php

use EcJobHunting\Service\User\UserService;

if (!is_user_logged_in() || !UserService::isCandidate() && !UserService::isEmployer()) {
    wp_redirect('/', 301);
    wp_die();
}

get_header();

if (UserService::isCandidate()) {
    get_template_part('template-parts/candidate/dashboard/dashboard');
} else {
    $type = $_GET['type'] ?? '';
    switch ($type) {
        case 'jobs':
            get_template_part('template-parts/employer/dashboard', 'jobs');
            break;
        case 'candidates':
            get_template_part('template-parts/employer/dashboard', 'candidates');
            break;
        default:
            get_template_part('template-parts/employer/dashboard');
            break;
    }
}
get_footer();

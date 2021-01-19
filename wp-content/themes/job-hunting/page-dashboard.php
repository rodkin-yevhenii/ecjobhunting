<?php

use EcJobHunting\Service\User\UserService;

get_header();

if (UserService::isCandidate()) {
    get_template_part('template-parts/candidate/dashboard');
} elseif (UserService::isEmployer()) {
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
} else {
    wp_redirect('/', 301);
}
get_footer();

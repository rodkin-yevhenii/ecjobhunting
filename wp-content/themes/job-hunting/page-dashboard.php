<?php

use EcJobHunting\Service\User\UserService;

get_header();

if(UserService::isCandidate()){
    get_template_part('template-parts/candidate/dashboard');
}elseif(UserService::isEmployer()){
    get_template_part('template-parts/employer/dashboard');
} else{
    wp_redirect('/', 301);

}
get_footer();

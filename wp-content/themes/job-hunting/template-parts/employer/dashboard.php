<?php

global $post, $ec_site;

use EcJobHunting\Entity\Company;

$company = new Company(wp_get_current_user());
if (!$company) {
    return;
}
$candidates = $company->getCandidates();
?>
<div class="page">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h1>Rate Latest Candidates</h1>
                <p class="mb-md-4">View the candidates who most recently applied to your job. Rate your candidates to
                    help us find more matches.</p>
                <h3>Candidates</h3>
                <div class="candidate-list">
                    <?php
                    foreach ($candidates as $candidate):
                        $post = $candidate->getCvId();
                        setup_postdata($post);
                        get_template_part('template-parts/candidate/card', 'featured', ['candidate' => $candidate]);
                    endforeach;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Discover</h2>
                <p>We're here to help.</p>
            </div>
            <div class="col-12 col-md-6 col-xl-4 mt-4 mt-md-0 dashboard-discover">
                <div class="dashboard-discover-image mb-2"><?php
                    echo getActivateProfileIcon(); ?></div>
                <strong class="color-primary text-regular text-large d-block">
                    <?php
                    if ($company->isActivated()):
                        _e('Your profile is activated', 'ecjobhunting');
                    else:
                        _e('Activate your Account', 'ecjobhunting');
                    endif; ?>
                </strong>
                <span><?php
                    _e('We\'re here to help.', 'ecjobhunting'); ?></span>
            </div>
            <div class="col-12 col-md-3 mt-4 mt-md-0"><strong
                        class="text-regular text-large d-block">Questions?</strong><span>Contact your Hiring Specialist.</span>
            </div>
            <div class="col-12 col-md-3"><a
                        class="btn btn-outline-secondary d-block mt-3 mt-md-0 d-xl-inline-block px-xl-5" href="<?php
                echo $ec_site->getContactUsUrl(); ?>">Contact
                    Now</a></div>
        </div>
        <div class="row dashboard-activity mt-5">
            <div class="col-12">
                <h2>Account Activity</h2>
            </div>
            <div class="col-6 col-md-3"><strong class="text-huge text-regular"><?php
                    echo $company->getJobPosted(); ?></strong>
                <p class="text-large my-2">Jobs posted</p><a class="color-primary" href="<?php
                echo get_the_permalink() . '?type=jobs'; ?>">View report</a>
            </div>
            <div class="col-6 col-md-3"><strong class="text-huge text-regular"><?php
                    echo $company->getJobVisitors(); ?></strong>
                <p class="text-large my-2">Job visitors</p>
                <?php
                if ($company->isActivated()): ?>
                    <a class="color-primary" href="<?php
                    echo get_the_permalink() . '?type=visitors'; ?>">View report</a>
                <?php
                endif; ?>
            </div>
            <div class="col-6 col-md-3 mt-4 mt-md-0"><strong class="text-huge text-regular"><?php
                    echo count($company->getCandidates()); ?></strong>
                <p class="text-large my-2">Candidates received</p><a class="color-primary" href="<?php
                echo get_the_permalink() . '?type=candidates'; ?>">View report</a>
            </div>
            <div class="col-6 col-md-3 mt-4 mt-md-0"><strong class="text-huge text-regular">$0.00</strong>
                <p class="text-large my-2">Avaible credits</p>
                <?php
                if ($company->isActivated()): ?>
                    <a class="color-primary" href="<?php
                    echo get_the_permalink() . '?type=credits'; ?>">View report</a>
                <?php
                endif; ?>
            </div>
        </div>
    </div>
</div>
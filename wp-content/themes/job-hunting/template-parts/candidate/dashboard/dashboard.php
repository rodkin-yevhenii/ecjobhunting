<?php

use EcJobHunting\Service\User\UserService;

$currentUserId = get_current_user_id();
$error = '';

try {
    do_action('candidate_email_verification');
    do_action('ecjob-save-new-data', $currentUserId);
} catch (Exception $exception) {
    $error = $exception->getMessage();
}

$candidate = UserService::getUser($currentUserId);
$isOwner = $currentUserId === $candidate->getUserId();
//$isOwner = false;

?>
<div
    id="candidate"
    class="container"
    data-user-id="<?php echo $currentUserId; ?>"
    data-cv-id="<?php echo $candidate->getCvId(); ?>"
>
    <div class="row d-md-block d-xl-flex my-3 my-md-4 my-xl-5 clearfix">
        <div class="col-12 order-0 col-md-5 float-md-left col-xl-3">
            <div class="profile-item" id="about-me-holder">
                <?php get_template_part(
                    'template-parts/candidate/dashboard/blocs/block',
                    'about-me',
                    ['candidate' => $candidate, 'isOwner' => $isOwner]
                ); ?>
            </div>
            <div class="profile-item" id="contacts-holder">
                <?php get_template_part(
                    'template-parts/candidate/dashboard/blocs/block',
                    'contact-information',
                    ['candidate' => $candidate, 'isOwner' => $isOwner]
                ); ?>
            </div>
            <div class="profile-item" id="websites-holder">
                <?php get_template_part(
                    'template-parts/candidate/dashboard/blocs/block',
                    'websites',
                    ['candidate' => $candidate, 'isOwner' => $isOwner]
                ); ?>
            </div>
        </div>
        <div class="col-12 order-2 col-md-7 float-md-right col-xl-6 order-xl-1 mb-5">
            <?php
            if ($error) :
                $classes = 'alert-danger';
            else :
                $classes = 'd-none';
            endif;
            ?>
            <div id="profile-notification" class="text-center p-2 mt-4 <?php echo $classes; ?>">
                <?php echo $error; ?>
            </div>
            <div class="profile-activation">
                <?php get_template_part(
                    'template-parts/candidate/dashboard/blocs/block',
                    'activation',
                    ['candidate' => $candidate, 'isOwner' => $isOwner]
                ); ?>
            </div>
            <?php if ($isOwner || !empty($candidate->getSummary())) : ?>
                <div id="executive-summary-holder" class="profile-item">
                    <?php get_template_part(
                        'template-parts/candidate/dashboard/blocs/block',
                        'executive-summary',
                        ['candidate' => $candidate, 'isOwner' => $isOwner]
                    ); ?>
                </div>
            <?php endif;

            if ($isOwner || !empty($candidate->getExperience())) : ?>
                <div id="work-experience-holder" class="profile-item">
                    <?php get_template_part(
                        'template-parts/candidate/dashboard/blocs/block',
                        'work-experience',
                        ['candidate' => $candidate, 'isOwner' => $isOwner]
                    ); ?>
                </div>
            <?php endif;

            if ($isOwner || !empty($candidate->getEducation())) : ?>
                <div id="education-holder" class="profile-item">
                    <?php get_template_part(
                        'template-parts/candidate/dashboard/blocs/block',
                        'education',
                        ['candidate' => $candidate, 'isOwner' => $isOwner]
                    ); ?>
                </div>
            <?php endif; ?>
            <div class="profile-item">
                <div class="profile-header">
                    <h2 class="no-decor">References</h2>
                </div>
                <p>Hiring managers prefer candidates with references! Ask a former co-worker, manager, teacher or
                    friend to write a reference for you.</p>
                <button class="btn btn-outline-secondary btn-full">Request References</button>
            </div>
            <div class="profile-item">
                <p><a href="#">Add Objective</a></p>
                <p><a href="#">Add Achievements</a></p>
                <p><a href="#">Add Certificates and Licenses</a></p>
                <p><a href="#">Add Associations</a></p>
                <p><a href="#">Add Skills</a></p>
            </div>
            <div class="profile-item">
                <h2 class="no-decor">More Information</h2>
                <p><a href="#">Add Desired Salary</a></p>
                <p><a href="#">Add Years of Experience</a></p>
                <p><a href="#">Add Highest Degree Earned</a></p>
                <p><a href="#">Add Industry</a></p>
                <p><a href="#">Add Veteran Status</a></p>
            </div>
        </div>
        <div class="col-12 order-1 col-md-5 float-md-left col-xl-3 order-xl-2">
            <div class="profile-progress">
                <div class="profile-progressbar"><span style="width: 37%;"></span></div>
                <div class="profile-header">
                    <h2 class="no-decor">Your Profile is Incomplete</h2>
                </div>
                <p>Finish your profile to unlock better job matching and stand out to hiring managers!</p>
                <ul>
                    <li>
                        <div class="icon-check active"></div>
                        <span>Register with EcJobHunting</span>
                    </li>
                    <li>
                        <div class="icon-check"></div>
                        <span>Add Resume</span>
                    </li>
                    <li>
                        <div class="icon-check"></div>
                        <span>Add Phone Number</span>
                    </li>
                    <li>
                        <div class="icon-check"></div>
                        <span>Add Skills</span>
                    </li>
                    <li>
                        <div class="icon-check"></div>
                        <span>Add Headline</span>
                    </li>
                    <li>
                        <div class="icon-check"></div>
                        <span>Receive a Reference</span>
                    </li>
                </ul>
                <a class="btn btn-primary btn-full mt-4" href="#">I got hired!</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>

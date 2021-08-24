<?php

use EcJobHunting\Service\User\UserService;

global $post;

$candidate = UserService::getUser($post->post_author);
$isOwner = false;

// Add candidate to viewed list.
if (UserService::isEmployer()) {
    $company = UserService::getUser(get_current_user_id());
    $viewedCandidates = $company->getViewedCandidates();
    $key = array_search($candidate->getUserId(), $viewedCandidates);

    if (false !== $key) {
        unset($viewedCandidates[$key]);
    }

    $viewedCandidates[strtotime('now')] = $candidate->getUserId();

    if (50 < count($viewedCandidates)) {
        array_splice($viewedCandidates, 50);
    }

    update_user_meta($company->getUserId(), 'viewed_candidates', $viewedCandidates);
}

get_header();
?>
    <div
        id="candidate"
        class="container"
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
                <?php
                if (
                    !empty($candidate->getWebSite())
                    || !empty($candidate->getTwitter())
                    || !empty($candidate->getLinkedin())
                    || !empty($candidate->getFacebook())
                ) :
                    ?>
                    <div class="profile-item" id="websites-holder">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'websites',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            <div class="col-12 order-1 col-md-7 float-md-right col-xl-9 order-xl-1 mb-5">
                <?php if ($isOwner) :
                    ?>
                    <div class="profile-activation">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'activation',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;

                if ($isOwner || ! empty($candidate->getSummary())) :
                    ?>
                    <div id="executive-summary-holder" class="profile-item">
                        <?php
                        get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'executive-summary',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        );
                        ?>
                    </div>
                    <?php
                endif;

                if ($isOwner || ! empty($candidate->getObjective())) :
                    ?>
                    <div id="objective-holder" class="profile-item">
                        <?php
                        get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'objective',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        );
                        ?>
                    </div>
                    <?php
                endif;

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
                    <?php
                endif;

                if ($isOwner || !empty($candidate->getResumeFile())) : ?>
                    <div id="resume-holder" class="profile-item">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'resume',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;

                if ($isOwner || !empty($candidate->getReferences())) : ?>
                    <div id="references-holder" class="profile-item">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'references',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;
                ?>
                <div
                    id="skills-holder"
                    class="profile-item <?php echo !$isOwner && empty($candidate->getSkills()) ? 'd-none' : ''; ?>"
                >
                    <?php
                    get_template_part(
                        'template-parts/candidate/dashboard/blocs/block',
                        'skills',
                        ['candidate' => $candidate, 'isOwner' => $isOwner]
                    );
                    ?>
                </div>
                <?php
                if ($isOwner || !empty($candidate->getAchievements())) : ?>
                    <div id="achievements-holder" class="profile-item">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'achievements',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                <?php endif;

                if ($isOwner || !empty($candidate->getCertificates())) : ?>
                    <div id="certificates-holder" class="profile-item">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'certificates',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;

                if ($isOwner || !empty($candidate->getAssociations())) : ?>
                    <div id="associations-holder" class="profile-item">
                        <?php get_template_part(
                            'template-parts/candidate/dashboard/blocs/block',
                            'associations',
                            ['candidate' => $candidate, 'isOwner' => $isOwner]
                        ); ?>
                    </div>
                    <?php
                endif;
                ?>
                <div id="more-information-holder" class="profile-item" >
                    <?php get_template_part(
                        'template-parts/candidate/dashboard/blocs/block',
                        'more-information',
                        ['candidate' => $candidate, 'isOwner' => $isOwner]
                    ); ?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();

<?php

use EcJobHunting\Service\User\UserService;

$currentUserId = get_current_user_id();
$error = '';

try {
    do_action('ecjob-save-new-data', $currentUserId);
} catch (Exception $exception) {
    $error = $exception->getMessage();
}

$candidate = UserService::getUser($currentUserId);

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
                    ['candidate' => $candidate]
                ); ?>
            </div>
            <div class="profile-item" id="contacts-holder">
                <?php get_template_part(
                    'template-parts/candidate/dashboard/blocs/block',
                    'contact-information',
                    ['candidate' => $candidate]
                ); ?>
            </div>
            <div class="profile-item">
                <div class="profile-header">
                    <button class="profile-edit-link">Edit</button>
                    <h2 class="no-decor">Websites</h2>
                </div>
                <ul>
                    <li>
                        <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
                        <?php if ($candidate->getWebSite()) : ?>
                            <span><?php echo $candidate->getWebSite(); ?></span>
                        <?php else : ?>
                            <a href="#">Add Website</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <div class="profile-icon"><?php echo getTwitterIcon(); ?></div>
                        <?php if ($candidate->getTwitter()) : ?>
                            <span><?php echo $candidate->getTwitter(); ?></span>
                        <?php else : ?>
                            <a href="#">Add Twitter Profile</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <div class="profile-icon"><?php echo getLinkedinIcon(); ?></div>
                        <?php if ($candidate->getLinkedin()) : ?>
                            <span><?php echo $candidate->getLinkedin(); ?></span>
                        <?php else : ?>
                            <a href="#">Add LinkedIn Profile</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <div class="profile-icon"><?php echo getFacebookIcon(); ?></div>
                        <?php if ($candidate->getFacebook()) : ?>
                            <span><?php echo $candidate->getFacebook(); ?></span>
                        <?php else : ?>
                            <a href="#">Add Facebook Profile</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 order-2 col-md-7 float-md-right col-xl-6 order-xl-1 mb-5">
            <?php if ($error) : ?>
                <div class="alert-danger text-center p-2 mt-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <div class="profile-activation">
                <h3>Let Employers Find You</h3>
                <div class="custom-handler <?php echo $candidate->isPublished() ? "active" : ""; ?>">
                    <div></div>
                </div>
                <p>
                    <?php if ($candidate->isPublished()) :
                        _e(
                            'Public: Your profile is publicly accessible.',
                            'ecjobhunting'
                        );
                    else :
                        _e(
                            'Private: Your profile is not publicly accessible. However, it is viewable as a part of your
                        applications.',
                            'ecjobhunting'
                        );
                    endif; ?>
                </p>
            </div>
            <?php if ($candidate->getSummary()) : ?>
                <div class="profile-item">
                    <div class="profile-header">
                        <h2 class="no-decor">Executive Summary</h2>
                        <p><?php echo $candidate->getSummary(); ?></p>
                        <button class="btn btn-outline-secondary">Edit</button>
                    </div>
                </div>
            <?php endif; ?>
            <div class="profile-item">
                <div class="profile-header">
                    <h2 class="no-decor">Work Experience</h2>
                    <p><a href="#">Add Work Experience</a></p>
                </div>
                <?php if (!empty($candidate->getExperience())) :
                    foreach ($candidate->getExperience() as $experience) : ?>
                        <div class="profile-subitem">
                            <span>
                                <?php echo getDatePeriod(
                                    $experience['period']
                                ); ?>
                            </span>
                            <h3><?php echo $experience['job_position']; ?></h3>
                            <strong><?php echo $experience['company_name']; ?></strong>
                            <button class="btn btn-outline-secondary">Edit</button>
                            <p><?php echo $experience['description']; ?></p>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div class="profile-item">
                <div class="profile-header">
                    <h2 class="no-decor">Education</h2>
                </div>
                <p><a href="#">Add Education</a></p>
                <?php if (!empty($candidate->getEducation())) :
                    foreach ($candidate->getEducation() as $education) : ?>
                        <div class="profile-subitem"><span><?php echo getDatePeriod($education['period']); ?></span>
                            <h3><?php echo $education['name']; ?></h3>
                            <?php echo $education['degree'] ? "<strong>{$education['degree']}</strong>" : ""; ?>
                            <?php echo $education['fields_of_study']
                                ? "<strong>{$education['fields_of_study']}</strong>" : ""; ?>
                            <button class="btn btn-outline-secondary">Edit</button>
                            <?php echo $education['description'] ? "<p>{$education['description']}</p>" : ""; ?>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div class="profile-item">
                <div class="profile-header">
                    <h2 class="no-decor">References</h2>
                </div>
                <p>Hiring managers prefer candidates with references! Ask a former co-worker, manager, teacher or
                    friend to write a reference for you.</p>
                <button class="btn btn-outline-secondary btn-full">Request References</button>
            </div>
            <div class="profile-item">
                <?php if ($candidate->getSummary()) : ?>
                    <p><a href="#">Add Executive Summary</a></p>
                <?php endif; ?>
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

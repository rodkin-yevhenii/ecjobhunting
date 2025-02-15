<?php

/***
 * Vacancy Template
 */

use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\User\UserService;
use EcJobHunting\Service\Vacancy\VacancyService;

$vacancy = new Vacancy(get_the_ID());
$user = wp_get_current_user();
$appliedUsersList = $vacancy->getCandidates();
$isApplied = in_array($user->ID, $appliedUsersList);
$currencySymbol = VacancyService::getCurrencySymbol($vacancy->getCurrency());
$agreements = $vacancy->getAgreementOptions();
$isCovidAdded = in_array('covid', $vacancy->getAgreementOptions());
$isNoResumeAllowed = in_array('accept-all', $vacancy->getAgreementOptions());

if (UserService::isCandidate()) {
    // Update employer visitors.
    $allEmployerVisitors = get_field('visitors', 'user_' . $vacancy->getAuthor());

    if (empty($allEmployerVisitors)) {
        $allEmployerVisitors = [];
    }

    foreach ($allEmployerVisitors as $index => $row) {
        if ($row['visitor'] === $user->ID && $row['vacancy'] === $vacancy->getId()) {
            delete_row('visitors', $index + 1, 'user_' . $vacancy->getAuthor());
        }
    }

    $row = [
        'date' => date('F j, Y'),
        'vacancy' => $vacancy->getId(),
        'visitor' => $user->ID
    ];
    add_row('field_employer_visitors', $row, 'user_' . $vacancy->getAuthor());

    // Update vacancy visitors.
    $visitorsList = !empty($vacancy->getVisitors()) && is_array($vacancy->getVisitors()) ? $vacancy->getVisitors() : [];

    if (!in_array($user->ID, $visitorsList) && UserService::isCandidate()) {
        $visitorsList[] = $user->ID;
        update_field('field_5ff2005d88a3e', $visitorsList, $vacancy->getId()); // Field "visitors"
    }
}

get_header(); ?>
    <main>
        <?php
        if (have_posts() && $vacancy) :
            the_post();
            $benefits = $vacancy->getBenefits();
            $employer = $vacancy->getEmployer();
            ?>
            <section class="mt-3 my-md-5">
                <div class="container">
                    <div class="row justify-content-xl-between">
                        <div class="col-12 col-xl-8">
                            <h1 class="mb-md-3 mb-xl-5"><?php echo $vacancy->getTitle(); ?></h1>
                            <div class="vacancy-header"><strong class="my-3">
                                    <?php
                                    if ($vacancy->getCompensationFrom() && $vacancy->getCompensationTo()) :
                                        echo sprintf(
                                            __('%s to %s', 'ecjobhunting'),
                                            $currencySymbol . $vacancy->getCompensationFrom(),
                                            $currencySymbol . $vacancy->getCompensationTo()
                                        );
                                    else :
                                        echo $vacancy->getCompensationFrom()
                                            ? $currencySymbol . $vacancy->getCompensationFrom()
                                            : $currencySymbol . $vacancy->getCompensationTo();
                                    endif;

                                    echo ' ' . $vacancy->getCompensationPeriodName();
                                    ?></strong>
                                <span class="color-secondary"><?php echo $vacancy->getEmploymentType(); ?></span>
                                <span class="color-secondary"><?php echo $vacancy->getLocation(); ?></span>
                                <?php if ($benefits) : ?>
                                    <strong class="mt-4 mb-2">Benefits Offered</strong>
                                    <ul>
                                        <?php
                                        foreach ($benefits as $benefit) :
                                            ?>
                                            <li><?php echo $benefit; ?></li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <article class="mt-5">
                                <?php
                                if ($vacancy->getDescription()) :
                                    ?>
                                    <h2><?php
                                        _e('Job description', 'ecjobhunting') ?></h2>
                                    <p class="mb-4"><?php
                                        echo $vacancy->getDescription(); ?></p>
                                    <?php
                                endif;
                                ?>

                                <?php
                                if ($vacancy->getReasonsToWork()) :
                                    ?>
                                    <h4><?php
                                        _e('Why Work at This Company?', 'ecjobhunting') ?></h4>
                                    <p class="mb-4"><?php
                                        echo $vacancy->getReasonsToWork(); ?></p>
                                    <?php
                                endif; ?>

                                <?php if ($vacancy->getReasonsToWork()) : ?>
                                    <h4>About the <?php echo $vacancy->getCompanyName(); ?>:</h4>
                                    <p class="mb-4"><?php echo $vacancy->getCompanyDescription(); ?></p>
                                <?php endif; ?>
                            </article>
                            <?php if (UserService::isCandidate()) :
                                $candidate = UserService::getUser(); ?>
                                <div class="vacancy-footer">
                                    <?php
                                    if (
                                        $isApplied
                                        || (
                                            $candidate->isPublished()
                                            && !empty($candidate->getResumeFile()) || $isNoResumeAllowed
                                        )
                                    ) :
                                        ?>
                                        <button
                                            class="btn btn-primary btn-lg mr-md-4 <?php
                                            echo !$isApplied ? 'js-apply' : ''; ?>"
                                            data-vacancy-id="<?php echo $vacancy->getId(); ?>"
                                            data-apply-text="<?php _e('Apply Now', 'ecjobhunting'); ?>"
                                            <?php echo $isApplied ? 'disabled' : ''; ?>
                                        >
                                            <?php echo !$isApplied
                                                ? __('Apply Now', 'ecjobhunting')
                                                : __('Already Applied', 'ecjobhunting');
                                            ?>
                                        </button>
                                    <?php endif; ?>
                                    <a
                                        href="#"
                                        class="btn btn-primary btn-lg js-start-chat"
                                        data-user-id="<?php echo $vacancy->getAuthor(); ?>"
                                        data-vacancy-id="<?php echo $vacancy->getId(); ?>"
                                        data-nonce="<?php echo wp_create_nonce('create_chat'); ?>"
                                    >
                                        Start chat
                                    </a>

                                </div>
                            <?php endif; ?>
<!--TODO Clarify with client what should do button "Am I Qualified?"-->
                        </div>
                        <div class="col-12 col-xl-3 my-5 d-md-flex d-xl-block">
                            <?php if (!empty($vacancy->getLogoId())) : ?>
                                <div class="vacancy-image">
                                    <img
                                        src="
                                        <?php
                                        echo wp_get_attachment_image_url(
                                            $vacancy->getLogoId(),
                                            'single-vacancy-logo'
                                        );
                                        ?>"
                                        alt="<?php echo $vacancy->getCompanyName(); ?>"
                                    />
                                </div>
                            <?php endif; ?>
                            <div class="vacancy-info">
                                <?php
                                if (!empty($vacancy->getCompanyId())) :
                                    ?>
                                    <a
                                        class="vacancy-company no-decor"
                                        href="/jobs/?company=<?php echo $vacancy->getCompanyId(); ?>"
                                    >
                                        <?php echo $vacancy->getCompanyName(); ?>
                                    </a>
                                    <?php
                                endif; ?>
                                <span class="color-secondary"><?php echo nicetime($vacancy->getDatePosted()); ?></span>
<!--TODO Add block with share links to vacancy single-->
<!--                                <div class="social mt-4"><span>Share this job:</span>-->
<!--                                    <ul>-->
<!--                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-envelope-o"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-chain"></i></a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?php get_template_part('content-none');
        endif; ?>
    </main>
<?php get_footer();

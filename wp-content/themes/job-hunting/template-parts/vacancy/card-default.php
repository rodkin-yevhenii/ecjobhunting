<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\User\UserService;
use EcJobHunting\Service\Vacancy\VacancyService;

$vacancy = new Vacancy(get_the_ID());
$user = new Candidate(wp_get_current_user());
$bookmarks = $user->getJobsBookmarks();
$currencySymbol = VacancyService::getCurrencySymbol($vacancy->getCurrency());

if (!$vacancy) {
    return;
}

if (in_array($vacancy->getId(), $bookmarks)) {
    $issAdded = true;
} else {
    $issAdded = false;
}

?>
    <div class="vacancies-item" id="<?php
    the_ID(); ?>">
        <div class="vacancies-header">
            <a href="<?php
            echo $vacancy->getPermalink(); ?>"><h3><?php
                    echo $vacancy->getTitle(); ?></h3></a>
            <?php
            if (UserService::isCandidate()) :
                ?>
                <a class="add-bookmark">
                    <i class="fa fa-star color-<?php
                    echo $issAdded ? 'gold' : 'grey'; ?>"></i>
                    <span class="color-primary">save job for later</span>
                </a>
                <?php
            endif; ?>
        </div>
        <ul>
            <li class="color-secondary"><?php
                echo $vacancy->getCompanyName(); ?></li>
            <li class="color-secondary"><?php
                echo $vacancy->getLocation(); ?></li>
        </ul>
        <ul>
            <li class="color-secondary">
                <?php
                echo sprintf(
                    __('Pay %1$s to %2$s %3$s', 'ecjobhunting'),
                    $currencySymbol . $vacancy->getCompensationFrom(),
                    $currencySymbol . $vacancy->getCompensationTo(),
                    $vacancy->getCompensationPeriodName()
                ); ?>
            </li>
        </ul>
        <?php
        if (!empty($vacancy->getEmploymentType())) : ?>
            <ul>
                <li class="color-secondary">
                    <?php
                    echo $vacancy->getEmploymentType(); ?>
                </li>
            </ul>
            <?php
        endif;
        the_excerpt(); ?>
    </div>
<?php

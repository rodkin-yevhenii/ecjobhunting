<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Vacancy;

$vacancy = new Vacancy(get_the_ID());
$user = new Candidate(wp_get_current_user());
$bookmarks = $user->getJobsBookmarks();

if(!$vacancy){
    return;
}

if (in_array($vacancy->getId(), $bookmarks)) {
    $issAdded = true;
} else {
    $issAdded = false;
}

?>
<div class="vacancies-item" id="<?php the_ID(); ?>">
    <div class="vacancies-header">
        <a href="<?php echo $vacancy->getPermalink(); ?>"><h3><?php echo $vacancy->getTitle(); ?></h3></a>
        <a class="add-bookmark"><i class="fa fa-star color-<?php echo $issAdded ? 'gold' : 'grey'; ?>"></i><span
                class="color-primary">save job for later</span></a>
    </div>
    <ul>
        <li class="color-secondary"><?php echo $vacancy->getCompanyName(); ?></li>
        <li class="color-secondary"><?php echo $vacancy->getLocation(); ?></li>
    </ul>
    <ul>
        <li class="color-secondary">
            <?php echo sprintf(
                    __('Pay %4$s%1$s to %4$s%2$s %3$s', 'ecjobhunting'),
                    number_format($vacancy->getCompensationFrom(), 0, '.', ','),
                    number_format($vacancy->getCompensationTo(), 0, '.', ','),
                    $vacancy->getCompensationPeriodName(),
                    getCurrencySymbol($vacancy->getCurrency())
            ); ?>
        </li>
    </ul>
    <?php if (!empty($vacancy->getEmploymentType())) : ?>
        <ul>
            <li class="color-secondary">
                <?php echo $vacancy->getEmploymentType(); ?>
            </li>
        </ul>
    <?php endif;
    the_excerpt(); ?>
</div>
<?php

<?php

use EcJobHunting\Entity\Vacancy;

$vacancy = new Vacancy(get_the_ID());
if(!$vacancy){
    return;
}
?>
<div class="vacancies-item">
    <div class="vacancies-header">
        <a href="<?php echo $vacancy->getPermalink(); ?>"><h3><?php echo $vacancy->getTitle(); ?></h3></a>
        <a class="add-bookmark"><i class="fa fa-star color-grey"></i><span
                class="color-primary">save job for later</span></a>
    </div>
    <ul>
        <li class="color-secondary"><?php echo $vacancy->getCompanyName(); ?></li>
        <li class="color-secondary"><?php echo $vacancy->getLocation(); ?></li>
    </ul>
    <ul>
        <li class="color-secondary">
            <?php echo sprintf(
                    __('Pay %1$s to %2$s %3$s', 'ecjobhunting'),
                    $vacancy->getCompensationFrom(),
                    $vacancy->getCompensationTo(),
                    $vacancy->getCompensationPeriodName()
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
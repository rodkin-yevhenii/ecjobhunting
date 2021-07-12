<?php

use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\Vacancy\VacancyService;

if (empty($args['id'])) {
    return;
}

$vacancyId = $args['id'];
$vacancy = new Vacancy($vacancyId);
$currencySymbol = VacancyService::getCurrencySymbol($vacancy->getCurrency())
?>
<div class="col-12 col-sm-6 col-lg-4 d-flex card-vacancy-wrapper">
    <div id="<?php echo $vacancyId; ?>" class="card-vacancy">
        <?php if (!empty($vacancy->getLogoId())) : ?>
            <div class="card-vacancy-logo">
                <img src="<?php echo wp_get_attachment_image_url($vacancy->getLogoId(), 'card-vacancy-logo'); ?>"
                     alt="<?php echo $vacancy->getCompanyName(); ?>"
                />
            </div>
        <?php endif; ?>
        <div class="card-vacancy-content">
            <h3><?php echo $vacancy->getTitle(); ?></h3>
            <span><?php echo $vacancy->getCompanyName(); ?></span>
            <span><?php echo $vacancy->getLocation(); ?></span>
            <ul>
                <li>
                    <span>Pay</span>
                    <span>
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
                        ?>
                    </span>
                </li>
                <?php if (!empty($vacancy->getBenefits())) : ?>
                    <li>
                        <span>Benefits</span>
                        <span><?php echo implode(', ', $vacancy->getBenefits()); ?></span>
                    </li>
                <?php endif; ?>
                <li>
                    <span>Type</span>
                    <span>
                        <?php echo $vacancy->getEmploymentType() ? : 'Not Listed'; ?>
                    </span>
                </li>
            </ul>
            <p><?php echo $vacancy->getDescription(); ?></p>
        </div>
        <div class="card-vacancy-footer">
            <a class="btn btn-primary" href="<?php echo $vacancy->getPermalink(); ?>">View Details</a>
            <a class="btn btn-outline-primary js-dismiss-job" href="#">Dismiss</a>
        </div>
    </div>
</div>

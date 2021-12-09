<?php

use EcJobHunting\Entity\Company;
use EcJobHunting\Service\User\UserService;

/**
 * @var $company WP_Term
 */
$company = $args['company'] ?? false;

if (!$company) {
    return;
}
//$employer = new Company($company)
?>
    <div class="results-item">
        <div class="container-fluid">
            <div class="row d-flex justify-content-xl-center align-items-center">
<!--                <div class="col d-none d-md-block col-md-2 col-xl-1">-->
<!--                    <div class="results-image"><img src="--><?php //echo $employer->getPhoto(); ?><!--"-->
<!--                                                    alt="--><?php //echo $employer->getName(); ?><!--"></div>-->
<!--                </div>-->
                <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                    <a href="/jobs/?company=<?php echo $company->term_id; ?>">
                        <h4 class="color-primary"><?php echo $company->name; ?></h4>
                    </a>
                </div>
                <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                            class="color-secondary"><?php echo $company->count; ?> vacancies</span></div>
            </div>
        </div>
    </div><?php

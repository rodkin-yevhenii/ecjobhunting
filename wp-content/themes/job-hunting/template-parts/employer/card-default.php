<?php

use EcJobHunting\Entity\Company;
use EcJobHunting\Service\User\UserService;

$user = $args['user'] ?? false;
if (!$user) {
    return;
}
$employer = new Company($user)
?>
    <div class="results-item">
        <div class="container-fluid">
            <div class="row d-flex justify-content-xl-center align-items-center">
                <div class="col d-none d-md-block col-md-2 col-xl-1">
                    <div class="results-image"><img src="<?php echo $employer->getPhoto(); ?>"
                                                    alt="<?php echo $employer->getName(); ?>"></div>
                </div>
                <div class="col-12 col-md-7 col-xl-7 d-flex flex-wrap">
                    <h4 class="color-primary"><?php echo $employer->getName(); ?></h4>
<!--                    <span class="results-country color-secondary">--><?php //echo $employer->getLocation(); ?><!--</span>-->
<!--                    <ul>-->
<!--                        <li><span class="color-secondary">Retail</span></li>-->
<!--                    </ul>-->
                </div>
                <div class="col d-none d-md-block col-md-3 col-xl-2"><span
                            class="color-secondary"><?php echo $employer->getJobPosted(); ?> vacancies</span></div>
            </div>
        </div>
    </div><?php

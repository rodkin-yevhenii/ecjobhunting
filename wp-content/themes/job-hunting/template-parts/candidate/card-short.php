<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Service\User\UserService;

global $post;

$cv = UserService::getUser(get_the_author_meta('ID'));
if (!$cv) {
    return;
}

//$cv = new Candidate($candidate);
?>
<div class="results-item">
    <div class="container-fluid">
        <div class="row d-flex justify-content-xl-center">
            <div class="col d-none d-md-block col-md-2 col-xl-1">
                <div class="results-image"><img src="<?php echo $cv->getPhoto(); ?>"
                                                alt="<?php echo $cv->getName(); ?>"></div>
            </div>
            <div class="col-12 col-md-10 col-xl-9 d-flex flex-wrap">
                <h4 class="color-primary">
                    <a href="<?php echo get_permalink($cv->getCvId()); ?>">
                        <?php echo $cv->getName(); ?>
                    </a>
                </h4>
                <span class="results-country color-secondary"><?php echo $cv->getLocation(); ?></span>
                <ul>
                    <?php if (!empty($cv->getSalaryExpectation())) : ?>
                        <li><span class="color-secondary"><?php echo $cv->getSalaryExpectation(); ?></span></li>
                    <?php endif;

                    if (!empty($cv->getLastActivity())) : ?>
                        <li>
                            <span class="color-secondary">Last activity: <?php echo $cv->getLastActivity(); ?></span>
                        </li>
                    <?php endif;

                    if (!empty($cv->getCategory())) : ?>
                        <li><span class="color-secondary"><?php echo $cv->getCategory(); ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

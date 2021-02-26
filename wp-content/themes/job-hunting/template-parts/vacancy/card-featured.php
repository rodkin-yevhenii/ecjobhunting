<?php

use EcJobHunting\Entity\Vacancy;

$vacancy = new Vacancy(get_the_ID());
if (!$vacancy) {
    return;
}
?>
    <div class="results-item">
    <div class="container-fluid">
        <div class="row d-flex justify-content-xl-center">
            <div class="col d-none d-md-block col-md-2 col-xl-1">
                <div class="results-image"><img src="<?php echo $vacancy->getEmployer()->getPhoto(); ?>"
                                                alt="<?php echo $vacancy->getEmployer()->getName(); ?>">
                </div>
            </div>
            <div class="col-12 col-md-10 col-xl-9"><small><?php nicetime($vacancy->getDatePosted()); ?></small>
                <a
                        href="<?php echo $vacancy->getPermalink(); ?>"><h4
                            class="color-primary"><?php echo $vacancy->getTitle(); ?></h4></a>
                <ul>
                    <li><span class="color-secondary"><?php echo $vacancy->getEmploymentType(); ?></span></li>
                    <li><span class="color-secondary"><?php echo $vacancy->getLocation(); ?></span>
                    </li>
                </ul>
                <?php the_excerpt(); ?>
            </div>
        </div>
    </div>
    </div><?php
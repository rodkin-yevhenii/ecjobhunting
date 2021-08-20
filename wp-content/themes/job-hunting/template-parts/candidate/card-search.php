<?php

use EcJobHunting\Entity\Candidate;

if (empty($args['candidate'])) {
    return;
}

/**
* @var $candidate Candidate
 */
$candidate = $args['candidate'];
?>
<div id="<?php echo $candidate->getCvId(); ?>" class="results-item">
    <div class="container-fluid">
        <div class="row">
            <div class="col d-none d-md-block col-md-3 col-xl-2">
                <div class="results-image">
                    <img
                        src="<?php echo $candidate->getPhoto(); ?>"
                        alt="<?php echo $candidate->getName(); ?>"
                    />
                </div>
            </div>
            <div class="col-12 col-md-9 col-xl-10 d-flex flex-wrap">
                <h4 class="color-primary"><?php echo $candidate->getName(); ?></h4>
                <span class="results-country color-secondary"><?php echo $candidate->getLocation(); ?></span>
                <ul>
                    <?php
                    if (!empty($candidate->getSalaryExpectation())) :
                        ?>
                        <li>
                            <span class="color-secondary">
                                $<?php
                                echo $candidate->getSalaryExpectation(); ?> p.a minimum
                            </span>
                        </li>
                        <?php
                    endif;

                    if (!empty($candidate->getCategory())) :
                        ?>
                        <li>
                            <span class="color-secondary">
                                <?php
                                echo $candidate->getCategory(); ?>
                            </span>
                        </li>
                        <?php
                    endif;

                    if (!empty($candidate->getLastActivity())) :
                        ?>
                        <li>
                            <span class="color-secondary">
                                Last Activity in <?php
                                echo $candidate->getLastActivity(); ?>
                            </span>
                        </li>
                        <?php
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

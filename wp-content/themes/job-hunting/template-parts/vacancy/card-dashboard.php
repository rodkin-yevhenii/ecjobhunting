<?php

use EcJobHunting\Entity\Vacancy;

$vacancy = new Vacancy(get_the_ID());
if (!$vacancy) {
    return;
}
?>
    <div class="results-item mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="d-none d-md-block col-md-2 col-xl-1">
                    <div class="results-image"><img src="<?php echo $vacancy->getEmployer()->getPhoto(); ?>"
                                                    alt="photo"></div>
                </div>
                <div class="col-12 col-md-10 col-xl-11">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-xl-7"><small><?php echo nicetime(
                                        $vacancy->getDatePosted()
                                    ); ?></small>
                                <h4 class="color-primary"><?php echo $vacancy->getTitle(); ?></h4><span
                                        class="text-usual color-secondary mr-5"><?php echo $vacancy->getCompanyName(
                                    ); ?></span>
                                <span class="d-block d-md-inline text-usual color-secondary mt-2 mt-md-0"><?php echo $vacancy->getLocation(
                                    ); ?></span>
                                <div class="d-flex align-items-start mt-3">
                                    <div class="ys-select ys-select-links mr-3" data-select><span data-select-value>Manage</span>
                                        <ul>
                                            <li><a href="#">Edit job</a></li>
                                            <li><a href="#">Add screening questions</a></li>
                                            <li><a href="#">Preview job</a></li>
                                            <li><a href="#">Duplicate job</a></li>
                                            <li><a href="#">Permanently delete</a></li>
                                        </ul>
                                    </div>
                                    <a class="btn btn-grey btn-sm" href="#">Post Job</a>
                                </div>
                            </div>

                            <div class="col-12 col-xl-5">
                                <div class="container-fluid">
                                    <div class="row mt-4">
                                        <?php if ($vacancy->getStatus() !== 'draft'): ?>
                                            <div class="col-6 col-md-12">
                                                <ul class="vacancy-info">
                                                    <li>
                                                        <strong class="color-dark text-large text-regular"><?php echo dateDiff($vacancy->getDatePosted())?></strong>
                                                        <span class="color-secondary text-usual">Days Posted</span>
                                                    </li>
                                                    <li>
                                                        <strong class="color-dark text-large text-regular"><?php echo $vacancy->getVisitors(); ?></strong><span
                                                                class="color-secondary text-usual">Visitors</span></li>
                                                    <li><strong class="color-primary text-large text-regular"><?php echo $vacancy->getCandidatesNumber(); ?></strong><span
                                                                class="color-secondary text-usual">Candidate</span></li>
                                                </ul>
                                            </div>
                                            <div class="col-6 col-md-12 text-right text-md-left color-rose text-large mt-3">
                                                <span class="pl-xl-2">
                                                    <?php if ($vacancy->getStatus() == 'publish') :
                                                        echo 'ACTIVE';
                                                    else:
                                                        echo 'CLOSED';
                                                    endif;
                                                    ?>
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-6 col-md-12"></div>
                                            <div class="col-6 col-md-12 text-right text-md-left color-orange text-large">
                                                <span class="pl-xl-2">DRAFT</span></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
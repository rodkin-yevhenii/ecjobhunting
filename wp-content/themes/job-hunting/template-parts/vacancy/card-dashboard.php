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
                    <?php if (!empty($vacancy->getLogoId())) : ?>
                        <div class="results-image">
                            <img
                                src="
                                <?php
                                echo wp_get_attachment_image_url(
                                    $vacancy->getLogoId(),
                                    'results-image'
                                );
                                ?>"
                                alt="<?php echo $vacancy->getCompanyName(); ?>"
                            />
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-md-10 col-xl-11">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-xl-7">
                                <small>
                                    <?php
                                    echo nicetime(
                                        $vacancy->getDatePosted()
                                    ); ?>
                                </small>
                                <h4 class="color-primary">
                                    <?php
                                    echo $vacancy->getTitle(); ?>
                                    <small><?php
                                        echo sprintf('Job ID: %s', get_the_ID()) ?>
                                    </small>
                                </h4>
                                <span class="text-usual color-secondary mr-5">
                                    <?php echo $vacancy->getCompanyName(); ?>
                                </span>
                                <span class="d-block d-md-inline text-usual color-secondary mt-2 mt-md-0">
                                    <?php echo $vacancy->getLocation(); ?>
                                </span>
                                <div class="d-flex align-items-start mt-3">
                                    <div class="ys-select ys-select-links mr-3" data-select>
                                        <span data-select-value>Manage</span>
                                        <ul
                                            data-job-id="<?php the_ID();?>"
                                            data-author="<?php echo $vacancy->getAuthor(); ?>"
                                        >
                                            <li>
                                                <a
                                                    class="js-edit-job"
                                                    data-toggle="modal"
                                                    data-target="#publish-job__form"
                                                >
                                                    Edit job
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    href="<?php echo $vacancy->getPermalink(); ?>"
                                                    target="_blank"
                                                    rel="noreferrer ofollow noopener"
                                                    class="preview-job"
                                                >
                                                    Preview job
                                                </a>
                                            </li>
                                            <li><a class="js-duplicate-job">Duplicate job</a></li>
                                            <li><a class="js-delete-job">Permanently delete</a></li>
                                        </ul>
                                    </div>
                                    <?php
                                    if ($vacancy->getStatus() !== 'publish') : ?>
                                        <a class="btn btn-grey btn-sm js-publish-job" data-job-id="<?php the_ID();?>">
                                            Publish Job
                                        </a>
                                    <?php else : ?>
                                        <a class="btn btn-grey btn-sm js-archive-job" data-job-id="<?php the_ID();?>">
                                            Archive Job
                                        </a>
                                        <?php
                                    endif; ?>
                                </div>
                            </div>

                            <div class="col-12 col-xl-5">
                                <div class="container-fluid">
                                    <div class="row mt-4">
                                        <?php
                                        if ($vacancy->getStatus() !== 'draft') : ?>
                                            <div class="col-6 col-md-12">
                                                <ul class="vacancy-info">
                                                    <li>
                                                        <strong class="color-dark text-large text-regular"><?php
                                                            echo dateDiff($vacancy->getDatePosted()) ?></strong>
                                                        <span class="color-secondary text-usual">Days Posted</span>
                                                    </li>
                                                    <li>
                                                        <strong class="color-dark text-large text-regular"><?php
                                                            echo $vacancy->getVisitorsNumber(); ?></strong><span
                                                                class="color-secondary text-usual">Visitors</span></li>
                                                    <li><strong class="color-primary text-large text-regular"><?php
                                                            echo $vacancy->getCandidatesNumber(); ?></strong><span
                                                                class="color-secondary text-usual">Candidate</span></li>
                                                </ul>
                                            </div>
                                            <div
                                                class="col-6 col-md-12 text-right text-md-left color-rose text-large
                                                mt-3"
                                            >
                                                <span class="pl-xl-2">
                                                    <?php
                                                    if ($vacancy->getStatus() == 'publish') :
                                                        echo 'ACTIVE';
                                                    else :
                                                        echo 'CLOSED';
                                                    endif;
                                                    ?>
                                                </span>
                                            </div>
                                            <?php
                                        else :
                                            ?>
                                            <div class="col-6 col-md-12"></div>
                                            <div
                                                class="col-6 col-md-12 text-right text-md-left color-orange text-large"
                                            >
                                                <span class="pl-xl-2">DRAFT</span></div>
                                            <?php
                                        endif; ?>
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

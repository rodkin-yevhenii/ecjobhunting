<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\User\UserService;

/**
 * @var $args array
 */
$data = $args['candidateData'];
$company = $args['company'];
$isFirst = $args['isFirst'];
$candidate = UserService::getUser($data['employee']);
$vacancy = new Vacancy($data['vacancy']);
$cv = new Candidate(get_user_by('id', $candidate->getUserId()));
$workExperience = $cv->getExperience();
$education = $cv->getEducation();
?>
    <div class="results-item <?php echo $isFirst ? 'mt-4' : ''; ?>">
        <div class="container-fluid">
            <div class="row d-flex justify-content-xl-center">
                <div class="col d-none d-md-block col-md-3 col-xl-2">
                    <div class="results-image">
                        <img src="<?php echo $candidate->getPhoto(); ?>" alt="<?php echo $candidate->getName(); ?>">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-7 d-flex flex-wrap">
                    <small><?php echo $data['date']; ?></small>
                    <h4 class="color-primary"><?php echo $candidate->getName(); ?></h4>
                    <span class="results-country color-secondary"><?php echo $candidate->getLocation(); ?></span>
                    <ul>
                        <li>
                            <span class="color-secondary">Applied to: <?php echo $vacancy->getTitle(); ?></span>
                        </li>
                        <?php
                        if (!empty($workExperience)) :
                            foreach ($workExperience as $experience) :
                                ?>
                                <li class="color-black">
                                    <?php echo $experience['job_position']; ?>
                                    <span class="color-secondary">at <?php echo $experience['company_name']; ?></span>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <?php
                    if (!empty($cv->getHeadline())) :
                        ?>
                        <ul>
                            <li class="color-black">
                                <?php
                                echo $cv->getHeadline();

                                if (!empty($cv->getCategory())) :
                                    ?>
                                    <span class="color-secondary">in <?php echo $cv->getCategory(); ?></span>
                                    <?php
                                endif;
                                ?>
                            </li>
                        </ul>
                        <?php
                    endif;

                    if ($cv->getSkills()) :
                        ?>
                        <ul class="results-item__skills skills">
                            <?php
                            foreach ($cv->getSkills() as $skill) :
                                ?>
                                <li class="skills__item">
                                    <span class="color-secondary"><?php echo $skill; ?></span>
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                        <?php
                    endif;
                    ?>
                </div>
                <div class="col-12 col-md-3 mt-3 mt-md-0">
                    <?php renderRateButtons($candidate->getUserId(), $company->getRatedCandidates()); ?>
                </div>
            </div>
        </div>
    </div>
<?php

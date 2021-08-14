<?php

use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;

$company = new Company(wp_get_current_user());
if (!$company) {
    return;
}
global $post;
$candidates = $company->getCandidatesData();
?>

    <div class="page employer" data-nonce="<?php echo wp_create_nonce('load_employer_candidates'); ?>">
        <div class="container">
            <?php
            if (!empty($company->getActiveVacancies())) :
                ?>
                <div class="row mb-5">
                    <div class="col-12 col-md-11 col-xl-7">
                        <div class="ys-select ys-select-bordered" data-select>
                            <span data-select-value>Filter by job</span>
                            <ul class="vacancies-select js-vacancies-select">
                                <li
                                    class="js-vacancies-list__item"
                                    data-select-item
                                    data-id
                                >
                                    Show all candidates
                                </li>
                                <?php
                                foreach ($company->getActiveVacancies() as $id) :
                                    $vacancy = new Vacancy($id);
                                    ?>
                                    <li
                                        class="js-vacancies-list__item"
                                        data-select-item
                                        data-id="<?php echo $id; ?>"
                                    >
                                        <?php echo $vacancy->getTitle(); ?>
                                    </li>
                                    <?php
                                endforeach;
                                ?>
                            </ul>
                            <input id="vacancy" class="d-none" type="text">
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <h3>Candidates <span>(20)</span></h3>
                    <ul class="filter-list js-employer-candidates-types">
                        <li data-type="all"><a class="active color-black" href="#">All</a></li>
                        <li data-type="new"><a class="color-black" href="#">New</a></li>
                        <li data-type="great_matches"><a class="color-black" href="#">Great Matches</a></li>
                        <li data-type="unrated"><a class="color-black" href="#">Unrated</a></li>
                        <li data-type="interested"><a class="color-black" href="#">Interested</a></li>
<!--                    <li><a class="color-black" href="#">Within 100 Mi</a></li>-->
                    </ul>
                    <div class="js-candidates-container">
                        <?php
                        $isFirst = true;

                        foreach ($candidates as $candidate) :
                            get_template_part(
                                'template-parts/candidate/card',
                                'default',
                                [
                                    'candidateData' => $candidate,
                                    'company' => $company,
                                    'isFirst' => $isFirst,
                                ]
                            );
                            if ($isFirst) {
                                $isFirst = false;
                            }
                        endforeach;
                        ?>
                    </div>
                </div>
                <div class="col-12 col-xl-4 d-none d-xl-block">
                    <?php
                    if (!empty($company->getActiveVacancies())) :
                        ?>
                        <div class="filter-sidebar">
                            <h3 class="m-0">Filter by Recently Posted Job</h3>
                            <p class="m-0">Showing up to 10 active jobs, newest first</p>
                            <ul class="mt-4 js-vacancies-filter">
                                <?php
                                $counter = 0;
                                foreach ($company->getActiveVacancies() as $id) :
                                    if (10 <= $counter++) {
                                        break;
                                    }
                                    $vacancy = new Vacancy($id);
                                    ?>
                                    <li
                                        class="js-vacancies-list__item"
                                        data-id="<?php echo $id; ?>"
                                    >
                                        <strong class="d-block text-regular color-primary">
                                            <?php echo $vacancy->getTitle(); ?>
                                        </strong>
                                        <span class="color-secondary"><?php echo $vacancy->getLocation() ?></span>
                                    </li>
                                    <?php
                                endforeach;
                                ?>
                            </ul>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php

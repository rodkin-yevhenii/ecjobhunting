<?php

use EcJobHunting\Entity\Company;

$company = new Company(wp_get_current_user());
if (!$company) {
    return;
}
global $post;
$candidates = $company->getCandidates();
?>

    <div class="page employer">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 col-md-11 col-xl-7">
                    <div class="ys-select ys-select-bordered" data-select><span data-select-value>Filter by job</span>
                        <ul>
                            <li data-select-item>Item 1</li>
                            <li data-select-item>Item 2</li>
                            <li data-select-item>Item 3</li>
                        </ul>
                        <input class="d-none" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <h3>Candidates <span>(20)</span></h3>
                    <ul class="filter-list">
                        <li><a class="active color-black" href="#">All</a></li>
                        <li><a class="color-black" href="#">New</a></li>
                        <li><a class="color-black" href="#">Great Matches</a></li>
                        <li><a class="color-black" href="#">Unrated</a></li>
                        <li><a class="color-black" href="#">Interested</a></li>
                        <li><a class="color-black" href="#">Within 100 Mi</a></li>
                    </ul>
                    <?php
                    $isFirst = true;
                    foreach ($candidates as $candidate):
                        $post = $candidate->getCvId();
                        setup_postdata($post);
                        get_template_part('template-parts/candidate/card', 'default', ['candidate' => $candidate]);
                        if ($isFirst) {
                            $isFirst = false;
                        }
                    endforeach;
                    wp_reset_postdata(); ?>
                </div>
                <div class="col-12 col-xl-4 d-none d-xl-block">
                    <div class="filter-sidebar">
                        <h3 class="m-0">Filter by Recently Posted Job</h3>
                        <p class="m-0">Showing up to 10 active jobs, newest first</p>
                        <ul class="mt-4">
                            <li><strong class="d-block text-regular color-primary">Manager</strong><span
                                        class="color-secondary">London</span></li>
                            <li><strong class="d-block text-regular color-primary">Graphic Designer</strong><span
                                        class="color-secondary">London</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
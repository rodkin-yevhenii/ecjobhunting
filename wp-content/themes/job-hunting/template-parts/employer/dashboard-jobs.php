<?php

use EcJobHunting\Entity\Company;

$company = new Company(wp_get_current_user());
if(!$company){
    return;
}
$jobs = $company->getVacancies();
?>
<div class="page employer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-11 col-xl-7">
                <label class="d-block">
                    <input class="field-text js-find-in-list" type="search" placeholder="Search for a job">
                </label>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-xl-8">
                <h3>Jobs</h3>
                <ul class="filter-list">
                    <li><a class="active color-black" href="#">All</a></li>
                    <li><a class="color-black" href="#">New</a></li>
                    <li><a class="color-black" href="#">Active <span>(0)</span></a></li>
                    <li><a class="color-black" href="#">Draft</a></li>
                    <li><a class="color-black" href="#">Closed</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if ($jobs):
                    global $post;
                    foreach ($jobs as $post):
                        setup_postdata($post);
                        get_template_part('template-parts/vacancy/card', 'dashboard');
                    endforeach;
                    wp_reset_postdata();
                else:
                    _e('Jobs not found', 'ecjobhunting');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
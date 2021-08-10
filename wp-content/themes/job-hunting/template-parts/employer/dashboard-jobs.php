<?php

use EcJobHunting\Entity\Company;

$company = new Company(wp_get_current_user());
if (!$company) {
    return;
}
?>
<div class="page employer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-11 col-xl-7">
                <form class="js-employer-my-job-search">
                    <label class="d-block">
                        <input class="field-text js-find-in-list" type="search" placeholder="Search for a job">
                    </label>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-xl-8">
                <h3>Jobs</h3>
                <ul
                    class="filter-list js-employer-my-jobs-types"
                    data-nonce="<?php echo wp_create_nonce('employer_my_vacancies'); ?>"
                >
                    <li data-type="all"><a class="active color-black" href="#">All</a></li>
                    <li data-type="new"><a class="color-black" href="#">New</a></li>
                    <li data-type="active">
                        <a class="color-black" href="#">
                            Active <span>(<?php echo count($company->getActiveVacancies()); ?>)</span>
                        </a>
                    </li>
                    <li data-type="draft"><a class="color-black" href="#">Draft</a></li>
                    <li data-type="closed"><a class="color-black" href="#">Closed</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 js-employer-my-jobs-container">
                <?php
                if ($company->getVacancies()) :
                    global $post;
                    foreach ($company->getVacancies() as $post) :
                        setup_postdata($post);
                        get_template_part('template-parts/vacancy/card', 'dashboard');
                    endforeach;
                    wp_reset_postdata();
                else :
                    _e('Jobs not found', 'ecjobhunting');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<div class="js-job-forms">
    <div class="js-job-forms_edit">
        <div class="ec-job-modal is-hidden">
            <div class="modal-content">
                <span class="title">Edit Job</span>
                <span class="close">&times;</span>
                <?php get_template_part('template-parts/vacancy/form'); ?>
            </div>
        </div>
    </div>
    <div class="js-job-forms_duplicate"></div>
    <div class="js-job-forms_confirm"></div>
</div>

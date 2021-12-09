<?php
/**
 * Template Name: Jobs
 * Template Post Type: page
 */

use EcJobHunting\Service\Job\JobFilter;

$filtersValues['publish-date'] = $_GET['publish-date'] ?? '';
$filtersValues['compensation'] = (int) ($_GET['compensation'] ?? 0);
$filtersValues['employment-type'] = (int) ($_GET['employment-type'] ?? 0);
$filtersValues['category'] = (int) ($_GET['category'] ?? 0);
$filtersValues['company'] = $_GET['company'] ?? '';
$filtersValues['s'] = $_GET['search'] ?? '';
$filtersValues['location'] = $_GET['location'] ?? '';

$jobsFilter = new JobFilter($filtersValues);

get_header(); ?>
    <?php get_template_part('template-parts/vacancy/form', 'search'); ?>
    <section class="my-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo $jobsFilter->getFoundJobs(); ?> <?php _e('Jobs', 'ecjobhunting'); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4 order-xl-1">
                    <button class="btn btn-outline-primary btn-lg d-xl-none mb-5" data-handler="filter">
                        <?php _e('Filter', 'ecjobhunting'); ?>
                    </button>
                    <?php get_template_part('template-parts/vacancy/filter/filter-form'); ?>
                </div>
                <div class="col-12 col-xl-8 order-xl-0">
                    <div
                        class="vacancies js-vacancies"
                        data-paged="1"
                    >
                        <?php if ($jobsFilter->getFoundJobs() > 0) :
                            echo $jobsFilter->render();
                        endif; ?>
                    </div>
                    <?php if ($jobsFilter->getFoundJobs() > get_query_var('posts_per_page', 0)) : ?>
                        <button class="btn btn-outline-primary btn-lg mt-5 js-filter-load-more">
                            <?php _e('Load More Job Results', 'ecjobhunting'); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();

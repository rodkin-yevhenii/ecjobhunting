<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Company;
use EcJobHunting\Service\User\UserService;

if (!UserService::isEmployer()) {
    return;
}

/**
* @var $company Company
 */
$company = UserService::getUser(get_current_user_id());

get_header(); ?>
    <div class="page employer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Resume Database</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12" data-tab>
                    <ul class="results-header results-header-large">
                        <li class="d-md-none" data-tab-value><span>Search Resumes</span></li>
                        <li class="active" data-tab-item="search">Search Resumes</li>
                        <li data-tab-item="saved">My Saved Searches</li>
                        <li data-tab-item="viewed">My Viewed Resumes</li>
                    </ul>
                    <div class="results-content pt-0 pt-md-4">
                        <div class="active" data-tab-content="search">
                            <div class="container-fluid p-0">
                                <div class="row">
                                    <div id="cv-filter" class="col-12 col-md-6 col-xl-4">
                                        <?php
                                        get_template_part(
                                            'template-parts/candidate/filter/filter',
                                            'form'
                                        );
                                        ?>
                                    </div>
                                    <div class="col-12 col-md-6 col-xl-8 mt-4">
                                        <div class="js-candidates-container">
                                            <?php
                                            $counter = 0;
                                            query_posts(
                                                [
                                                    'post_type' => 'cv',
                                                    'post_status' => 'publish',
                                                    'posts_per_page' => 15
                                                ]
                                            );

                                            while (have_posts()) :
                                                the_post();
                                                $counter++;

                                                get_template_part(
                                                    'template-parts/candidate/card',
                                                    'search',
                                                    [
                                                        'candidate' => new Candidate(
                                                            get_user_by('id', $post->post_author)
                                                        ),
                                                    ]
                                                );
                                            endwhile;

                                            wp_reset_query();
                                            ?>
                                        </div>
                                        <div class="col-12 text-center mt-4">
                                            <button
                                                <?php echo $counter < 15 ? 'style="display:none"' : ''; ?>
                                                class="btn btn-primary js-load-more-cvs"
                                            >
                                                Load More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-tab-content="saved">
                            <div class="container-fluid">
                                <div class="row js-query-cards-container">

                                </div>
                            </div>
                        </div>
                        <div data-tab-content="viewed">
                            <?php foreach ($company->getViewedCandidates() as $id) {
                                get_template_part(
                                    'template-parts/candidate/card',
                                    'search',
                                    [
                                        'candidate' => new Candidate(
                                            get_user_by('id', $id)
                                        ),
                                    ]
                                );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();

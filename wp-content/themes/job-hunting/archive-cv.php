<?php

use EcJobHunting\Entity\Candidate;

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
                                    <div class="col-12 col-md-6 col-xl-8 mt-4 js-candidates-container">
                                        <?php
                                        while (have_posts()) :
                                            the_post();

                                            get_template_part(
                                                'template-parts/candidate/card',
                                                'search',
                                                [
                                                    'candidate' => new Candidate(get_user_by('id', $post->post_author))
                                                ]
                                            );
                                        endwhile; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-tab-content="saved"><span>My saved searches</span></div>
                        <div data-tab-content="viewed"><span>My viewed resumes</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();

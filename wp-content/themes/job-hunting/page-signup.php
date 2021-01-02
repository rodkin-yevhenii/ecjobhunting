<?php
/***
 * Template Name: Registration
 */

get_header(); ?>
    <div class="results page">
        <div class="container">
            <div class="row">
                <div class="col-12" data-tab>
                    <ul class="results-header results-header-large">
                        <li class="d-md-none" data-tab-value><span><?php _e('Sign Up as Candidate', 'ecjobhunting'); ?></span></li>
                        <li class="active" data-tab-item="candidate"><?php _e('Sign Up as Candidate', 'ecjobhunting'); ?></li>
                        <li data-tab-item="employer"><?php _e('Sign Up as Employer', 'ecjobhunting'); ?></li>
                    </ul>
                    <div class="results-content">
                        <div class="active" data-tab-content="candidate">
                            Register Form
                        </div>
                        <div data-tab-content="employer">
                           Test
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php get_footer();

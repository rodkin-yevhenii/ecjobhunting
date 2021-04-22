 <?php

/**
 * Template Name: Post New job
 */
get_header();
if(!current_user_can('employer')){
    UserRedirect::redirectToJobs();
}
?>
<div class="results page">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header results-header-large">
                    <li class="d-md-none" data-tab-value><span>Create New Job</span></li>
                    <li class="active" data-tab-item="create">Create New Job</li>
                    <li data-tab-item="duplicate">Duplicate Previous Job</li>
                </ul>
                <div class="results-content">
                    <div class="active" data-tab-content="create">
                        <?php get_template_part('template-parts/vacancy/form'); ?>
                    </div>
                    <div data-tab-content="duplicate">
                        <form class="container-fluid p-0 duplicate-job-form" data-author="<?php echo get_current_user_id(); ?>">
                            <div class="row mt-md-4">
                                <div class="col-12 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3 mt-xl-3" for="post-job-title-dublicate">Enter a Previous Job ID <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-xl-7 mt-md-4 mt-xl-0">
                                    <input class="field-text" type="text" id="post-job-title-duplicate" required>
                                    <p class="mt-4"><strong>Important: </strong> Posting an exact copy of an active job in the same or nearby location will be rejected by the job boards</p>
                                    <button class="btn btn-primary btn-lg mt-4 mt-xl-5" type="submit">Duplicate Job</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php

global $post;
$jobCategories = get_terms(
    ['taxonomy' => 'job-category', 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC']
);
$args = [
    'post_type' => 'vacancy',
    'posts_per_page' => 5,
    'post_status' => 'publish',
    'fields' => 'ids',
];
$latestJobs = new WP_Query($args);
$args['post_type'] = 'cv';
$latestResume = new WP_Query($args);

$latestCompanies = get_terms(
    ['taxonomy' => 'company', 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC']
);
$counts = count_users();
get_header(); ?>
    <form
        role="search"
        method="get"
        id="searchform"
        class="hero searchform"
        action="/jobs/"
    >
        <div class="container">
            <div class="row d-flex justify-content-xl-center">
                <div class="col-12">
                    <h1><?php the_title(); ?></h1>
                </div>
                <div class="col-12 col-md-5 col-xl-4">
                    <label class="my-2">
                        <input class="field-text" type="text" placeholder="Job Title" name="search" id="s">
                    </label>
                </div>
                <div class="col-12 col-md-5 col-xl-4">
                    <label class="my-2">
                        <input
                            class="field-text js-auto-complete"
                            type="text"
                            placeholder="Location"
                            name="location"
                            id="location"
                            autocomplete="off"
                        >
                    </label>
                </div>
                <div class="col-12 col-md-2">
                    <button class="btn btn-primary my-2" type="submit">Search</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 hero-numbers">
                    <strong><?php echo $latestJobs->found_posts; ?></strong><span>Jobs</span>
                </div>
                <div class="col-6 col-md-3 hero-numbers">
                    <strong><?php echo $counts['total_users']; ?></strong><span>Members</span>
                </div>
                <div class="col-6 col-md-3 hero-numbers">
                    <strong><?php echo $latestResume->found_posts; ?></strong><span>Resumes</span>
                </div>
                <div class="col-6 col-md-3 hero-numbers">
                    <strong><?php echo count($latestCompanies); ?></strong><span>Companies</span>
                </div>
            </div>
        </div>
    </form>
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="align-center">Popular Job Categories</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-xl-12">
                    <?php if ($jobCategories) : ?>
                        <ul>
                            <?php foreach ($jobCategories as $term) : ?>
                                <li><a href="/jobs/?category=<?php echo $term->term_id; ?>"
                                       class="btn btn-outline-secondary" data-abc="true"
                                    >
                                        <?php echo $term->name; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="results">
        <div class="container">
            <div class="row">
                <div class="col-12 recent-info-tab" data-tab>
                    <h2 class="align-center">We have founds 16 available jobs for you</h2>
                    <ul class="results-header">
                        <li class="d-md-none" data-tab-value><span>Jobs</span></li>
                        <li class="active" data-tab-item="jobs" data-tab-message="<?php printf(
                            __('We have founds %d available jobs for you', 'ecjobhunting'),
                            $latestJobs->found_posts
                        ); ?>">Jobs
                        </li>
                        <li data-tab-item="resumes" data-tab-message="<?php printf(
                            __('We have founds %d CVs for you', 'ecjobhunting'),
                            $latestResume->found_posts
                        ); ?>">Latest Resumes
                        </li>
                        <li data-tab-item="companies" data-tab-message="<?php printf(
                            __('We have founds %d companies for you', 'ecjobhunting'),
                            count($latestCompanies)
                        ); ?>">Latest Companies
                        </li>
                    </ul>
                    <ul class="results-content">
                        <?php if ($latestJobs->have_posts()) : ?>
                            <li class="active" data-tab-content="jobs">
                                <?php foreach ($latestJobs->posts as $post) :
                                    setup_postdata($post);
                                    get_template_part('template-parts/vacancy/card', 'featured');
                                endforeach;
                                wp_reset_postdata();
                                ?>
                            </li>
                        <?php endif;
                        if ($latestResume->have_posts()) : ?>
                            <li data-tab-content="resumes">
                                <?php foreach ($latestResume->posts as $post) :
                                    setup_postdata($post);
                                    get_template_part('template-parts/candidate/card', 'short');
                                endforeach;
                                wp_reset_postdata();
                                ?>
                            </li>
                        <?php endif;
                        if ($latestCompanies) : ?>
                            <li data-tab-content="companies">
                                <?php foreach ($latestCompanies as $company) :
                                    get_template_part(
                                        'template-parts/employer/card',
                                        'default',
                                        ['company' => $company]
                                    );
                                endforeach; ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (have_posts()) :
        the_post();
        the_content();
    endif;
    ?>
    <section class="register">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 register-item">
                    <div class="register-item-icon d-none d-md-flex"><img
                                src="<?php echo IMG_URI . 'icons/register-icon-1.png'; ?>"
                                alt="icon"></div>
                    <h3>Employer Account</h3>
                    <a class="btn btn-outline-secondary" href="<?php echo SIGNUP_URL . '?user=employer'; ?>">
                        Register Account
                    </a>
                </div>
                <div class="col-12 col-md-6 register-item">
                    <div class="register-item-icon d-none d-md-flex"><img
                                src="<?php echo IMG_URI . 'icons/register-icon-2.png'; ?>"
                                alt="icon"></div>
                    <h3>Candidates Account</h3>
                    <a class="btn btn-outline-secondary" href="<?php echo SIGNUP_URL . '?user=candidate'; ?>">
                        Register Account
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();

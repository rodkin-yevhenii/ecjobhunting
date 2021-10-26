<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Service\User\UserService;

/**
 * @var $candidate Candidate
 */
$candidate = UserService::getUser();
$args = [
    'posts_per_page' => -1,
    'post_type' => 'vacancy',
    'post_status' => 'publish',
    'fields' => 'ids'
];

$appliedJobsArgs = array_merge(
    $args,
    [
        'meta_query' => [
            [
                'key' => 'applied',
                'value' => '"' . $candidate->getUserId() . '"',
                'compare' => 'LIKE'
            ]
        ]
    ]
);

$appliedJobsQuery = new WP_Query($appliedJobsArgs);
$appliedJobs = $appliedJobsQuery->posts;

$savedJobsArgs = array_merge(
    $args,
    [
        'post__in' => $candidate->getSavedJobs(),
    ]
);

$savedJobsQuery = new WP_Query($savedJobsArgs);
$savedJobs = !empty($candidate->getSavedJobs()) ? $savedJobsQuery->posts : [];

$suggestedJobsArgs = array_merge(
    $args,
    [
        'posts_per_page' => 9,
        'post__not_in' => array_merge($savedJobs, $appliedJobs, $candidate->getDismissedJobs()),
        'tax_query' => [
            [
                'taxonomy' => 'location',
                'field' => 'name',
                'terms' => $candidate->getLocation()
            ],
            [
                'taxonomy' => 'job-category',
                'field' => 'name',
                'terms' => $candidate->getCategory()
            ],
        ],
    ]
);

$suggestedJobsQuery = new WP_Query($suggestedJobsArgs);
?>
<form class="hero-form" method="get" action="/jobs">
    <div class="container">
        <div class="row d-flex justify-content-xl-center">
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                        class="field-text"
                        type="text"
                        name="search"
                        placeholder="Job Title"
                        value=""
                    >
                </label>
            </div>
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                        class="field-text js-auto-complete"
                        type="text"
                        name="location"
                        placeholder="Location"
                        value="<?php echo $candidate->getLocation(); ?>"
                        autocomplete="off"
                    >
                </label>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-primary my-2" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
<section class="results">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header">
                    <li class="d-md-none" data-tab-value><span>Suggested Jobs</span></li>
                    <li class="active" data-tab-item="suggested">Suggested Jobs</li>
                    <li data-tab-item="applied">Applied Jobs</li>
                    <li data-tab-item="saved">Saved Jobs</li>
                </ul>
                <div class="results-link">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <p>
                                    Below are other jobs you might like, based on your resume.
                                </p>
                            </div>
                            <div class="col-12 col-md-4 d-md-flex justify-content-md-end">
                                <a class="color-primary js-show-dismissed-jobs" href="#" style="display: none">
                                    View Dismissed Jobs <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="results-content">
                    <li class="active" data-tab-content="suggested">
                        <div class="container-fluid p-0">
                            <div class="row js-suggested-jobs">
                                <?php if ($suggestedJobsQuery->have_posts()) :
                                    foreach ($suggestedJobsQuery->posts as $jobId) :
                                        get_template_part('template-parts/vacancy/card', 'vacancy', ['id' => $jobId]);
                                    endforeach;
                                endif; ?>
                            </div>
                            <div class="row js-dismissed-jobs" style="display: none"></div>
                        </div>
                    </li>
                    <li data-tab-content="applied">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <?php if ($appliedJobsQuery->have_posts()) :
                                    foreach ($appliedJobsQuery->posts as $jobId) :
                                        get_template_part('template-parts/vacancy/card', 'vacancy', ['id' => $jobId]);
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </li>
                    <li data-tab-content="saved">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <?php if ($savedJobsQuery->have_posts() && !empty($candidate->getSavedJobs())) :
                                    foreach ($savedJobsQuery->posts as $jobId) :
                                        get_template_part('template-parts/vacancy/card', 'vacancy', ['id' => $jobId]);
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

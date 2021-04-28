<?php

namespace EcJobHunting\Service\Job;

use WP_Query;

/**
 * Class JobFilter
 * @package EcJobHunting\Service\Job
 */
class JobFilter
{
    private array $jobsList = [];
    private int $foundJobs = 0;

    /**
     * JobFilter constructor.
     *
     * @param array $filters
     * @param int $paged
     */
    public function __construct(array $filters = [], int $paged = 1)
    {
        $this->getJobs($filters, $paged);
    }

    /**
     * Get filtered jobs list.
     *
     * @param array $filters    Filters values
     * @param int $paged        Attribute for pagination
     */
    private function getJobs(array $filters, int $paged) : void
    {
        $args = [
            'post_type' => 'vacancy',
            'post_status' => 'publish',
            'fields' => 'ids',
            'paged' => $paged,
        ];

        if (! empty($filters['s'])) {
            $args['s'] = $filters['s'];
        }

        if (! empty($filters['location'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'location',
                'field' => 'name',
                'terms' => $filters['location']
            ];
        }

        if (! empty($filters['publish-date'])) {
            $args['date_query'][] = [
                'after' => $filters['publish-date'],
                'inclusive' => true,
            ];
        }

        if (! empty($filters['compensation'])) {
            $args['meta_query'][] = [
                'key' => 'compensation_range_from',
                'value'  => $filters['compensation'],
                'compare' => '>='
            ];
        }

        if (! empty($filters['employment-type'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'type',
                'field' => 'term_id ',
                'terms' => $filters['employment-type']
            ];
        }

        if (! empty($filters['category'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'job-category',
                'field' => 'term_id ',
                'terms' => $filters['category']
            ];
        }

        if (! empty($filters['company'])) {
            $args['meta_query'][] = [
                'key' => 'hiring_company',
                'value'  => $filters['company'],
                'compare' => '>LIKE'
            ];
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $this->foundJobs = $query->found_posts;
            $this->jobsList = $query->posts;
        }
    }

    /**
     * Render filters results.
     *
     * @return string
     */
    public function render() : string
    {
        global $post;

        ob_start();
        foreach ($this->jobsList as $post) {
            setup_postdata($post);
            get_template_part('template-parts/vacancy/card-default');
        }
        wp_reset_postdata();
        return ob_get_clean();
    }

    /**
     * @return int
     */
    public function getFoundJobs(): int
    {
        return $this->foundJobs;
    }
}

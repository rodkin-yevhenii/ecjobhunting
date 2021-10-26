<?php

namespace EcJobHunting\Service\Ajax;

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\Ajax\Callbacks\Autocomplete;

/**
 * Class Ajax
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax
 */
class Ajax extends AjaxCallbackAbstract
{
    /**
     * Ajax constructor
     */
    public function __construct()
    {
        new Autocomplete();

        // Register Actions
        $this->actions['rate_candidate'] = 'rateEmployee';
        $this->actions['load_vacancy_candidates'] = 'loadVacancyCandidates';
        $this->actions['load_employer_candidates'] = 'loadEmployerCandidates';
        $this->actions['get-filtered-cvs'] = 'loadFilteredCvs';
        $this->actions['load-more-cvs'] = 'loadMoreCvs';

        parent::__construct();
    }

    /**
     * Ajax callback for updating rated candidates list fo employer.
     */
    public function rateEmployee(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'rate_user')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        if (empty($_POST['userId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('User ID is required')
                ->send();
        }

        if (empty($_POST['rating'])) {
            $this->response
                ->setStatus(204)
                ->setMessage('Rating value is required')
                ->send();
        }

        $userId = (int) $_POST['userId'];
        $userMeta = get_userdata($userId);

        if ('candidate' !== $userMeta->roles[0]) {
            $this->response
                ->setStatus(204)
                ->setMessage('Incorrect User ID.')
                ->send();
        }

        $company = new Company(wp_get_current_user());
        $ratedCandidates = $company->getRatedCandidates();
        $ratedCandidates[$userId] = $_POST['rating'];

        $result = update_user_meta(get_current_user_id(), 'rated_candidates', $ratedCandidates);

        if ($result === false) {
            $this->response
                ->setStatus(500)
                ->setMessage('Candidate rating wasn\'t saved')
                ->send();
        }

        $this->response
            ->setStatus(200)
            ->send();
    }

    /**
     * Ajax callback for rendering vacancy candidates
     */
    public function loadVacancyCandidates(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_employer_candidates')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $id = $_POST['id'] ?? false;
        $type = $_POST['type'] ?? 'all';

        if ($id) {
            $object = new Vacancy($id);
        } else {
            $object = new Company(wp_get_current_user());
        }

        switch ($type) {
            case 'new':
                $candidates = $object->getNewCandidatesData();
                break;
            case 'great_matches':
                $candidates = $object->getGreatMatchedCandidatesData();
                break;
            case 'unrated':
                $candidates = $object->getUnratedCandidatesData();
                break;
            case 'interested':
                $candidates = $object->getInterestedCandidatesData();
                break;
            default:
                $candidates = $object->getCandidatesData();
                break;
        }

        if (empty($candidates)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Candidates not found')
                ->send();
        }

        ob_start();
        $isFirst = true;

        foreach ($candidates as $candidate) :
            get_template_part(
                'template-parts/candidate/card',
                'default',
                [
                    'candidateData' => $candidate,
                    'company' => $id ? $object->getEmployer() : $object,
                    'isFirst' => $isFirst,
                ]
            );
            if ($isFirst) {
                $isFirst = false;
            }
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }

    /**
     * Ajax callback for rendering employer candidates
     */
    public function loadEmployerCandidates(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_employer_candidates')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $type = $_POST['type'] ?? 'all';
        $company = new Company(wp_get_current_user());

        switch ($type) {
            case 'new':
                $candidates = $company->getNewCandidatesData();
                break;
            case 'great_matches':
                $candidates = $company->getGreatMatchedCandidatesData();
                break;
            case 'unrated':
                $candidates = $company->getUnratedCandidatesData();
                break;
            case 'interested':
                $candidates = $company->getInterestedCandidatesData();
                break;
            default:
                $candidates = $company->getCandidatesData();
                break;
        }

        if (empty($candidates)) {
            $this->response
                ->setStatus(404)
                ->setMessage('Candidates not found')
                ->send();
        }

        ob_start();
        $isFirst = true;

        foreach ($candidates as $candidate) :
            get_template_part(
                'template-parts/candidate/card',
                'default',
                [
                    'candidateData' => $candidate,
                    'company' => $company,
                    'isFirst' => $isFirst,
                ]
            );
            if ($isFirst) {
                $isFirst = false;
            }
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();

        $this->response
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }

    public function loadFilteredCvs(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'get-filtered-cvs')) {
            $this->response
                ->setStatus(403)
                ->setMessage('You are unauthorized. Access denied.')
                ->send();
        }

        $args = [
            'post_type' => 'cv',
            'post_status' => 'publish',
            'posts_per_page' => 15,
            'paged' => $_POST['paged'] ?? 1,
            'tax_query' => [],
        ];

        // Filter by vacancy ID
        if (!empty($_POST['vacancyId'])) {
            $vacancy = new Vacancy($_POST['vacancyId']);

            if (empty($vacancy->getCandidates())) {
                $this->response
                    ->setStatus(404)
                    ->setMessage('Candidates not found')
                    ->send();
            }

            foreach ($vacancy->getCandidates() as $id) {
                $candidate = new Candidate(get_user_by('id', $id));
                $args['post__in'][] = $candidate->getCvId();
            }
        }

        // Filter by skills. Use logic OR for skills.
        if (!empty($_POST['skills'])) {
            $skills = explode(',', $_POST['skills']);
            $args['tax_query'][] = [
                'taxonomy' => 'skill',
                'field' => 'name',
                'terms' => $skills,
                'include_children' => false
            ];
        }

        // Filter by location.
        if (!empty($_POST['location'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'location',
                'field' => 'name',
                'terms' => $_POST['location'],
                'include_children' => false
            ];
        }

        // Filter by headline.
        if (!empty($_POST['jobTitle'])) {
            $args['meta_query'][] = [
                'key' => 'headline',
                'value' => $_POST['jobTitle'],
                'compare' => 'LIKE',
                'type' => 'CHAR'
            ];
        }

        // Filter by company name.
        if (!empty($_POST['company'])) {
            $args['meta_query'][] = [
                'key' => 'work_experience_$_company_name',
                'value' => $_POST['company'],
                'compare' => 'LIKE',
                'type' => 'CHAR'
            ];
        }

        // Filter by published date.
        if (!empty($_POST['daysAgo'])) {
            $date = new \DateTime();
            $date->modify('-' . (int) $_POST['daysAgo'] . ' day');
            $args['date_query'] = [
                'column' => 'post_date',
                'after' => $date->format('F j, Y'),
                'inclusive' => true
            ];
        }

        // Filter by highest degree.
        if (!empty($_POST['degree']) && 'any' !== $_POST['degree']) {
            $value = [];

            switch ($_POST['degree']) {
                case 'high_school':
                    $value = ['high_school', 'college', 'bachelors', 'master', 'doctorate'];
                    break;
                case 'college':
                    $value = ['college', 'bachelors', 'master', 'doctorate'];
                    break;
                case 'bachelors':
                    $value = ['bachelors', 'master', 'doctorate'];
                    break;
                case 'master':
                    $value = ['master', 'doctorate'];
                    break;
                case 'doctorate':
                    $value = ['doctorate'];
                    break;
            }

            $args['meta_query'][] = [
                'key' => 'degree_earned',
                'value' => $value,
                'compare' => 'IN',
                'type' => 'CHAR'
            ];
        }

        // Filter by job category.
        if (!empty($_POST['category'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'job-category',
                'field' => 'name',
                'terms' => $_POST['category'],
                'include_children' => false
            ];
        }

        // Filter by veteran status.
        if (!empty($_POST['isVeteran'])) {
            $args['meta_query'][] = [
                'key' => 'veteran_status',
                'value' => 'I am a Veteran',
                'compare' => '=',
                'type' => 'CHAR'
            ];
        }

        $query = new \WP_Query($args);

        if (!$query->have_posts() && $args['paged'] == 1) {
            $this->response
                ->setStatus(404)
                ->setMessage('Candidates not found')
                ->send();
        }

        ob_start();
        while ($query->have_posts()) {
            $query->the_post();

            get_template_part(
                'template-parts/candidate/card',
                'search',
                [
                    'candidate' => new Candidate(get_user_by('id', $query->post->post_author))
                ]
            );
        }
        $html = ob_get_clean();
        wp_reset_postdata();

        $this->response
            ->setIsEnd($args['posts_per_page'] * $args['paged'] >= $query->found_posts)
            ->setStatus(200)
            ->setResponseBody($html)
            ->send();
    }
}

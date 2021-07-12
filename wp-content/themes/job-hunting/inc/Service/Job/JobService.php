<?php


namespace EcJobHunting\Service\Job;


use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Front\SiteSettings;
use EcJobHunting\Interfaces\AjaxResponse;
use EcJobHunting\Service\Job\Response\JobsResponse;
use EcJobHunting\Service\User\UserService;
use PHPMailer\PHPMailer\Exception;
use WP_Query;
use WP_REST_Posts_Controller;

class JobService
{
    private array $jobSettings;
    private array $currencies;
    private array $employmentTypes;
    private array $benefits;
    private array $compensationPeriods;
    private array $agreementOptions;

    private AjaxResponse $response;

    public function __invoke()
    {
        if (wp_doing_ajax()) {
            //create job
            add_action('wp_ajax_create_job', [$this, 'createNewJobAjax']);
            add_action('wp_ajax_nopriv_create_job', [$this, 'createNewJobAjax']);

            //duplicate job
            add_action('wp_ajax_duplicate_job', [$this, 'duplicateJobAjax']);
            add_action('wp_ajax_nopriv_duplicate_job', [$this, 'duplicateJobAjax']);

            //load more jobs
            add_action('wp_ajax_load_more', [$this, 'loadMoreItems']);
            add_action('wp_ajax_nopriv_load_more', [$this, 'loadMoreItems']);

            //load more filtered jobs
            add_action('wp_ajax_filter_load_more', [$this, 'filterLoadMoreCallback']);
            add_action('wp_ajax_nopriv_filter_load_more', [$this, 'filterLoadMoreCallback']);

            //edit job
            add_action('wp_ajax_edit_job', [$this, 'editJobAjax']);
            add_action('wp_ajax_nopriv_edit_job', [$this, 'editJobAjax']);

            // Save Job
            add_action('wp_ajax_update_bookmark', [$this, 'updateBookmark']);
            add_action('wp_ajax_nopriv_update_bookmark', [$this, 'updateBookmark']);

            // Dismiss job
            add_action('wp_ajax_dismiss_job', [$this, 'dismissJob']);
            add_action('wp_ajax_nopriv_dismiss_job', [$this, 'dismissJob']);

            // Dismiss job
            add_action('wp_ajax_un_dismiss_job', [$this, 'unDismissJob']);
            add_action('wp_ajax_nopriv_un_dismiss_job', [$this, 'unDismissJob']);

            // Apply job
            add_action('wp_ajax_apply_job', [$this, 'applyJobAjaxCallback']);
            add_action('wp_ajax_nopriv_apply_job', [$this, 'applyJobAjaxCallback']);
        }
    }

    public function __construct()
    {
        $this->jobSettings = SiteSettings::getJobSettings();
        $this->response = new JobsResponse();
    }

    public function createNewJobAjax()
    {
        try {
            $postData = [
                'post_title' => wp_strip_all_tags($_POST['title'] ?? 'Vacancy'),
                'post_content' => $_POST['description'] ?? '',
                'post_status' => $_POST['status'] ?? 'draft',
                'post_author' => (int)$_POST['author'] ?? get_current_user_id(),
                'post_type' => 'vacancy',
                'meta_input' => [
                    'compensation_range_from' => filter_var($_POST['compensationFrom'], FILTER_SANITIZE_NUMBER_FLOAT) ?? 0,
                    'compensation_range_to' => filter_var($_POST['compensationTo'], FILTER_SANITIZE_NUMBER_FLOAT) ?? 0,
                    'street_address' => $_POST['street'] ?? '',
                    'hiring_company' => $_POST['company'],
                    'why_work_at_this_company' => $_POST['reasonsToWork'],
                    'hiring_company_description' => $_POST['companyDesc'],
                    'send_new_candidates_to' => $_POST['notifyMe'] === 'on' ? 1 : 0,
                    'emails_to_inform' => $_POST['notifyEmail'] === 'on' ? 1 : 0,
                    'is_commission_included' => $_POST['isCommissionIncluded'] === 'on' ? 1 : 0,
                    'additional_options' => explode(',', $_POST['agreements']),
                    'benefits' => explode(',', $_POST['benefits']),
                ],
                'tax_input' => [
                    'type' => explode(',', $_POST['typeId']) ?? [],
                    'skill' => explode(',', $_POST['skills']) ?? [],
                    'location' => explode(',', $_POST['location']) ?? [],
                ],
            ];

            $postId = wp_insert_post(wp_slash($postData));
            if (!$postId) {
                $this->response->setMessage(
                    'Job wansn\'t created, please try again later or send email to support team'
                )->setStatus(501)->send();
            }
            $this->response
                ->setId($postId)
                ->setPermalink(get_the_permalink($postId))
                ->setMessage('Data was saved successfully')
                ->setStatus(201)
                ->send();
        } catch (\Exception $ex) {
            $this->response
                ->setMessage($ex->getMessage())
                ->setStatus(501)
                ->send();
        }
    }

    public function duplicateJobAjax()
    {
        try {
            $postId = (int)$_POST['postId'] ?? false;
            $postAuthor = (int)$_POST['author'] ?? false;
            $post = get_post($postId);
            if (!$post) {
                $this->response
                    ->setMessage("Vacancy with ID {$postId} doesn't exist")
                    ->setStatus(404)
                    ->send();
            }
            if ($post->post_author != $postAuthor) {
                $this->response
                    ->setMessage("Vacancy with ID {$postId} doesn't belong to you")
                    ->setStatus(401)
                    ->send();
            }

            $postMeta = get_post_meta($post->ID);
            $meta = array_map(
                function ($element) {
                    return $element[0];
                },
                $postMeta
            );
            // post data arr
            $postData = [
                'post_title' => $post->post_title . ' (copy)',
                'post_content' => $post->post_content,
                'post_status' => 'draft',
                'post_author' => $post->post_author,
                'post_type' => $post->post_type,
                'tax_input' => [
                    'type' => wp_get_post_terms($post->ID, 'type', ['fields' => 'ids']),
                    'skill' => wp_get_post_terms($post->ID, 'skill', ['fields' => 'ids']),
                    'location' => wp_get_post_terms($post->ID, 'location', ['fields' => 'ids']),
                ],
                'meta_input' => $meta,
            ];
            $postId = wp_insert_post(wp_slash($postData));
            if (!$postId) {
                $this->response->setMessage(
                    'Job wansn\'t created, please try again later or send email to support team'
                )->setStatus(501)->send();
            }

            $this->response
                ->setId($postId)
                ->setPermalink(get_the_permalink($postId))
                ->setMessage('Job was copied')
                ->setStatus(201)
                ->send();
        } catch (\Exception $ex) {
            $this->response
                ->setMessage($ex->getMessage())
                ->setStatus(501)
                ->send();
        }
    }

    public function loadMoreItems()
    {
        try {
            if (empty($_POST['offset'])) {
                $this->response->setMessage(
                    'Offset data is required'
                )->setStatus(204)->send();
            }
            $query = new WP_Query(
                [
                    'post_type' => $_POST['post_type'] ?? 'vacancy',
                    'post_status' => $_POST['post_status'] ?? 'publish',
                    'per_page' => (int)$_POST['per_page'] ?? 10,
                    'offset' => (int)$_POST['offset'],
                    'fields' => 'ids'
                ]
            );

            if($query->have_posts()) {
                global $post;
                ob_start();
                foreach ($query->posts as $post){
                    setup_postdata($post);
                    get_template_part('template-parts/vacancy/card', 'default');
                }
                wp_reset_postdata();
                $html = ob_get_clean();

                $this->response
                    ->setMessage('Data returned')
                    ->setStatus(200)
                    ->setResponseBody($html)
                    ->setCount($query->post_count)
                    ->setTotal($query->found_posts)
                    ->send();
            } else {
                $this->response->setMessage(
                    'No items found'
                )->setStatus(204)->send();
            }
        } catch (\Exception $ex) {
            $this->response
                ->setMessage($ex->getMessage())
                ->setStatus(501)
                ->send();
        }
    }

    /**
     * Load more ajax call for jobs filter page.
     */
    public function filterLoadMoreCallback(): void
    {
        try {
            if (empty($_POST['paged'])) {
                $this->response
                    ->setMessage('Paged data is required')
                    ->setStatus(204)
                    ->send();
            }

            $perPage = (int) get_option( 'posts_per_page' );
            $paged = (int) $_POST['paged'];
            $filtersValues['s'] = $_POST['s'] ?? '';
            $filtersValues['location'] = $_POST['location'] ?? '';
            $filtersValues['compensation'] = (int) ($_POST['compensation'] ?? 0);
            $filtersValues['employment-type'] = (int) ($_POST['employment_type'] ?? 0);
            $filtersValues['category'] = (int) ($_POST['category'] ?? 0);
            $filtersValues['company'] = $_POST['company'] ?? '';

            $filter = new JobFilter($filtersValues, ++$paged);

            if ($filter->getFoundJobs() === 0) {
                $this->response
                    ->setMessage('No items found')
                    ->setStatus(204)
                    ->setIsEnd(true)
                    ->send();
            }

            $this->response
                ->setMessage('Returned vacancies html')
                ->setStatus(200)
                ->setResponseBody($filter->render())
                ->setPaged($paged)
                ->setTotal($filter->getFoundJobs())
                ->setIsEnd($filter->getFoundJobs() <= $perPage * $paged)
                ->send();

        } catch (Exception $ex) {
            $this->response
                ->setMessage($ex->getMessage())
                ->setStatus(501)
                ->send();
        }
    }

    /**
     * Add / Remove user jobs bookmark.
     */
    public function updateBookmark(): void
    {

        try {
            if (empty($_POST['id'])) {
                $this->response
                    ->setMessage('ID data is required')
                    ->setStatus(204)
                    ->send();
            }

            $id = (int) $_POST['id'];
            $userId = get_current_user_id();
            $candidate = UserService::getUser();
            $savedJobs = $candidate->getSavedJobs();

            if (!is_array($savedJobs)) {
                $savedJobs = [];
            }

            if (array_key_exists($id, $savedJobs)) {
                unset($savedJobs[$id]);
                $isAdd = false;
            } else {
                $savedJobs[$id] = $id;
                $isAdd = true;
            }

            update_user_meta($userId, 'jobs_bookmarks', $savedJobs);

            $this->response
                ->setMessage( $isAdd ? 'Added to bookmarks' : 'Removed from bookmarks')
                ->setStatus(200)
                ->setId($id)
                ->setIsAdded($isAdd)
                ->send();
        } catch (Exception $ex) {
            $this->response
                ->setMessage($ex->getMessage())
                ->setStatus(501)
                ->send();
        }
    }

    /**
     * Add job to users dismissed jobs.
     */
    public function dismissJob(): void
    {
        if (empty($_POST['id'])) {
            $this->response
                ->setMessage('ID data is required')
                ->setStatus(204)
                ->send();
        }

        $id = (int) $_POST['id'];
        $userId = get_current_user_id();
        $candidate = UserService::getUser();
        $dismissedJobs = $candidate->getDismissedJobs();

        if (!is_array($dismissedJobs)) {
            $dismissedJobs = [];
        }

        if (!array_key_exists($id, $dismissedJobs)) {
            $dismissedJobs[$id] = $id;
            update_user_meta($userId, 'dismissed_jobs', $dismissedJobs);
        }

        $this->response
            ->setMessage('Added to dismissed jobs')
            ->setStatus(200)
            ->setId($id)
            ->send();
    }

    /**
     * Remove job from users dismissed jobs.
     */
    public function unDismissJob(): void
    {
        if (empty($_POST['id'])) {
            $this->response
                ->setMessage('ID data is required')
                ->setStatus(204)
                ->send();
        }

        $id = (int) $_POST['id'];
        $userId = get_current_user_id();
        $candidate = UserService::getUser();
        $dismissedJobs = $candidate->getDismissedJobs();

        if (!is_array($dismissedJobs)) {
            $dismissedJobs = [];
        }

        if (array_key_exists($id, $dismissedJobs)) {
            unset($dismissedJobs[$id]);
            update_user_meta($userId, 'dismissed_jobs', $dismissedJobs);
        }

        $this->response
            ->setMessage('Removed from dismissed jobs')
            ->setStatus(200)
            ->setId($id)
            ->send();
    }

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        if (!$this->currencies && !empty($this->jobSettings['currency'])) {
            $this->currencies = $this->jobSettings['currency'];
        }
        return $this->currencies;
    }

    public function getBenefits(): array
    {
        if (!$this->benefits && !empty($this->jobSettings['benefits'])) {
            $this->benefits = $this->jobSettings['benefits'];
        }
        return $this->benefits;
    }

    public function applyJobAjaxCallback(): void
    {
        if (empty($_POST['vacancyId'])) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('ID data is required', 'ecjobhunting'))
                ->send();
        }

        $vacancy = new Vacancy((int) $_POST['vacancyId']);
        $userId = get_current_user_id();

        if (!$vacancy) {
            $this->response
                ->setStatus(204)
                ->setMessage(__('Incorrect vacancy ID', 'ecjobhunting'))
                ->send();
        }

        $candidates = $vacancy->getCandidates();

        if (!in_array($userId, $candidates)) {
            $candidates[] = $userId;
            $this->response->setMessage('applied');
            update_field('applied', $candidates, $vacancy->getId());
        }


        $this->response
            ->setStatus(200)
            ->send();
    }
}

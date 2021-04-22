<?php


namespace EcJobHunting\Service\Job;


use EcJobHunting\Front\EcResponse;
use EcJobHunting\Front\SiteSettings;
use EcJobHunting\Interfaces\AjaxResponse;
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

            //duplicate job
            add_action('wp_ajax_load_more', [$this, 'loadMoreItems']);
            add_action('wp_ajax_nopriv_load_more', [$this, 'loadMoreItems']);

            //edit job
            add_action('wp_ajax_edit_job', [$this, 'editJobAjax']);
            add_action('wp_ajax_nopriv_edit_job', [$this, 'editJobAjax']);
        }
    }

    public function __construct()
    {
        $this->jobSettings = SiteSettings::getJobSettings();
        $this->response = new EcResponse();
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
}
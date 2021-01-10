<?php


namespace EcJobHunting\Service\Job;


use EcJobHunting\Front\EcResponse;
use EcJobHunting\Front\SiteSettings;
use EcJobHunting\Interfaces\AjaxResponse;

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
        }
    }

    public function __construct()
    {
        $this->jobSettings = SiteSettings::getJobSettings();
        $this->response = new EcResponse();
    }

    public function createNewJobAjax()
    {
        $benefits = [];
        $postData = [
            'post_title' => wp_strip_all_tags($_POST['title'] ?? 'Vacancy'),
            'post_content' => $_POST['description'] ?? '',
            'post_status' => $_POST['status'] ?? 'draft',
            'post_author' => (int)$_POST['author'] ?? get_current_user_id(),
            'post_type' => 'vacancy',
            'meta_input' => [
                'compensation_range_from' => $_POST['compensationFrom'] ?? 0,
                'compensation_range_to' => $_POST['compensationTo'] ?? 0,
                'street_address' => $_POST['street'] ?? '',
                'hiring_company' => $_POST['company'],
                'why_work_at_this_company' => $_POST['reasonsToWork'],
                'hiring_company_description' => $_POST['companyDesc'],
                'send_new_candidates_to' => $_POST['notifyMe'],
                'emails_to_inform' => $_POST['notifyEmail'] === 'on' ? 1 : 0,
                'is_commission_included' => $_POST['isCommissionIncluded'] === 'on' ? 1 : 0,
                'additional_options' => serialize($_POST['agreements']),
            ],
            'tax_input' => [
                'type' => explode(',', $_POST['typeId']) ?? [],
                'skill' => explode(',', $_POST['skills']) ?? [],
                'location' => explode(',', $_POST['location']) ?? [],
            ],
        ];

        $postId = wp_insert_post(wp_slash($postData));
        if (!$postId) {
            $this->response->setResponseBody(
                'Job wansn\'t created, please try again later or send email to support team'
            )->setStatus(501)->send();
        }
        if (!empty($_POST['benefits'])) {
            $benefitsSrc = explode(',', $_POST['benefits']);
            foreach ($benefitsSrc as $benefit) {
                array_push(
                    $benefits,
                    [
                        'field_5fecd64bc26ba' => $benefit,
                    ],
                );
            }
            update_field('field_5fecd57ec26b9', $benefits, $postId);
        }

        $this->response->setResponseBody(
            'Data was saved successfully'
        )->setStatus(201)->send();
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
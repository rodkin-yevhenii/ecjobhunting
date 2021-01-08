<?php


namespace EcJobHunting\Service\Job;


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

    public function __invoke()
    {
        if (wp_doing_ajax()) {
            //create job
            add_action('wp_ajax_create_job', [$this, 'createNewJobAjax']);
            add_action('wp_ajax_create_job', [$this, 'createNewJobAjax']);
        }

    }

    public function __construct()
    {
        $this->jobSettings = SiteSettings::getJobSettings();
    }

    public function createNewJobAjax(AjaxResponse $response)
    {
        $response->send();
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
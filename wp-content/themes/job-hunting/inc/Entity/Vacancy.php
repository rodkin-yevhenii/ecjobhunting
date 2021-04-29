<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Front\SiteSettings;
use EcJobHunting\Service\User\UserService;

class Vacancy
{
    private ?int $id = null;
    private string $permalink = '';
    private string $title = '';
    private string $description = '';
    private ?string $datePosted = '';
    private ?int $author = null;
    private array $benefits = [];
    private string $currency = 'USD';
    private array $compensationRange = ['from' => 0, 'to' => 0];
    private float $compensationFrom = 0;
    private float $compensationTo = 0;
    private string $compensationPeriod = 'annualy';
    private bool $isCommissionIncluded = false;
    private string $status = 'draft';

    //Taxonomies
    private array $location = []; // taxonomy Location
    private array $employmentType = []; //taxonomy types
    private array $skills = []; //taxonomy Skills

    //employer info
    private $employer;
    private string $streetAddress = '';
    private string $companyName = '';
    private string $reasonsToWork = '';
    private string $companyDescription = '';
    private bool $notifyEmployer = true;
    private string $emailsToNotify = '';
    private array $agreementOptions = [];

    //statistic
    private array $candidates = [];
    private int $candidatesNumber = 0;
    private int $visitors = 0;

    //
    private $fieldsObject;

    public function __construct(?int $id = null)
    {
        $vacancy = get_post($id);
        if ($vacancy) {
            // Basic Data
            $this->id = $id;
            $this->title = $vacancy->post_title;
            $this->description = strip_tags($vacancy->post_content);
            $this->author = $vacancy->post_author;
            $this->datePosted = $vacancy->post_date;
            $this->fieldsObject = get_field_object('post_new_job', 'option');
            $this->permalink = get_the_permalink($id);
            $this->employer = UserService::getUser($this->author);
            $this->status = $vacancy->post_status;
            //Meta Data
            $fields = get_fields($id);
            if ($fields) {
                $this->compensationFrom = floatval(!empty($fields['compensation_range']['from']) ? $fields['compensation_range']['from'] : 0);
                $this->compensationTo = floatval(!empty($fields['compensation_range']['to']) ? $fields['compensation_range']['to'] : 0);
                $this->compensationRange = !empty($fields['compensation_range']) ? $fields['compensation_range'] : $this->compensationRange;
                $this->streetAddress = !empty($fields['street_address']) ? $fields['street_address'] : '';

                $this->companyName = $fields['hiring_company'] ?? '';
                $this->reasonsToWork = $fields['why_work_at_this_company'] ?? '';
                $this->companyDescription = $fields['hiring_company_description'] ?? '';
                $this->notifyEmployer = (bool) ($fields['emails_to_inform'] ?? true);
                $this->isCommissionIncluded = (bool) ($fields['is_commission_included'] ?? false);
                $this->agreementOptions = $fields['additional_options'] ?? [];
                $this->benefits = isset($fields['benefits']) ? (array)$fields['benefits'] : [];
                $this->visitors = (int) ($fields['visitors'] ?? 0);
                $this->candidates = (array) ($fields['applied'] ?? []);
                $this->currency = ucwords($fields['compensation_currency'] ?? 'USD');
                $this->compensationPeriod = $fields['compensation_period'] ?? 'annualy';

                $this->employmentType = wp_get_post_terms($id, 'type', ['fields' => 'names']);
                $this->location = wp_get_post_terms($id, 'location', ['fields' => 'names']);
            }
        } else {
            $this->employer = UserService::getUser();
        }
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int|mixed
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed|string
     */
    public function getReasonsToWork()
    {
        return $this->reasonsToWork;
    }

    /**
     * @return array|mixed|string
     */
    public function getLocation()
    {
        return implode(', ', $this->location);
    }

    /**
     * @return array|int[]|mixed
     */
    public function getCompensationRange()
    {
        return $this->compensationRange;
    }

    /**
     * @return mixed|string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return mixed|string
     */
    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    /**
     * @return array|mixed
     */
    public function getBenefits()
    {
        if (!empty($this->fieldsObject['value']['benefits']) && is_array(
                $this->fieldsObject['value']['benefits']
            )) {
            $columns = array_column($this->fieldsObject['value']['benefits'], 'key');
            $values = [];
            foreach ($this->benefits as $benefit) {
                $key = array_search($benefit, $columns);
                if ($key !== false) {
                    array_push($values, $this->fieldsObject['value']['benefits'][$key]['name']);
                }
            }
            return $values;
        }
        return $this->benefits;
    }

    /**
     * @return int|string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return Candidate|Company|EcJobUser
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array|bool
     */
    public function getAgreementOptions()
    {
        return $this->agreementOptions;
    }

    /**
     * @return array|mixed
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * @return int
     */
    public function getCandidatesNumber(): int
    {
        return $this->candidatesNumber;
    }

    /**
     * @return float|int|string
     */
    public function getCompensationTo()
    {
        return is_numeric($this->compensationTo) ? number_format($this->compensationTo, 2, '.', '') : 0.00;
    }

    /**
     * @return float|int|string
     */
    public function getCompensationFrom()
    {
        return is_numeric($this->compensationFrom) ? number_format($this->compensationFrom, 2, '.', '') : 0.00;
    }

    /**
     * @return string
     */
    public function getCompensationPeriodName(): string
    {
        if (!empty($this->fieldsObject['value']['compensation_period']) && is_array(
                $this->fieldsObject['value']['compensation_period']
            )) {
            $key = array_search(
                $this->compensationPeriod,
                array_column($this->fieldsObject['value']['compensation_period'], 'key')
            );
            return $this->fieldsObject['value']['compensation_period'][$key]['name'];
        }
        return $this->compensationPeriod;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string|null
     */
    public function getDatePosted(): ?string
    {
        return $this->datePosted;
    }

    /**
     * @return mixed|string
     */
    public function getEmailsToNotify()
    {
        return $this->emailsToNotify;
    }

    /**
     * @return string
     */
    public function getEmploymentType(): string
    {
        return implode(', ', $this->employmentType);
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        return $this->skills;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    /**
     * @return false|string|\WP_Error
     */
    public function getPermalink()
    {
        return $this->permalink;
    }
}

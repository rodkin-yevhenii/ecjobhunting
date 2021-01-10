<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;

class Vacancy
{
    private ?int $id= null;
    private string $title = '';
    private string $description = '';
    private ?string $datePosted = '';
    private ?int $author = null;
    private array $benefits = [];
    private string $currency = 'USD';
    private array $compensationRange = ['from' => 0, 'to' => 0];
    private float $compensationMin = 0;
    private float $compensationMax = 0;
    private string $compensationPeriod = 'annualy';
    private bool $isCommissionIncluded = false;

    //Taxonomies
    private array $location = []; // taxonomy Location
    private array $employmentType = []; //taxonomy types
    private array $skills = []; //taxonomy Skills

    //employer info
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


    private $employer;

    public function __construct(?int $id= null)
    {
        $vacancy = get_post($id);
        if ($vacancy) {
            // Basic Data
            $this->title = $vacancy->post_title;
            $this->description = strip_tags($vacancy->post_content);
            $this->author = $vacancy->post_author;


            //Meta Data
            $fields = get_field($id);
            if ($fields) {
                $this->visitors = !empty($fields['visitors']) ? $fields['visitors'] : 0;
                $this->candidates = !empty($fields['applied']) ? $fields['applied'] : [];
                $this->candidatesNumber = count($this->candidates);
                $this->benefits = !empty($fields['benefits']) ? $fields['benefits'] : [];
                $this->compensationRange = !empty($fields['compensation_range']) ? $fields['compensation_range'] : $this->compensationRange;
                $this->location = !empty($fields['street_address']) ? $fields['street_address'] : '';
                $this->companyName = !empty($fields['hiring_company']) ? $fields['hiring_company']
                    : $this->employer->getName();
                $this->reasonsToWork = !empty($fields['why_work_at_this_company']) ? $fields['why_work_at_this_company'] : '';
                $this->companyDescription = !empty($fields['hiring_company_description']) ? $fields['hiring_company_description'] : '';
                $this->emailsToNotify = !empty($fields['emails_to_inform']) ? $fields['emails_to_inform']
                    : $this->employer->getEmail();
                if (is_array($fields['additional_options'])) {
                    $this->agreementOptions = in_array('closest', $fields['additional_options']) ?? false;
                }
            }
        } else {
            $this->employer = UserService::getUser();
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Candidate|Company|EcJobUser
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @return mixed|string
     */
    public function getEmail()
    {
        return $this->emailsToNotify;
    }

    /**
     * @return array|mixed
     */
    public function getApplied()
    {
        return $this->applied;
    }

    /**
     * @return int|string|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return array|mixed
     */
    public function getBenefits()
    {
        return $this->benefits;
    }

    /**
     * @return mixed|string
     */
    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    /**
     * @return mixed|string
     */
    public function getCompanyName()
    {
        return $this->companyName;
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed|string
     */
    public function getReasonsToWork()
    {
        return $this->reasonsToWork;
    }

    /**
     * @return int|mixed
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
}
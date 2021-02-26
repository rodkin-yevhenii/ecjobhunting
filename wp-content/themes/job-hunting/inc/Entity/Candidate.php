<?php

namespace EcJobHunting\Entity;

class Candidate extends UserAbstract
{
    private ?int $cvId;
    private bool $isPublished = false;
    private ?array $fields;
    private string $headline;
    private string $location;
    private string $zipCode;
    private bool $relocate = false;
    private string $phoneNumber;
    private string $email;
    private bool $isEmailConfirmed;
    private string $webSite;
    private string $twitter;
    private string $linkedin;
    private string $facebook;
    private array $experience;
    private array $education;
    private string $summary;
    private string $salaryExpectation = '0';

    public function __construct($user)
    {
        parent::__construct($user);
        $cvs = get_posts(
            [
                'post_type' => 'cv',
                'numberposts' => 1,
                'fields' => 'ids',
                'author' => $this->getUserId(),
            ]
        );
        if (!$cvs) {
            $this->cvId = wp_insert_post(
                [
                    'post_type' => 'cv',
                    'post_title' => $this->getName(),
                    'post_author' => $this->getUserId(),
                ]
            );
        } else {
            $this->cvId = $cvs[0];
        }
        $fields = get_fields($this->cvId);
        $this->fields = $fields ? $fields : [];
    }

    /**
     * @return int|\WP_Error|\WP_Post|null
     */
    public function getCvId()
    {
        return $this->cvId;
    }

    // TODO Clarify with client Where needs to be displayed on FRONT
    public function getHeadline()
    {
        if (empty($this->headline)) {
            $this->headline = $this->fields['headline'] ?? '';
        }

        return $this->headline;
    }

    public function getLocation()
    {
        if (empty($this->location)) {
            $this->location = $this->fields['location'] ?? '';
        }

        return $this->location;
    }

    // TODO Clarify with client Where needs to be displayed on FRONT
    public function getZipCode()
    {
        if (empty($this->zipCode)) {
            $this->zipCode = $this->fields['zip_code'] ?? '';
        }

        return $this->zipCode;
    }

    // TODO Clarify with client Where needs to be displayed on FRONT + Shall User set where he want to relocate
    public function isReadyToRelocate()
    {
        if (empty($this->relocate)) {
            $this->relocate = (bool)$this->fields['relocate'] ?? false;
        }

        return $this->relocate;
    }


    //Contact information

    /**
     * @return string
     */
    public function getEmail(): string
    {
        if (empty($this->email)) {
            $this->email = $this->fields['public_email'] ?? parent::getEmail();
        }

        return $this->email;
    }

    /**
     * @return bool
     */
    public function isEmailConfirmed(): bool
    {
        if (empty($this->isEmailConfirmed)) {
            $this->isEmailConfirmed = (bool)$this->fields['is_email_confirmed'] ?? false;
        }
        return $this->isEmailConfirmed;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        if (empty($this->phoneNumber)) {
            $this->phoneNumber = $this->fields['phone'] ?? '';
        }
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getWebSite(): string
    {
        if (empty($this->webSite)) {
            $this->webSite = $this->fields['website'] ?? '';
        }
        return $this->webSite;
    }

    /**
     * @return string
     */
    public function getTwitter(): string
    {
        if (empty($this->twitter)) {
            $this->twitter = $this->fields['twitter'] ?? '';
        }
        return $this->twitter;
    }

    /**
     * @return string
     */
    public function getLinkedin(): string
    {
        if (empty($this->linkedin)) {
            $this->linkedin = $this->fields['linkedin'] ?? '';
        }
        return $this->linkedin;
    }

    /**
     * @return string
     */
    public function getFacebook(): string
    {
        if (empty($this->facebook)) {
            $this->facebook = $this->fields['facebook'] ?? '';
        }
        return $this->facebook;
    }

    /// CV data ///

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        $postStatus = get_post_status($this->cvId);
        if ('publish' === $postStatus) {
            $this->isPublished = true;
        }
        return $this->isPublished;
    }

    /**
     * @return array
     */
    public function getExperience(): array
    {
        if (empty($this->experience)) {
            $this->experience = $this->fields['work_experience'] ?? [];
        }
        return $this->experience;
    }

    /**
     * @return array
     */
    public function getEducation(): array
    {
        if (empty($this->education)) {
            $this->education = $this->fields['education'] ?? [];
        }
        return $this->education;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        if (empty($this->summary)) {
            $this->summary = get_the_content(null, null, $this->cvId);
        }
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getSalaryExpectation(): string
    {
        if (empty($this->salaryExpectation)) {
            $this->salaryExpectation = $this->fields['salary'] ?? '';
        }
        return $this->salaryExpectation;
    }
}
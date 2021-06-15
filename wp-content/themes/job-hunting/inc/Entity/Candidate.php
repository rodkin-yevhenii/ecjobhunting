<?php

namespace EcJobHunting\Entity;

class Candidate extends UserAbstract
{
    private ?int $cvId;
    private bool $isPublished = false;
    private ?array $fields;
    private string $name;
    private string $headline;
    private string $location;
    private string $zipCode;
    private bool $relocate = false;
    private string $phoneNumber;
    private string $email;
    private string $newEmail;
    private string $hash;
    private bool $isEmailConfirmed;
    private string $webSite;
    private string $twitter;
    private string $linkedin;
    private string $facebook;
    private array $experience;
    private array $education;
    private string $objective;
    private array $achievements;
    private array $associations;
    private string $summary;
    private int $salaryExpectation = 0;
    private string $yearsOfExperience = '';
    private string $highestDegreeEarned = '';
    private string $veteranStatus = '';
    private array $skills;
    private string $category = '';
    private string $resumeFile = '';

    public function __construct($user)
    {
        parent::__construct($user);
        $cvs = get_posts(
            [
                'post_type' => 'cv',
                'post_status' => ['publish', 'draft'],
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

    public function getName()
    {
        if (empty($this->name)) {
            $user = \get_user_by('id', $this->getUserId());
            $this->name = $this->fields['full_name'] ?? $user->display_name;
        }

        return $this->name;
    }

    public function getHeadline()
    {
        if (empty($this->headline)) {
            $this->headline = $this->fields['headline'] ?? '';
        }

        return $this->headline;
    }

    public function getLocation()
    {
        if (!empty($this->location)) {
            return $this->location;
        }

        $terms = wp_get_post_terms($this->cvId, 'location', ['fields' => 'names']);

        if (is_wp_error($terms) || empty($terms)) {
            return '';
        }

        $this->location = $terms[0];

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
     * @return string
     */
    public function getNewEmail(): string
    {
        if (empty($this->newEmail)) {
            $this->newEmail = $this->fields['new_email'] ?? '';
        }

        return $this->newEmail;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        if (empty($this->hash)) {
            $this->hash = $this->fields['hash'] ?? '';
        }

        return $this->hash;
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
            $this->experience = !empty($this->fields['work_experience']) ? $this->fields['work_experience'] : [];
        }
        return $this->experience;
    }

    /**
     * @return array
     */
    public function getEducation(): array
    {
        if (empty($this->education)) {
            $this->education = !empty($this->fields['education']) ? $this->fields['education'] : [];
        }
        return $this->education;
    }

    /**
     * @return string
     */
    public function getObjective(): string
    {
        if (empty($this->objective)) {
            $this->objective = $this->fields['objective'] ?? '';
        }
        return $this->objective;
    }

    /**
     * @return string
     */
    public function getAchievements(): array
    {
        if (empty($this->achievements)) {
            $this->achievements = !empty($this->fields['achievements']) ? $this->fields['achievements'] : [];
        }
        return $this->achievements;
    }

    /**
     * @return string
     */
    public function getAssociations(): array
    {
        if (empty($this->associations)) {
            $this->associations = !empty($this->fields['associations']) ? $this->fields['associations'] : [];
        }
        return $this->associations;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        if (empty($this->summary)) {
            $this->summary = $this->fields['executive_summary'] ?? '';
        }
        return $this->summary;
    }

    /**
     * @return int
     */
    public function getSalaryExpectation(): int
    {
        if (empty($this->salaryExpectation)) {
            $this->salaryExpectation = (int)($this->fields['salary'] ?? 0);
        }
        return $this->salaryExpectation;
    }

    /**
     * @return string
     */
    public function getYearsOfExperience(): string
    {
        if (empty($this->yearsOfExperience)) {
            $this->yearsOfExperience = $this->fields['years_of_experience'] ?? '';
        }

        return $this->yearsOfExperience;
    }

    /**
     * @return string
     */
    public function getHighestDegreeEarned(): string
    {
        if (empty($this->highestDegreeEarned)) {
            $this->highestDegreeEarned = $this->fields['degree_earned'] ?? '';
        }

        return $this->highestDegreeEarned;
    }

    /**
     * @return string
     */
    public function getVeteranStatus(): string
    {
        if (empty($this->veteranStatus)) {
            $this->veteranStatus = $this->fields['veteran_status'] ?? '';
        }

        return $this->veteranStatus;
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        if (empty($this->skills)) {
            $terms = wp_get_post_terms($this->cvId, 'skill', ['fields' => 'id=>name']);

            if (is_wp_error($terms) || empty($terms)) {
                return [];
            }

            $this->skills = $terms;
        }

        return $this->skills;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        if (empty($this->category)) {
            $terms = wp_get_post_terms($this->cvId, 'job-category', ['fields' => 'names']);

            if (is_wp_error($terms) || empty($terms)) {
                return '';
            }

            $this->category = $terms[0];
        }

        return $this->category;
    }

    /**
     * @return string
     */
    public function getResumeFile(): string
    {
        if (empty($this->resumeFile)) {
            $this->resumeFile = $this->fields['resume_file'] ?? '';
        }

        return $this->resumeFile;
    }
}

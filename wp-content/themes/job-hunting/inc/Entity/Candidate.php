<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;

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
    private array $resumeFile;
    private array $references;
    private array $certificates;
    private array $savedJobs;
    private array $dismissedJobs;
    private string $lastActivity;
    private string $currentPosition = '';
    private string $currentCompany = '';

    public function __construct(\WP_User $user)
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
        if (!$cvs && UserService::isCandidate()) {
            $this->cvId = wp_insert_post(
                [
                    'post_type' => 'cv',
                    'post_title' => $this->getName(),
                    'post_author' => $this->getUserId(),
                    'post_status'   => 'publish',
                ]
            );

            if ($this->cvId && !is_wp_error($this->cvId)) {
                update_field('new_email', $user->user_email, $this->cvId);
                update_field('is_email_confirmed', false, $this->cvId);
                update_field('degree_earned', 'no_degree', $this->cvId);
            }
        } elseif ($cvs) {
            $this->cvId = $cvs[0];
        } else {
            return;
        }

        $fields = get_fields($this->cvId);
        $this->fields = $fields ? $fields : [];

        if (!empty($fields['work_experience']) && is_array($fields['work_experience'])) {
            foreach ($fields['work_experience'] as $work) {
                if (!isset($work['period']['is_in_progress']) || !$work['period']['is_in_progress']) {
                    continue;
                }

                $this->currentCompany = $work['company_name'] ?? '';
                $this->currentPosition = $work['job_position'] ?? '';
            }
        }
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
            $this->relocate = (bool) ($this->fields['relocate'] ?? false);
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
            $this->email = $this->fields['public_email'] ?? '';
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
            $this->isEmailConfirmed = $this->fields['is_email_confirmed'] ?? true;
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
            $fieldObj = get_field_object('degree_earned', $this->getCvId());
            $degree = $this->fields['degree_earned'] ?? '';

            if (!empty($fieldObj['choices']) && array_key_exists($degree, $fieldObj['choices'])) {
                $this->highestDegreeEarned = $fieldObj['choices'][$degree];
            } else {
                $this->highestDegreeEarned = '';
            }
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
    public function getResumeFile(): array
    {
        if (empty($this->resumeFile)) {
            $this->resumeFile = empty($this->fields['resume_file']) ? [] : $this->fields['resume_file'];
        }

        return $this->resumeFile;
    }

    /**
     * @return array
     */
    public function getReferences(): array
    {
        if (empty($this->references)) {
            $this->references = empty($this->fields['references']) ? [] : $this->fields['references'];
        }

        return $this->references;
    }

    /**
     * @return array
     */
    public function getCertificates(): array
    {
        if (empty($this->certificates)) {
            $this->certificates = empty($this->fields['certificates']) ? [] : $this->fields['certificates'];
        }

        return $this->certificates;
    }

    /**
     * @return array
     */
    public function getSavedJobs(): array
    {
        if (empty($this->savedJobs)) {
            $savedJobs = get_user_meta($this->getUserId(), 'jobs_bookmarks', true);
            $this->savedJobs = empty($savedJobs) ? [] : $savedJobs;
        }

        return $this->savedJobs;
    }

    /**
     * @return array
     */
    public function getDismissedJobs(): array
    {
        if (empty($this->dismissedJobs)) {
            $dismissedJobs = get_user_meta($this->getUserId(), 'dismissed_jobs', true);
            $this->dismissedJobs = empty($dismissedJobs) ? [] : $dismissedJobs;
        }

        return $this->dismissedJobs;
    }

    /**
     * @return string
     */
    public function getLastActivity(): string
    {
        if (empty($this->lastActivity)) {
            $this->lastActivity = empty($this->fields['last_activity']) ? '' : $this->fields['last_activity'];
        }

        return $this->lastActivity;
    }

    public function getPermalink()
    {
        return get_post_permalink($this->getCvId());
    }

    /**
     * @return mixed|string
     */
    public function getCurrentPosition()
    {
        return $this->currentPosition;
    }

    /**
     * @return mixed|string
     */
    public function getCurrentCompany()
    {
        return $this->currentCompany;
    }

    /**
     * @return string
     */
    public function getCurrentPositionAndCompanyText(): string
    {
        if (empty($this->currentPosition) && empty($this->currentCompany)) {
            return '';
        } elseif (!empty($this->currentCompany) && !empty($this->currentPosition)) {
            return sprintf('For %s at %s', $this->currentPosition, $this->currentCompany);
        } elseif (!empty($this->currentCompany)) {
            return sprintf('At %s', $this->currentCompany);
        } else {
            return sprintf('For %s', $this->currentPosition);
        }
    }
}

<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;
use WP_Query;

class Company extends UserAbstract
{
    private bool $isActivated = false;
    private float $credits = 0;
    private array $vacancies = [];
    private array $newVacancies = [];
    private array $activeVacancies = [];
    private array $draftVacancies = [];
    private array $closedVacancies = [];
    private array $candidates = [];
    private int $jobPosted = 0;
    private int $jobVisitors = 0;
    private int $candidatesReceived;

    public function __construct($user)
    {
        parent::__construct($user);
        $this->isActivated = get_field('is_activated', 'user_' . $this->getUserId()) ?? false;
        $this->credits = floatval(get_field('avaible_credits', 'user_' . $this->getUserId()) ?? 0);
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->isActivated;
    }

    /**
     * @return float|int|mixed
     */
    public function getCredits()
    {
        $formatter = new \NumberFormatter("en-US", \NumberFormatter::CURRENCY);
        $symbol = $formatter->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
        return $formatter->formatCurrency($this->credits, $symbol);
    }

    /**
     * @return array
     */
    public function getVacancies(): array
    {
        if (!$this->vacancies) {
            $this->vacancies = $this->getVacanciesList();
        }
        return $this->vacancies;
    }

    /**
     * @return array
     */
    public function getNewVacancies(): array
    {
        if (!$this->newVacancies) {
            add_filter('posts_where', [$this, 'getVacanciesForMonth']);
            $this->newVacancies = $this->getVacanciesList(
                [
                    'suppress_filters' => false
                ]
            );
            remove_filter('posts_where', [$this, 'getVacanciesForMonth']);
        }

        return $this->newVacancies;
    }

    /**
     * @return array
     */
    public function getActiveVacancies(): array
    {
        if (!$this->activeVacancies) {
            $this->activeVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'publish'
                ]
            );
        }

        return $this->activeVacancies;
    }

    /**
     * @return array
     */
    public function getDraftVacancies(): array
    {
        if (!$this->draftVacancies) {
            $this->draftVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'draft'
                ]
            );
        }

        return $this->draftVacancies;
    }

    /**
     * @return array
     */
    public function getClosedVacancies(): array
    {
        if (!$this->closedVacancies) {
            $this->closedVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'private'
                ]
            );
        }

        return $this->closedVacancies;
    }

    /**
     * @param string $where SQL request
     *
     * @return string
     */
    public function getVacanciesForMonth(string $where = ''): string
    {
        $where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";

        return $where;
    }

    /**
     * @param $args array   Query args
     *
     * @return array
     */
    private function getVacanciesList(array $args = []): array
    {
        $defaultArgs = [
            'numberposts' => -1,
            'fields' => 'ids',
            'post_type' => 'vacancy',
            'post_status' => 'any',
        ];
        $args = array_merge($defaultArgs, $args);

        return get_posts($args);
    }

    /**
     * @return int
     */
    public function getJobPosted(): int
    {
        if (!$this->jobPosted) {
            $query = new WP_Query(
                [
                    'posts_per_page' => 1,
                    'fields' => 'ids',
                    'post_status' => 'publish',
                    'post_type' => 'vacancy',
                    'author' => $this->getUserId(),
                ]
            );
            $this->jobPosted = $query->found_posts;
        }
        return $this->jobPosted;
    }

    /**
     * @return int
     */
    public function getJobVisitors(): int
    {
        return $this->jobVisitors;
    }

    public function getCandidates(): array
    {
        if (!$this->candidates) {
            $vacancies = $this->getVacancies();
            foreach ($vacancies as $vacancy) {
                $applied = get_field('applied', $vacancy);
                if ($applied) {
                    $resumes = [];
                    foreach ($applied as $candidate) {
                        $resume = new Candidate(get_user_by('id', $candidate));
                        if ($resume->isPublished()) {
                            $resumes[] = $resume;
                        }
                    }
                    $this->candidates = array_merge($this->candidates, $resumes);
                }
            }
        }
        return $this->candidates;
    }
}

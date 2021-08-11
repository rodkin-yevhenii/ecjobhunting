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
    private array $appliedVacancies = [];
    private array $candidatesData = [];
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
     * @param string $search
     * @return array
     */
    public function getVacancies(string $search = ''): array
    {
        if (!$this->vacancies) {
            $this->vacancies = $this->getVacanciesList(
                [
                    's' => $search
                ]
            );
        }
        return $this->vacancies;
    }

    /**
     * @param string $search
     * @return array
     */
    public function getNewVacancies(string $search = ''): array
    {
        if (!$this->newVacancies) {
            add_filter('posts_where', [$this, 'getVacanciesForMonth']);
            $this->newVacancies = $this->getVacanciesList(
                [
                    'suppress_filters' => false,
                    's' => $search
                ]
            );
            remove_filter('posts_where', [$this, 'getVacanciesForMonth']);
        }

        return $this->newVacancies;
    }

    /**
     * @param string $search
     * @return array
     */
    public function getActiveVacancies(string $search = ''): array
    {
        if (!$this->activeVacancies) {
            $this->activeVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'publish',
                    's' => $search
                ]
            );
        }

        return $this->activeVacancies;
    }

    /**
     * @param string $search
     * @return array
     */
    public function getDraftVacancies(string $search = ''): array
    {
        if (!$this->draftVacancies) {
            $this->draftVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'draft',
                    's' => $search
                ]
            );
        }

        return $this->draftVacancies;
    }

    /**
     * @param string $search
     * @return array
     */
    public function getClosedVacancies(string $search = ''): array
    {
        if (!$this->closedVacancies) {
            $this->closedVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'private',
                    's' => $search
                ]
            );
        }

        return $this->closedVacancies;
    }

    /**
     * @param string $search
     * @return array
     */
    public function getAppliedVacancies(string $search = ''): array
    {
        if (!$this->appliedVacancies) {
            $this->appliedVacancies = $this->getVacanciesList(
                [
                    'post_status' => 'publish',
                    's' => $search,
                    'meta_query' => [
                        [
                            'key' => 'applied',
                            'value' => 0,
                            'compare' => '>'
                        ]
                    ]
                ]
            );
        }

         return $this->appliedVacancies;
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
        if (!$this->jobVisitors) {
            $vacancies = $this->getActiveVacancies();
            $counter = 0;

            foreach ($vacancies as $id) {
                $vacancy = new Vacancy($id);
                $counter += $vacancy->getVisitorsNumber();
            }

            $this->jobVisitors = $counter;
        }
        return $this->jobVisitors;
    }

    public function getCandidatesData(): array
    {
        if (!$this->candidatesData) {
            $allCandidates = get_field('candidates', 'user_' . $this->getUserId());

            if (empty($allCandidates)) {
                return [];
            }

            $activeVacancies = $this->getActiveVacancies();

            foreach ($allCandidates as $candidateData) {
                if (!in_array($candidateData['vacancy'], $activeVacancies)) {
                    continue;
                }

                $candidate = UserService::getUser($candidateData['employee']);

                if ('publish' !== get_post_status($candidate->getCvId())) {
                    continue;
                }

                $this->candidatesData[] = $candidateData;
            }
        }
        return $this->candidatesData;
    }

    public function getCandidates(): array
    {
        if (!$this->candidates) {
            $candidatesData = $this->getCandidatesData();

            if (empty($candidatesData)) {
                return [];
            }

            foreach ($candidatesData as $data) {
                $this->candidates[$data['employee']] = new Candidate(get_user_by('id', $data['employee']));
            }
        }

        return $this->candidates;
    }
}

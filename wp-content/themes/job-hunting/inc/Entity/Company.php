<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\User\UserService;
use WP_Query;

class Company extends UserAbstract
{
    private bool $isActivated = false;
    private bool $isUsedTrial = false;
    private float $credits = 0;
    private array $vacancies = [];
    private array $newVacancies = [];
    private array $activeVacancies = [];
    private array $draftVacancies = [];
    private array $closedVacancies = [];
    private array $appliedVacancies = [];
    private array $candidatesData = [];
    private array $candidates = [];
    private array $ratedCandidates = [];
    private array $greatMatchedCandidates = [];
    private array $interestedCandidates = [];
    private array $unratedCandidates = [];
    private array $newCandidates = [];
    private array $viewedCandidates = [];
    private int $jobPosted = 0;
    private int $jobVisitors = 0;
    private int $candidatesReceived;
    private int $subscriptionId;

    public function __construct($user)
    {
        parent::__construct($user);
        $this->isActivated = get_field('is_activated', 'user_' . $this->getUserId()) ?? false;
        $this->isUsedTrial = get_field('is_trial_used', 'user_' . $this->getUserId()) ?? false;
        $this->subscriptionId = get_field('user_subscription_id', 'user_' . $this->getUserId()) ?? 0;
        $this->credits = floatval(get_field('avaible_credits', 'user_' . $this->getUserId()) ?? 0);
    }

    /**
     * @return int|mixed
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->isActivated;
    }

    /**
     * @return bool
     */
    public function isUsedTrial(): bool
    {
        return $this->isUsedTrial;
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
            add_filter('posts_where', [$this, 'getDataForMonth']);
            $this->newVacancies = $this->getVacanciesList(
                [
                    'suppress_filters' => false,
                    's' => $search
                ]
            );
            remove_filter('posts_where', [$this, 'getDataForMonth']);
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
    public function getDataForMonth(string $where = ''): string
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
            'author' => $this->getUserId(),
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

                if (!$candidateData['employee']) {
                    continue;
                }

                $candidate = UserService::getUser($candidateData['employee']);

                if ('publish' !== get_post_status($candidate->getCvId())) {
                    continue;
                }

                $this->candidatesData[] = $candidateData;
            }

            usort($this->candidatesData, [$this, 'sortCandidatesDataByDate']);
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

    public function getRatedCandidates(): array
    {
        if (empty($this->ratedCandidates)) {
            $ratedCandidates = get_user_meta($this->getUserId(), 'rated_candidates', true);

            if (!is_array($ratedCandidates) || empty($ratedCandidates)) {
                return [];
            }

            $this->ratedCandidates = $ratedCandidates;
        }

        return $this->ratedCandidates;
    }

    /**
     * @return array
     */
    public function getGreatMatchedCandidatesData(): array
    {
        if (empty($this->greatMatchedCandidates)) {
            $ratedCandidates = $this->getRatedCandidates();

            foreach ($this->getCandidatesData() as $data) {
                $id = $data['employee'];

                if (!array_key_exists($id, $ratedCandidates)) {
                    continue;
                }

                if ('like' !== $ratedCandidates[$id]) {
                    continue;
                }

                $this->greatMatchedCandidates[] = $data;
            }

            usort($this->greatMatchedCandidates, [$this, 'sortCandidatesDataByDate']);
        }

        return $this->greatMatchedCandidates;
    }

    /**
     * @return array
     */
    public function getInterestedCandidatesData(): array
    {
        if (empty($this->interestedCandidates)) {
            $ratedCandidates = $this->getRatedCandidates();

            foreach ($this->getCandidatesData() as $data) {
                $id = $data['employee'];

                if (!array_key_exists($id, $ratedCandidates)) {
                    continue;
                }

                if ('normal' !== $ratedCandidates[$id]) {
                    continue;
                }

                $this->interestedCandidates[] = $data;
            }

            usort($this->interestedCandidates, [$this, 'sortCandidatesDataByDate']);
        }

        return $this->interestedCandidates;
    }

    /**
     * @return array
     */
    public function getUnratedCandidatesData(): array
    {
        if (empty($this->unratedCandidates)) {
            foreach ($this->getCandidatesData() as $data) {
                if (array_key_exists($data['employee'], $this->getRatedCandidates())) {
                    continue;
                }

                $this->unratedCandidates[] = $data;
            }

            usort($this->unratedCandidates, [$this, 'sortCandidatesDataByDate']);
        }

        return $this->unratedCandidates;
    }

    public function getNewCandidatesData(): array
    {
        if (empty($this->newCandidates)) {
            $date = new \DateTime(date('F j, Y'));
            $date->modify('-1 month');

            foreach ($this->getCandidatesData() as $data) {
                if (strtotime($data['date']) < $date->getTimestamp()) {
                    continue;
                }

                $this->newCandidates[] = $data;
            }

            usort($this->newCandidates, [$this, 'sortCandidatesDataByDate']);
        }

        return $this->newCandidates;
    }

    /**
     * @return array
     */
    public function getViewedCandidates(): array
    {
        if (empty($this->viewedCandidates)) {
            $candidates = get_user_meta($this->getUserId(), 'viewed_candidates', true);
            $this->viewedCandidates = !empty($candidates) ? $candidates : [];
            krsort($this->viewedCandidates, SORT_NUMERIC);
        }

        return $this->viewedCandidates;
    }

    private function sortCandidatesDataByDate(array $firstElem, array $secondElem): int
    {
        $date1st = strtotime($firstElem['date']);
        $date2nd = strtotime($secondElem['date']);

        if ($date1st === $date2nd) {
            return 0;
        }

        return $date1st > $date2nd ? -1 : 1;
    }
}

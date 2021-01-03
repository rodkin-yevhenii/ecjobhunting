<?php

namespace EcJobHunting\Entity;

use WP_Query;

class Company extends UserAbstract
{
    private bool $isActivated = false;
    private float $credits = 0;
    private array $vacancies = [];
    private array $candidates = [];
    private int $jobPosted = 0;
    private int $jobVisitors = 0;
    private int $candidatesReceived;

    public function __construct($user)
    {
        parent::__construct($user);
        $this->isActivated = get_field('is_activated', 'user_' . $this->getUserId()) ?? false;
        $this->credits = get_field('avaible_credits', 'user_' . $this->getUserId()) ?? 0;
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
            $this->vacancies = get_posts(
                [
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'post_type' => 'vacancy',
                ]
            );
        }
        return $this->vacancies;
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
}
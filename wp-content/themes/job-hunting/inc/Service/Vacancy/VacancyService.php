<?php

namespace EcJobHunting\Service\Vacancy;

/**
 * Class VacancyService
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Vacancy
 */
class VacancyService
{
    /**
     * Get currency symbol by currency name.
     *
     * @param string $currencyName
     *
     * @return string
     */
    public static function getCurrencySymbol(string $currencyName): string
    {
        $fields = get_field('post_new_job', 'option');
        $currencies = $fields['currency'] ?? [];

        foreach ($currencies as $currency) {
            $name = $currency['name'] ?? null;

            if (strtolower($name) === strtolower($currencyName)) {
                return $currency['symbol'];
            }
        }

        return '';
    }
}

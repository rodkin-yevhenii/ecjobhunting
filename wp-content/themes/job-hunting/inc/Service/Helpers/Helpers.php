<?php

namespace EcJobHunting\Service\Helpers;

/**
 * Class Helpers
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Helpers
 */
class Helpers
{
    /**
     * Get all categories of vacancy/cv.
     *
     * @return array
     */
    public static function getCategories(): array
    {
        $terms = get_terms(
            [
                'taxonomy' => 'job-category',
                'hide_empty' => false,
                'fields' => 'id=>name'
            ]
        );

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        return $terms;
    }

    /**
     * Determines whether the current visitor is a logged-in user.
     *
     * @return bool
     */
    public static function isUserLoggedIn(): bool
    {
        if (!function_exists('is_user_logged_in')) {
            $user = wp_get_current_user();

            return !empty($user->ID);
        }

        return is_user_logged_in();
    }
}

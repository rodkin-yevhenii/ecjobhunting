<?php

namespace EcJobHunting\Service\Cron;

class Cron
{
    public static function unScheduleEvent(string $hook, array $args): void
    {
        if (!wp_next_scheduled($hook, $args)) {
            return;
        }

        $timestamp = wp_next_scheduled($hook, $args);
        wp_unschedule_event($timestamp, $hook, $args);
    }

    public static function scheduleSingleEvent(int $additionalTime, string $hook, array $args = []): void
    {
        wp_schedule_single_event(time() + $additionalTime, $hook, $args);
    }
}

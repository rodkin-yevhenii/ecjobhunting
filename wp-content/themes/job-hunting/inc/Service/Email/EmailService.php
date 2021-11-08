<?php

namespace EcJobHunting\Service\Email;

use EcJobHunting\Entity\Email;

class EmailService
{
    public function __invoke()
    {
//        $this->registerAcfFields();
        $this->registerOptionsPage();
        add_filter('comment_moderation_recipients', [$this, 'disableCommentsNotification'], 11);
        add_filter('comment_notification_recipients', [$this, 'disableCommentsNotification'], 11);
    }

    private function registerOptionsPage(): void
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(
                [
                    'page_title' => __('Email marketing settings'),
                    'menu_title' => __('Emails Settings'),
                    'menu_slug' => 'emails-settings',
                    'capability' => 'edit_posts',
                    'parent_slug' => 'site-settings',
                ]
            );
        }
    }

    public static function sendEmail(Email $email): bool
    {
        return wp_mail(
            $email->getToEmail(),
            $email->getSubject(),
            $email->getMessage(),
            $email->getHeaders()
        );
    }

    public function disableCommentsNotification(array $emails): array
    {
        return [];
    }
}

<?php

namespace EcJobHunting\Service\Chat;

use EcJobHunting\Entity\Email;
use EcJobHunting\Service\Email\EmailMessages;
use EcJobHunting\Service\Email\EmailService;

class CronJobs
{
    public function __construct()
    {
        add_action('new_message_email_notification', [$this, 'sendEmailNotification'], 10, 2);
    }

    public function sendEmailNotification(int $userId, int $chatId): void
    {
        $a = 2;
        $messagesTemplates = new EmailMessages();
        $email = new Email();
        $email->setToEmail('test@test.ru')
            ->setMessage('test')
            ->setSubject('test');

        EmailService::sendEmail($email);
    }
}

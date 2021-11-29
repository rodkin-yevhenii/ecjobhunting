<?php

namespace EcJobHunting\Service\Chat;

use EcJobHunting\Entity\Chat;
use EcJobHunting\Entity\Email;
use EcJobHunting\Service\Email\EmailMessages;
use EcJobHunting\Service\Email\EmailService;
use EcJobHunting\Service\User\UserService;

class CronJobs
{
    public function __construct()
    {
        add_action('new_message_email_notification', [$this, 'sendEmailNotification'], 10, 2);
    }

    public function sendEmailNotification(int $recipientId, int $chatId): void
    {
        $emailMessages = new EmailMessages();
        $email = new Email();
        $chat = new Chat($chatId);
        $vacancy = $chat->getVacancy();

        if (UserService::isEmployer($recipientId)) {
            $candidateId = $chat->getAuthorId() !== $recipientId
                ? $chat->getAuthorId()
                : $chat->getOpponentId();
            $candidate = UserService::getUser($candidateId);
            $employer = UserService::getUser($recipientId);
            $email->setToEmail($employer->getEmail())
                ->setSubject("You have a new message from {$candidate->getName()} about your recent job listing")
                ->setMessage($emailMessages->getNewChatMessageForEmployer($candidate, $vacancy));
        } else {
            $employerId = $chat->getAuthorId() !== $recipientId
                ? $chat->getAuthorId()
                : $chat->getOpponentId();
            $employer = UserService::getUser($employerId);
            $candidate = UserService::getUser($recipientId);
            $email->setToEmail($candidate->getEmail())
                ->setSubject("You have a new message from {$employer->getName()} about your recent application.")
                ->setMessage($emailMessages->getNewChatMessageForEmployee($employer));
        }

        EmailService::sendEmail($email);
    }
}

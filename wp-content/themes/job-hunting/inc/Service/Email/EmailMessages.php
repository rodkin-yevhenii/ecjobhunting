<?php

namespace EcJobHunting\Service\Email;

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;

class EmailMessages
{
    private static $fields;
    private string $applyMessage = '';
    private string $newChatMessageForEmployer = '';
    private string $newChatMessageForEmployee = '';

    public function __construct()
    {
        if (empty(self::$fields)) {
            self::$fields = get_fields('email_templates', 'option') ?? [];
        }
    }

    public function getApplyMessage(Company $employer, Candidate $employee, Vacancy $vacancy): string
    {
        if (empty($this->applyMessage)) {
            ob_start();
            ?>
Congratulations, {{{EMPLOYER}}}!<br />
Your application "{{{VACANCY}}}" was accepted by {{{EMPLOYEE}}}<br />
Please login to your account for more information <a href="{{{LOGIN_URL}}}">{{{LOGIN_URL}}}</a><br />
<br />
Sincerely yours,<br />
EC Jobhunting.<br />
            <?php
            $template = !empty(self::$fields['apply_message'])
                ? self::$fields['apply_message']
                : ob_get_clean();

            $this->applyMessage = str_replace(
                [
                    '{{{EMPLOYER}}}',
                    '{{{EMPLOYEE}}}',
                    '{{{VACANCY}}}',
                    '{{{LOGIN_URL}}}',
                ],
                [
                    $employer->getName(),
                    $employee->getName(),
                    $vacancy->getTitle(),
                    wp_login_url(),
                ],
                $template
            );
        }

        return $this->applyMessage;
    }

    public function getNewChatMessageForEmployer(Candidate $employee, Vacancy $vacancy): string
    {
        if (empty($this->newChatMessageForEmployer)) {
            ob_start();
            ?>
            <strong>Candidate additional info</strong>
            <ul>
                <?php if (!empty($employee->getHeadline())) : ?>
                    <li>Headline: <?php echo $employee->getHeadline(); ?></li>
                <?php endif; ?>
                <?php if (!empty($employee->getHeadline())) : ?>
                    <li>Category: <?php echo $employee->getCategory(); ?></li>
                <?php endif; ?>
                <?php if (!empty($employee->getLocation())) : ?>
                    <li>Location: <?php echo $employee->getLocation(); ?></li>
                <?php endif; ?>
            </ul>
            <?php
            $additionalInfo = ob_get_clean();
            ob_start();
            ?>
You have a new message from {{{EMPLOYEE}}} about your recent job listing {{{VACANCY}}} on our website.<br />
{{{ADDITIONAL_INFORMATION}}}<br />
Please login to your account for more information <a href="{{{LOGIN_URL}}}">{{{LOGIN_URL}}}</a><br />
<br />
Sincerely yours,<br />
EC Jobhunting.
            <?php
            $template = !empty(self::$fields['new_chat_message_for_employer'])
                ? self::$fields['new_chat_message_for_employer']
                : ob_get_clean();

            $this->newChatMessageForEmployer = str_replace(
                [
                    '{{{EMPLOYEE}}}',
                    '{{{VACANCY}}}',
                    '{{{LOGIN_URL}}}',
                    '{{{ADDITIONAL_INFORMATION}}}',
                ],
                [
                    $employee->getName(),
                    $vacancy->getTitle(),
                    wp_login_url(),
                    $additionalInfo,
                ],
                $template
            );
        }

        return $this->newChatMessageForEmployer;
    }

    public function getNewChatMessageForEmployee(Company $employer): string
    {
        if (empty($this->newChatMessageForEmployee)) {
            ob_start();
            ?>
You have a new message from {{{EMPLOYER}}} about your recent application.<br />
<br />
Please login to your account for more information <a href="{{{LOGIN_URL}}}">{{{LOGIN_URL}}}</a><br />
<br />
Sincerely yours,<br />
EC Jobhunting.
            <?php
            $template = !empty(self::$fields['new_chat_message_for_employer'])
                ? self::$fields['new_chat_message_for_employee']
                : ob_get_clean();

            $this->newChatMessageForEmployee = str_replace(
                [
                    '{{{EMPLOYER}}}',
                    '{{{LOGIN_URL}}}',
                ],
                [
                    $employer->getName(),
                    wp_login_url(),
                ],
                $template
            );
        }

        return $this->newChatMessageForEmployee;
    }
}

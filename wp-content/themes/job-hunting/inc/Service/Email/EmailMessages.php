<?php

namespace EcJobHunting\Service\Email;

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Company;
use EcJobHunting\Entity\Vacancy;

class EmailMessages
{
    private static $fields;
    private string $applyMessage = '';

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
            $template = !empty(self::$fields['email_templates'])
                ? self::$fields['email_templates']
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
}

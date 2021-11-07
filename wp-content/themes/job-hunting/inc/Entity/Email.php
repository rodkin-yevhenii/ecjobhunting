<?php

namespace EcJobHunting\Entity;

/**
 * Class Email
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Email
 */
class Email
{
    private string $fromName = '';
    private string $fromEmail = '';
    private string $toEmail = '';
    private array $cc = [];
    private string $subject = '';
    private string $message = '';

    /**
     * @param string $fromName
     * @return Email
     */
    public function setFromName(string $fromName): Email
    {
        $this->fromName = $fromName;
        return $this;
    }

    /**
     * @param string $fromEmail
     * @return Email
     */
    public function setFromEmail(string $fromEmail): Email
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    /**
     * @param string $toEmail
     * @return Email
     */
    public function setToEmail(string $toEmail): Email
    {
        $this->toEmail = $toEmail;
        return $this;
    }

    /**
     * @param string $subject
     * @return Email
     */
    public function setSubject(string $subject): Email
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param string $message
     * @return Email
     */
    public function setMessage(string $message): Email
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $cc
     * @return Email
     */
    public function addCc(string $cc): Email
    {
        if (is_email($cc)) {
            return $this;
        }

        $this->cc[] = $cc;
        return $this;
    }

    /**
     * @return string
     */
    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getHeaders(): array
    {
        if (empty($this->fromName)) {
            $this->fromName = get_field('from_user_name', 'option') ?? '';
        }

        if (empty($this->fromEmail)) {
            $this->fromEmail = get_field('from_email', 'option') ?? '';
        }

        $headers = [
            "From: $this->fromName <$this->fromEmail>",
            'content-type: text/html',
        ];

        if (!empty($this->cc) && is_array($this->cc)) {
            foreach ($this->cc as $cc) {
                $headers[] = "cc: $cc";
            }
        }

        return $headers;
    }
}

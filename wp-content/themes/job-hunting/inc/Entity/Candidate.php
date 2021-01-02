<?php

namespace EcJobHunting\Entity;

use EcJobHunting\Service\Payment\PaymentService;

class Candidate extends UserAbstract
{
    private ?int $cvId;
    private ?array $fields;
    private string $headline;
    private string $location;
    private string $zipCode;
    private bool $relocate = false;
    private string $phoneNumber;
    private string $email;
    private string $webSite;
    private string $twitter;
    private string $linkedin;
    private string $facebook;

    public function __construct($user)
    {
        parent::__construct($user);
        $cvs = get_posts(
            [
                'post_type' => 'cv',
                'posts_per_page' => 1,
                'fields' => 'ids',
                'post_author' => $this->getUserId(),
            ]
        );
        if (!$cvs) {
            $this->cvId = wp_insert_post(
                [
                    'post_type' => 'cv',
                    'post_title' => $this->getName(),
                    'post_author' => $this->getUserId(),
                ]
            );
        } else {
            $this->cvId = $cvs[0];
        }
        $this->fields = get_fields($this->cvId);
    }
}
<?php

namespace EcJobHunting\Front;

class SiteSettings
{
    private ?string $logoUrl;
    private ?string $contactUsUrl;
    private static array $jobSettings;

    public function __construct()
    {
        $logo = get_field('logo', 'option');
        $this->logoUrl = empty($logo) ? IMG_URI . 'logo-2X.jpg' : wp_get_attachment_image_url($logo);
        $contactUsArr = get_field('contact_us_url', 'option');

        if (is_array($contactUsArr)) {
            $this->contactUsUrl = $contactUsArr['url'] ?? '';
        } else {
            $this->contactUsUrl = $contactUsArr;
        }
    }

    /**
     * @return mixed|string|null
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    public static function getJobSettings()
    {
        if (empty(self::$jobSettings)) {
            $fields = get_field('post_new_job', 'option');
            self::$jobSettings = empty($fields) ? [] : $fields;
        }
        return self::$jobSettings;
    }

    public function getContactUsUrl()
    {
        return $this->contactUsUrl;
    }
}

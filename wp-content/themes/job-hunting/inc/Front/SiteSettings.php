<?php

namespace EcJobHunting\Front;

final class SiteSettings
{
    private ?string $logoUrl;

    public function __construct()
    {
        $logo = get_field('logo', 'option');
        $this->logoUrl = empty($logo) ? IMG_URI . 'logo-2x.jpg' : wp_get_attachment_image_url($logo);
    }

    /**
     * @return mixed|string|null
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }
}
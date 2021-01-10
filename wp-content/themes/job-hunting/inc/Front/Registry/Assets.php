<?php


namespace EcJobHunting\Front\Registry;


class Assets
{
    private string $handle = 'ec-job-hunt';
    private string $baseSrc;

    public function __invoke()
    {
        $this->baseSrc = get_stylesheet_directory_uri() . '/assets/public/';
        $this->styles();
        $this->scripts();
        $this->localizeScripts();
    }

    private function styles()
    {
        wp_enqueue_style($this->handle, $this->baseSrc . 'css/styles.min.css', [], '1.0', 'all');
    }

    private function scripts()
    {
        wp_enqueue_script('libs', $this->baseSrc . 'js/index/libs.js', [], '1.0', true);
        wp_enqueue_script($this->handle, $this->baseSrc . 'js/index/scripts.js', ['libs'], '1.0', true);
    }

    private function localizeScripts()
    {
        wp_localize_script(
            $this->handle,
            'siteSettings',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
            ]
        );
    }
}
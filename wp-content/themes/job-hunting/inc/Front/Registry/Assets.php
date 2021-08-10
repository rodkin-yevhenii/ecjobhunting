<?php

namespace EcJobHunting\Front\Registry;

/**
 * Class Assets
 *
 * @package EcJobHunting\Front\Registry
 */
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
        wp_enqueue_script($this->handle, $this->baseSrc . 'js/index/general.js', ['libs'], '1.0', true);
        wp_enqueue_script('theme-ajax', $this->baseSrc . 'js/index/ajax.js', [$this->handle], '1.0', true);

        if (is_user_logged_in()) {
            wp_enqueue_script('api', $this->baseSrc . 'js/index/api.js', [], '1.0', true);
        }

        if (current_user_can('candidate') && is_page('dashboard')) {
            wp_enqueue_script('dashboard-candidate', $this->baseSrc . 'js/index/cv.js', [$this->handle], '1.0', true);
        }

        if (current_user_can('employer')) {
            wp_enqueue_script('vacancies', $this->baseSrc . 'js/index/vacancies.js', [$this->handle], '1.0', true);
        }
    }

    private function localizeScripts()
    {
        if (is_user_logged_in()) {
            $credentials = get_userdata(get_current_user_id());
            $basic = base64_encode("{$credentials->user_login}:{$credentials->user_pass}");
        } else {
            $basic = '';
        }

        wp_localize_script(
            $this->handle,
            'siteSettings',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                '_basic' => $basic,
                'nonce' => wp_create_nonce('ecjob_nonce')
            ]
        );

        wp_localize_script(
            'vacancies',
            'REST_API_data',
            ['nonce' => wp_create_nonce('wp_rest')]
        );
    }
}

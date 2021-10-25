<?php

namespace EcJobHunting;

use EcJobHunting\Admin\AdminInit;
use EcJobHunting\Admin\Registry\ThemeSettings;
use EcJobHunting\Admin\Registry\UserRoles;
use EcJobHunting\Front\FrontInit;
use EcJobHunting\Service\Ajax\Ajax;
use EcJobHunting\Service\Chat\ChatService;
use EcJobHunting\Service\Cv\CvService;
use EcJobHunting\Service\Job\JobService;
use EcJobHunting\Service\Payments\PaymentService;
use EcJobHunting\Service\User\ChangePassword;
use EcJobHunting\Service\User\Login;
use EcJobHunting\Service\User\Registration;
use EcJobHunting\Service\User\RetrievePassword;
use EcJobHunting\Service\Widget\WidgetInit;
use EcJobHunting\Service\User\UserService;

final class ThemeInit
{
    private static $instance;

    private function __construct()
    {
        $this->registerAdminHooks();
        $this->registerFrontHooks();
        $this->registerWidgets();
        $this->afterThemeSetup();
        $this->registerUserRoles();
        $this->registerUserServices();
        $this->registerAjaxCallbacks();
        $this->registerChatServices();
        $this->registerPayments();
        add_action('rest_api_init', [$this, 'registerRestApiField']);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    private function registerAdminHooks()
    {
        ThemeSettings::init();
        AdminInit::init();
//        add_action('init', [AdminInit::class, 'init']);
//        add_action('acf/init', ['EcJobHunting\Admin\Registry\ThemeSettings', 'init']);
    }

    private function registerFrontHooks()
    {
        add_action('init', new FrontInit());
        add_action('init', new JobService());
        add_action('init', new Login());
        add_action('init', new Registration());
        add_action('init', new RetrievePassword());
        add_action('init', new ChangePassword());
        add_action('init', new CvService());
    }

    private function registerWidgets()
    {
        add_action('widgets_init', new WidgetInit());
    }

    private function afterThemeSetup()
    {
        add_action('after_setup_theme', ['EcJobHunting\Admin\Registry\ThemeSettings', 'afterThemeSetup']);
    }

    private function registerUserRoles()
    {
        add_action('after_switch_theme', new UserRoles());
        add_action('after_switch_theme', [$this, 'createBasicPages']);
        add_action('after_switch_theme', [$this, 'createDemoUsers']);
    }

    private function registerUserServices()
    {
        add_action('init', new UserService());
    }

    private function registerChatServices()
    {
        add_action('init', new ChatService());
    }

    private function registerPayments(): void
    {
        new PaymentService();
    }

    private function registerAjaxCallbacks(): void
    {
        new Ajax();
    }

    public function createBasicPages()
    {
        $pages = [
            'signup',
            'dashboard',
            'profile',
            'login',
            'post-job',
            'my-jobs',
            'messages',
            'activation',
            'my-candidates',
            'post-job',
        ];

        foreach ($pages as $slug) {
            $page = get_page_by_path($slug);
            if (!$page) {
                $pageId = wp_insert_post(
                    wp_slash(
                        [
                            'post_title' => ucfirst($slug),
                            'post_type' => 'page',
                            'post_status' => 'publish',
                        ]
                    )
                );
                if (!$pageId) {
                    add_action(
                        'admin_notices',
                        function () {
                            $message = "Can't create basic page. Please set page templates for pages: 'signup',
                            'candidate', 'employer'";
                            echo '<div class="notice notice-error is-dismissible"> <p>' . $message . '</p></div>';
                        }
                    );
                } else {
                    update_post_meta($pageId, '_wp_page_template', "page-{$slug}.php");
                }
            }
        }
    }

    public function createDemoUsers()
    {
        if (!username_exists('candidate')) {
            wp_insert_user(
                [
                    'user_login' => 'candidate',
                    'user_pass' => 'candidate',
                    'user_email' => 'candidate@demo.com',
                    'role' => 'candidate',
                ]
            );
        }
        if (!username_exists('employer')) {
            wp_insert_user(
                [
                    'user_login' => 'employer',
                    'user_pass' => 'employer',
                    'user_email' => 'employer@demo.com',
                    'role' => 'employer',
                ]
            );
        }
    }

    public function registerRestApiField()
    {
        register_rest_field(
            'vacancy',
            'meta',
            [
                'get_callback' => [$this, 'retrievePostMeta'],
                'schema' => null,
            ]
        );
        register_rest_field(
            'vacancy',
            'title',
            [
                'get_callback' => [$this, 'retrievePostTitle'],
                'schema' => null,
            ]
        );
        register_rest_field(
            'vacancy',
            'location',
            [
                'get_callback' => [$this, 'retrieveJobLocation'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'company',
            [
                'get_callback' => [$this, 'retrieveJobCompany'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'skills',
            [
                'get_callback' => [$this, 'retrieveJobSkills'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'jobCategory',
            [
                'get_callback' => [$this, 'retrieveJobCategory'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'isCommissionIncluded',
            [
                'get_callback' => [$this, 'retrieveCommissionStatus'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'isInformEmployer',
            [
                'get_callback' => [$this, 'retrieveInformEmployerStatus'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'additionalEmailsToInform',
            [
                'get_callback' => [$this, 'retrieveAdditionalEmailsList'],
                'schema' => null,
            ]
        );

        register_rest_field(
            'vacancy',
            'employmentType',
            [
                'get_callback' => [$this, 'retrieveJobEmploymentType'],
                'schema' => null,
            ]
        );
    }

    public function retrievePostMeta($object)
    {
        //get the id of the post object array
        $post_id = $object['id'];
        $meta = get_post_meta($post_id);
        $meta['benefits'] = unserialize($meta['benefits'][0]);
        $meta['additional_options'] = unserialize($meta['additional_options'][0]);
        //return the post meta
        return $meta;
    }

    public function retrievePostTitle($object)
    {
        return get_the_title($object['id']);
    }

    public function retrieveJobLocation($object)
    {
        return wp_get_post_terms($object['id'], 'location', ['fields' => 'names']);
    }

    public function retrieveJobCompany($object)
    {
        return wp_get_post_terms($object['id'], 'company', ['fields' => 'names']);
    }

    public function retrieveJobSkills($object)
    {
        return wp_get_post_terms($object['id'], 'skill', ['fields' => 'names']);
    }

    public function retrieveJobCategory($object)
    {
        return wp_get_post_terms($object['id'], 'job-category', ['fields' => 'names']);
    }

    public function retrieveJobEmploymentType($object)
    {
        return wp_get_post_terms($object['id'], 'type', ['fields' => 'names']);
    }

    public function retrieveCommissionStatus($object)
    {
        return get_field('is_commission_included', $object['id']);
    }

    public function retrieveInformEmployerStatus($object)
    {
        return get_field('emails_to_inform', $object['id']);
    }

    public function retrieveAdditionalEmailsList($object)
    {
        return get_field('additional_employer_emails', $object['id']);
    }
}

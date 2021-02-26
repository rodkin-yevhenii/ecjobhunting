<?php


namespace EcJobHunting\Service\User;


use EcJobHunting\Front\EcResponse;
use EcJobHunting\Interfaces\AjaxResponse;

class Registration
{
    private AjaxResponse $response;

    public function __construct()
    {
        $this->response = new EcResponse();
    }

    public function __invoke()
    {
        if (wp_doing_ajax()) {
            add_action('wp_ajax_register_user', [$this, 'createNewUser']);
            add_action('wp_ajax_nopriv_register_user', [$this, 'createNewUser']);
        }
    }


    public function createNewUser()
    {
//        $this->response->setResponseBody('Test');
//        $this->response->send();
        echo 'test';
        wp_die();
    }

}
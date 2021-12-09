<?php

namespace EcJobHunting\Service\Ajax;

use EcJobHunting\Front\EcResponse;

/**
 * Class AjaxCallbackAbstract
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax
 */
abstract class AjaxCallbackAbstract
{
    protected EcResponse $response;
    protected array $actions = [];

    /**
     * AjaxCallbackAbstract constructor.
     */
    public function __construct()
    {
        $this->response = new EcResponse();

        foreach ($this->actions as $action => $callback) {
            add_action("wp_ajax_$action", [$this, $callback]);
            add_action("wp_ajax_nopriv_$action", [$this, $callback]);
        }
    }
}

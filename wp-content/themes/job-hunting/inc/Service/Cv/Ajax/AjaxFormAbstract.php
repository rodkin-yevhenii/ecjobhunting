<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Front\EcResponse;

/**
 * Class AjaxFormAbstract
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
abstract class AjaxFormAbstract
{
    protected EcResponse $response;
    /**
     * AjaxFormAboutMe constructor.
     */
    public function __construct()
    {
        $this->response = new EcResponse();
        $this->registerHooks();
    }

    /**
     * Register ajax hooks
     */
    abstract protected function registerHooks(): void;

    /**
     * Save Cv data to database.
     */
    abstract public function saveCallback(): void;

    /**
     * Cv data from database.
     */
    abstract public function getCallback(): void;
}

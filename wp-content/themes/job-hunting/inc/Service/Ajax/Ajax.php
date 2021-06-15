<?php

namespace EcJobHunting\Service\Ajax;

use EcJobHunting\Front\EcResponse;
use EcJobHunting\Service\Ajax\Callbacks\Autocomplete;

/**
 * Class Ajax
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Ajax
 */
class Ajax
{
    private EcResponse $response;

    public function __construct()
    {
        new Autocomplete();
    }
}

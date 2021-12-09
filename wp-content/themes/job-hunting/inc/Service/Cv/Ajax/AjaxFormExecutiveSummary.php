<?php

namespace EcJobHunting\Service\Cv\Ajax;

use EcJobHunting\Service\User\UserService;

/**
 * Class AjaxFormExecutiveSummary
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv\Ajax
 */
class AjaxFormExecutiveSummary extends AjaxHiddenFormAbstract
{
    protected string $formId = 'executive-summary';
    protected string $fieldName = 'executive_summary';
}

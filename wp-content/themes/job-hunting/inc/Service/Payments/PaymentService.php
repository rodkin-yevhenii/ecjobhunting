<?php

namespace EcJobHunting\Service\Payments;

/**
 * Class PaymentService
 *
 * @package EcJobHunting\Service\Payments;
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 */
class PaymentService
{
    public function __construct()
    {
        $this->registerSubscriptionsSettings();
        $this->registerPayPalSettings();
    }

    /**
     * Register settings fields for subscriptions plans.
     */
    private function registerSubscriptionsSettings(): void
    {
        new SubscriptionsPlans();
    }

    /**
     * Register settings fields for subscriptions plans.
     */
    private function registerPayPalSettings(): void
    {
        new PayPalService();
    }
}

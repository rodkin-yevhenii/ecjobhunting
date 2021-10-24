<?php

/**
 * Template Name: Activation
 */

use EcJobHunting\Service\Payments\SubscriptionsPlans;
use EcJobHunting\Service\User\UserService;

if (! UserService::isEmployer()) {
    wp_redirect(home_url());
}

$employer = UserService::getUser();
$subscriptionsPlans = SubscriptionsPlans::getSubscriptionsPlans();

if (empty($subscriptionsPlans) || !is_array($subscriptionsPlans)) {
    return;
}

get_header();
?>
<div class="page employer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?php echo $employer->getName(); ?>, we're so glad to see you!</h1>
                <p>Just click 'Subscribe' to get full access to your account.</p>
                <?php foreach ($subscriptionsPlans as $plan) : ?>
                    <div
                        class="ys-card js-subscription-card"
                        data-subscriptionId="<?php echo $plan['id']; ?>"
                        data-nonce="<?php echo wp_create_nonce('activate_subscription_trial'); ?>"
                    >
                        <h3 class="text-large m-0 p-0 d-md-inline">
                            <?php echo $plan['title']; ?>:
                        </h3>
                        <span class="text-large color-primary ml-md-3">
                            $<?php echo $plan['price']; ?>.00/month
                        </span>
                        <p class="mb-xl-0"><?php echo $plan['description']; ?></p>
                        <?php if (!$employer->isActivated()) :
                            echo do_shortcode('[subscription_btn subscription_id="' . $plan['id'] . '"]');
                        endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();

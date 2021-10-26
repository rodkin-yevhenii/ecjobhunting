<?php

/**
 * Template Name: Profile
 */

use EcJobHunting\Service\User\UserService;

$user = wp_get_current_user();

get_header(); ?>
    <section class="account mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <h2 class="no-decor mb-4">Change Password</h2>
                    <p>
                        You are currently updating preferences for <strong><?php echo $user->user_email; ?></strong>
                    </p>
                    <form
                        id="profile-change-password"
                        data-nonce="<?php echo wp_create_nonce('change-user-password'); ?>"
                    >
                        <label class="field-label" for="account-password-current">Current Password</label>
                        <input class="field-text js-current-pwd" type="password" id="account-password-current">
                        <p class="color-secondary">
                            Forgot password? <a href="/forgot-password/">Click here</a>
                            and we'll email you a link to reset your password.
                        </p>
                        <label class="field-label" for="account-password-new">Create Password</label>
                        <input class="field-text js-new-pwd" type="password" id="account-password-new">
                        <label class="field-label" for="account-password-new-confirm">Confirm Password</label>
                        <input class="field-text js-confirmation-pwd" type="password" id="account-password-new-confirm">
                        <button class="btn btn-primary" type="submit">Save Password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();

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
if (UserService::isCandidate()) : ?>
    <section class="account">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="no-decor mb-4">Notifications</h2>
                    <form>
                        <h3>Job Recommendations</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-1">
                            <label for="notifications-1">Email digest of jobs based on your job search activity.</label>
                        </fieldset>
                        <fieldset>
                            <input type="checkbox" id="notifications-2">
                            <label for="notifications-2">Instant notifications when you match to a job, powered by our
                                smart matching technology.</label>
                        </fieldset>
                        <h3>Application Status Updates</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-3">
                            <label for="notifications-3">Updates to your job applications, including when it is
                                received, viewed, rated, or closed by the employer, and other updates related to your
                                job search.</label>
                        </fieldset>
                        <h3>Profile Activity</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-4">
                            <label for="notifications-4">Receive information about which companies are viewing your
                                profile, updates on your saved and viewed jobs, suggestions for improving your profile,
                                and more.</label>
                        </fieldset>
                        <h3>Messages from Employers</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-5">
                            <label for="notifications-5">Notifications when an employer contacts you about your job
                                application.</label>
                        </fieldset>
                        <h3>Communications from EcJobHunting</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-6">
                            <label for="notifications-6">Product tips and guidance to help you get the most out of
                                EcJobHunting including job search advice, feedback requests, and product
                                updates.</label>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="account">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="no-decor mb-4">My Job Alerts</h2>
                    <p>Look in your inbox for jobs matching these searches. We do the searching for you!</p>
                    <div class="custom-handler">
                        <div></div>
                        <span>Receive job alert emails matching my criteria specified below</span>
                    </div>
                    <form class="disabled">
                        <h3>Job Title Matching</h3>
                        <fieldset>
                            <input type="checkbox" id="notifications-7" disabled>
                            <label for="notifications-7">My resume and activity</label>
                        </fieldset>
                        <fieldset>
                            <input type="checkbox" id="notifications-8" disabled>
                            <label for="notifications-8">Specific keywords</label>
                        </fieldset>
                        <h3>Location Matching</h3>
                        <fieldset>
                            <input type="radio" id="notifications-9" name="notifications-radio" checked disabled>
                            <label for="notifications-9">My activity</label>
                        </fieldset>
                        <fieldset>
                            <input type="radio" id="notifications-10" name="notifications-radio" disabled>
                            <label for="notifications-10">Specified location</label>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
endif;
get_footer();

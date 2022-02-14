<?php

/***
 * Template Name: Registration
 */

use EcJobHunting\Service\User\Registration;

$errors = [];
$registrationService = new Registration();

if ($registrationService->isDoingRegistration()) {
    $registrationService->setUserData();

    if ($registrationService->isUserDataValid()) {
        try {
            $registrationService->registerNewUser();
        } catch (Exception $ex) {
            $errors[] = $ex->getMessage();
        }
    } else {
        $errors = $registrationService->getErrors();
    }
}
$tab = $_GET['user'] ?? 'candidate';

get_header(); ?>
    <div class="results page">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header results-header-large">
                    <li class="d-md-none" data-tab-value>
                        <span>
                            <?php _e(
                                'Sign Up as Candidate',
                                'ecjobhunting'
                            ); ?>
                        </span>
                    </li>
                    <li <?php echo $tab === 'candidate' ? 'class="active"' : ''; ?> data-tab-item="candidate">
                        <?php _e(
                            'Sign Up as Candidate',
                            'ecjobhunting'
                        ); ?>
                    </li>
                    <li <?php echo $tab === 'employer' ? 'class="active"' : ''; ?> data-tab-item="employer">
                        <?php _e(
                            'Sign Up as Employer',
                            'ecjobhunting'
                        ); ?>
                    </li>
                </ul>
                <div class="results-content">
                    <?php
                    foreach ($errors as $error) : ?>
                        <div class="col-12 mb-2 py-2 text-center alert-danger results-content__message">
                            <?php echo $error; ?>
                        </div>
                        <?php
                    endforeach;
                    ?>
                    <div data-tab-content="candidate" <?php echo $tab === 'candidate' ? 'class="active"' : ''; ?>>
                        <form
                            action="<?php echo add_query_arg(['user' => 'candidate'], site_url('signup')); ?>"
                            name="sign-up-candidate"
                            class="registerform"
                            id="register-candidate-form"
                            method="post"
                            autocomplete="off"
                        >
                            <label class="field-label" for="email">
                                <?php _e('Email', 'ecjobhunting'); ?>
                                <input
                                    class="field-text"
                                    type="email"
                                    name="email"
                                    value="<?php echo $registrationService->getEmail() ?? ''; ?>"
                                    required
                                />
                            </label>
                            <label class="field-label" for="username">
                                <?php _e('Username', 'ecjobhunting'); ?>
                                <input
                                    class="field-text"
                                    type="text"
                                    name="username"
                                    value="<?php echo $registrationService->getUsername() ?? ''; ?>"
                                    required
                                />
                            </label>
                            <label class="field-label" for="candidate_pwd">Password
                                <input
                                    class="field-text password candidate_pwd"
                                    type="password"
                                    name="candidate_pwd"
                                    required
                                />
                            </label>
                            <label class="field-label" for="candidate_pwd_confirmation">Confirm Password
                                <input
                                    class="field-text candidate_pwd_confirmation"
                                    type="password"
                                    name="candidate_pwd_confirmation"
                                    required>
                            </label>
                            <p class="description"><?php echo wp_get_password_hint(); ?></p>
                            <?php
                            echo apply_filters('gglcptch_display_recaptcha', '', 'ecj_register_candidate_form');
                            ?>
                            <input type="submit" name="wp-submit"
                                   class="btn btn-primary" value="<?php _e('Sign Up', 'ecjobhunting'); ?>">
                            <input type="hidden" name="role" value="candidate"/>
                            <?php wp_nonce_field('sign_up', 'nonce'); ?>
                        </form>
                    </div>
                    <div data-tab-content="employer" <?php echo $tab === 'employer' ? 'class="active"' : ''; ?>>
                        <form
                            action="<?php echo add_query_arg(['user' => 'employer'], site_url('signup')); ?>"
                            class="registerform"
                            id="register-employer-form"
                            method="post"
                            autocomplete="off"
                        >
                            <label class="field-label" for="email">
                                <?php _e('Email', 'ecjobhunting'); ?>
                                <input
                                    class="field-text"
                                    type="email"
                                    name="email"
                                    value="<?php echo $registrationService->getEmail() ?? ''; ?>"
                                    required
                                />
                            </label>
                            <label class="field-label" for="username">
                                <?php _e('Username', 'ecjobhunting'); ?>
                                <input
                                    class="field-text"
                                    type="text"
                                    name="username"
                                    value="<?php echo $registrationService->getUsername() ?? ''; ?>"
                                    required
                                />
                            </label>
                            <label class="field-label" for="employer_pwd">Password
                                <input
                                    class="field-text employer_pwd"
                                    type="password"
                                    name="employer_pwd"
                                    required
                                />
                            </label>
                            <label class="field-label pwd_confirmation" for="employer_pwd_confirmation">Confirm Password
                                <input
                                    class="field-text employer_pwd_confirmation"
                                    type="password"
                                    name="employer_pwd_confirmation"
                                    required
                                />
                            </label>
                            <p class="description"><?php echo wp_get_password_hint(); ?></p>
                            <?php
                            echo apply_filters('gglcptch_display_recaptcha', '', 'ecj_register_employer_form');
                            ?>
                            <input type="submit" name="wp-submit"
                                   class="btn btn-primary" value="<?php _e('Sign Up', 'ecjobhunting'); ?>">
                            <input type="hidden" name="role" value="employer"/>
                            <?php wp_nonce_field('sign_up', 'nonce'); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();

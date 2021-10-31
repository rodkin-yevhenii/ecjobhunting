<?php

/**
 * Template Name: Profile
 */

use EcJobHunting\Service\User\UserService;

$user = wp_get_current_user();

if (!empty($_FILES['avatar'])) {
    do_action('ecjob-save-new-data', $user->ID);
}

if (!empty($_POST['firstname'])) {
    update_user_meta($user->ID, 'first_name', $_POST['firstname']);
}

if (!empty($_POST['lastname'])) {
    update_user_meta($user->ID, 'last_name', $_POST['lastname']);
}

if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
    wp_update_user(['ID' => $user->ID, 'display_name' => $_POST['firstname'] . ' ' . $_POST['lastname']]);
} elseif (!empty($_POST['firstname'])) {
    wp_update_user(['ID' => $user->ID, 'display_name' => $_POST['firstname']]);
} elseif (!empty($_POST['lastname'])) {
    wp_update_user(['ID' => $user->ID, 'display_name' => $_POST['lastname']]);
}

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
                    <input class="field-text js-new-pwp" type="password" id="account-password-new">
                    <label class="field-label" for="account-password-new-confirm">Confirm Password</label>
                    <input class="field-text js-confirmation-pwd" type="password" id="account-password-new-confirm">
                    <button class="btn btn-primary" type="submit">Save Password</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
if (UserService::isEmployer()) : ?>
    <section class="account section-avatar mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <h2 class="no-decor mb-4">Change avatar</h2>
                    <form method="post" id="profile-change-name" enctype="multipart/form-data">
                        <p class="color-secondary">
                            Use jpg or png format. File size shouldn't be more then 1 mb.
                        </p>
                        <input
                            class="field-text"
                            name="avatar"
                            type="file"
                            accept=".jpg,.jpeg,.png"
                            id="account-avatar"
                        >
                        <?php wp_nonce_field('upload_avatar', 'upload_avatar_nonce'); ?>
                        <button class="btn btn-primary" type="submit">Upload Avatar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="account mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <h2 class="no-decor mb-4">Change Name</h2>
                    <form method="post" id="profile-change-name">
                        <label class="field-label" for="account-firstname">Firstname</label>
                        <input
                            class="field-text"
                            name="firstname"
                            type="text"
                            id="account-firstname"
                            value="<?php echo $user->first_name; ?>"
                        >
                        <label class="field-label" for="account-surname">Surname</label>
                        <input
                            class="field-text"
                            name="lastname"
                            type="text"
                            id="account-surname"
                            value="<?php echo $user->last_name; ?>"
                        >
                        <button class="btn btn-primary" type="submit">Save Name</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
endif;

get_footer();

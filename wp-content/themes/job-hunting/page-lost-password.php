<?php
/**
 * Template Name: Lost password
 * Template Post Type: page
 */

use EcJobHunting\Service\User\RetrievePassword;

$errors = [];
if (isset($_REQUEST['errors'])) {
    $errorCodes = explode(',', $_REQUEST['errors']);

    foreach ($errorCodes as $code) {
        $errors[] = RetrievePassword::getErrorMessage($code);
    }
}

get_header(); ?>
    <section class="account mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <h1 class="no-decor mb-4"><?php the_title(); ?></h1>
                    <p><?php the_content(); ?></p>
                    <?php foreach ($errors as $error) : ?>
                        <p class="alert-danger text-center p-2">
                            <?php echo $error; ?>
                        </p>
                    <?php endforeach; ?>
                    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
                        <label class="field-label" for="user_login">
                            <?php _e('Email Address', 'ecjobhunting'); ?>
                        </label>
                        <input class="field-text" type="email" name="user_login" id="user_login">
                        <br />
                        <input type="submit" name="wp-submit" id="wp-submit"
                               class="btn btn-primary" value="<?php _e('Reset Password', 'ecjobhunting'); ?>">
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();

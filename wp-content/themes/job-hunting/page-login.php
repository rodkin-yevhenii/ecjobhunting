<?php
/**
 * Template Name: Login
 */
get_header(); ?>
    <section class="account mt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-xl-6">
                    <?php if ($_REQUEST['checkemail'] ?? '' === 'confirm') : ?>
                        <h1 class="no-decor mb-4"><?php _e('Success!', 'ecjobhunting'); ?></h1>
                        <p>
                            <?php _e("Check your email for a link to reset your password.", 'ecjobhunting'); ?>
                        </p>
                    <?php else: ?>
                        <h1 class="no-decor mb-4"><?php _e('Login', 'ecjobhunting'); ?></h1>
                        <p><?php _e("Don't have an account?", 'ecjobhunting'); ?> (<a
                                    href="<?php echo SIGNUP_URL; ?>"><?php _e("Sign Up", 'ecjobhunting'); ?></a>)</p>
                        <form action="<?php echo site_url('wp-login.php'); ?>" name="loginform" method="post">
                            <label class="field-label" for="user_login"><?php _e(
                                    'Username or Email Address',
                                    'ecjobhunting'
                                ); ?></label>
                            <input class="field-text" type="text" name="log" id="user_login">
                            <label class="field-label" for="pwd">Password</label>
                            <input class="field-text" type="password" name="pwd" id="user_pass">
                            <br/>
                            <fieldset><input name="rememberme" type="checkbox" id="rememberme" value="forever">
                                <label for="rememberme"> Remember Me</label></fieldset>
                            <input type="submit" name="wp-submit" id="wp-submit"
                                   class="btn btn-primary" value="<?php _e('Log in', 'ecjobhunting'); ?>">
                            <input type="hidden" name="redirect_to" value="<?php echo site_url(); ?>"/>
                        </form>
                        <p class="color-secondary"><a
                                href="<?php echo wp_lostpassword_url(); ?>"><?php _e(
                                    'Forgot Password?',
                                    'ecjobhunting'
                                ); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer();

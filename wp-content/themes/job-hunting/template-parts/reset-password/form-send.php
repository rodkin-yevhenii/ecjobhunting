<?php
$errors = $args['errors'] ?? [];
?>
<h1 class="no-decor mb-4"><?php _e('Forgot your password?', 'ecjobhunting'); ?></h1>
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

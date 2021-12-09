<?php
$errors = $args['errors'] ?? [];
?>
<h1 class="no-decor mb-4"><?php _e('Pick a New Password', 'ecjobhunting'); ?></h1>
<p><?php the_content(); ?></p>
<?php foreach ($errors as $error) : ?>
    <p class="alert-danger text-center p-2">
        <?php echo $error; ?>
    </p>
<?php endforeach; ?>
<form name="resetpassform"
      id="resetpassform"
      action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>"
      method="post"
      autocomplete="off"
>
    <input type="hidden" name="key" value="<?php echo $_REQUEST['key']; ?>">
    <input type="hidden" name="login" value="<?php echo $_REQUEST['login']; ?>">
    <label class="field-label" for="pwd">
        <?php _e('Password', 'ecjobhunting'); ?>
    </label>
    <input class="field-text" type="password" name="pwd" id="pwd">
    <label class="field-label" for="pwd_confirmation">
        <?php _e('Password Confirmation', 'ecjobhunting'); ?>
    </label>
    <input class="field-text" type="password" name="pwd_confirmation" id="pwd_confirmation">
    <p class="description"><?php echo wp_get_password_hint(); ?></p>
    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="<?php
        _e('Reset Password', 'ecjobhunting'); ?>">
</form>

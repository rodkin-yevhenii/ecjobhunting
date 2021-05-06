<?php
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <button
        class="profile-edit-link js-profile-edit-link"
        type="button"
        data-toggle="modal"
        data-target="#edit"
        data-heading="<?php _e('About Me', 'ecjobhunting'); ?>"
        data-form-id="about_me"
    >
        <?php _e('Edit', 'ecjobhunting'); ?>
    </button>
    <h2 class="no-decor"><?php _e('About Me', 'ecjobhunting'); ?></h2>
</div>
<form class="profile-photo" action="" method="post" id="avatar-form" enctype="multipart/form-data">
    <div class="profile-photo-image">
        <img src="<?php echo $candidate->getPhoto(); ?>" alt="photo">
    </div>
    <input type="file" name="avatar" id="profile-photo" accept=".jpg,.jpeg,.png" value=" ">
    <?php wp_nonce_field('upload_avatar', 'upload_avatar_nonce'); ?>
    <label for="profile-photo">+</label>
</form>
<div class="profile-name">
    <strong id="cv_full_name"><?php echo $candidate->getName() ?></strong>
    <span id="cv_headline"><?php echo $candidate->getHeadline() ?></span>
    <span class="d-flex justify-content-center">
        <span id="cv_location" class="mr-2"><?php echo $candidate->getLocation() ?></span>
        <span id="cv_zip"><?php echo $candidate->getZipCode() ?></span>
    </span>
    <span
        id="ready_to_relocate"
        class="<?php echo $candidate->isReadyToRelocate() ? '' : 'd-none"'; ?>"
    >
        <?php _e('I am willing to relocate', 'ecjobhunting'); ?>
    </span>
</div>

<?php

/**
 * @var \EcJobHunting\Entity\Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <?php if ($isOwner) : ?>
        <button
            class="profile-edit-link js-edit-about-me"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
    <h2 class="no-decor"><?php _e('About Me', 'ecjobhunting'); ?></h2>
</div>
<form class="profile-photo" action="" method="post" id="avatar-form" enctype="multipart/form-data">
    <div class="profile-photo-image">
        <img src="<?php echo $candidate->getPhoto(); ?>" alt="photo">
    </div>
    <?php if ($isOwner) : ?>
        <input type="file" name="avatar" id="profile-photo" accept=".jpg,.jpeg,.png" value=" ">
        <?php wp_nonce_field('upload_avatar', 'upload_avatar_nonce'); ?>
        <label for="profile-photo">+</label>
    <?php endif; ?>
</form>
<div class="profile-name">
    <?php if (!empty($candidate->getName())) : ?>
        <strong id="cv_full_name"><?php echo $candidate->getName() ?></strong>
    <?php endif;

    if (!empty($candidate->getHeadline())) : ?>
        <span id="cv_headline"><?php echo $candidate->getHeadline() ?></span>
    <?php endif;

    if (!empty($candidate->getLocation()) || !empty($candidate->getZipCode())) : ?>
        <span class="d-flex justify-content-center">
            <?php if (!empty($candidate->getLocation())) : ?>
                <span id="cv_location" class="mr-2"><?php echo $candidate->getLocation() ?></span>
            <?php endif;

            if (!empty($candidate->getZipCode())) : ?>
                <span id="cv_zip"><?php echo $candidate->getZipCode() ?></span>
            <?php endif; ?>
        </span>
    <?php endif;

    if (!empty($candidate->isReadyToRelocate())) : ?>
        <span id="ready_to_relocate">
            <?php _e('I am willing to relocate', 'ecjobhunting'); ?>
        </span>
    <?php endif; ?>
</div>

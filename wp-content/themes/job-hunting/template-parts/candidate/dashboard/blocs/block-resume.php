<?php

use EcJobHunting\Entity\Candidate;

/**
 * @var Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}

$file = $candidate->getResumeFile();
?>
<div class="profile-header resume">
    <h2 class="no-decor"><?php _e('Resume', 'ecjobhunting'); ?></h2>
    <?php if ($isOwner && empty($file)) : ?>
        <p>
            <a
                href="#"
                class="js-edit-resume"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Add resume', 'ecjobhunting'); ?>
            </a>
        </p>
    <?php endif;

    if (!empty($file)) : ?>
        <div class="d-flex justify-content-start align-items-center mb-4">
            <img
                class="m-0 mr-3"
                src="<?php echo $file['icon']; ?>"
                alt="<?php echo $file['name']; ?>"
                width="24"
                height="24"
            />
            <a href="<?php echo $file['url']; ?>" target="_blank">
                <?php echo $file['filename']; ?>
            </a>
        </div>
        <?php
    endif;

    if ($isOwner && !empty($file)) : ?>
        <button
            class="btn btn-outline-secondary js-edit-resume"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Replace', 'ecjobhunting'); ?>
        </button>
        <button
            class="btn btn-outline-secondary js-remove-resume"
            type="button"
        >
            <?php _e('Delete', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>


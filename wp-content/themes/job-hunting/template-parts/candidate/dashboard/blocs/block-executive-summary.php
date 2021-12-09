<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Executive summary', 'ecjobhunting'); ?></h2>
    <?php if (! empty($candidate->getSummary())) : ?>
        <p><?php echo nl2br($candidate->getSummary()); ?></p>
    <?php else : ?>
        <p>
            <a
                href="#"
                class="js-edit-executive-summary"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Add Executive summary', 'ecjobhunting'); ?>
            </a>
        </p>
    <?php endif;

    if ($isOwner && ! empty($candidate->getSummary())) : ?>
        <button
            class="btn btn-outline-secondary js-edit-executive-summary"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>

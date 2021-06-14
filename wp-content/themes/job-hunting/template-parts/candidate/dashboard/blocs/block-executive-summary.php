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
    <p><?php echo nl2br($candidate->getSummary()); ?></p>
    <?php if ($isOwner) : ?>
        <button
            class="btn btn-outline-secondary js-edit-executive-summary"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
        <button
            class="btn btn-outline-secondary js-remove-executive-summary"
            type="button"
        >
            <?php _e('Delete', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>

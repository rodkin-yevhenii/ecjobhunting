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
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Objective', 'ecjobhunting'); ?></h2>
    <p><?php echo nl2br($candidate->getObjective()); ?></p>
    <?php if ($isOwner) : ?>
        <button
            class="btn btn-outline-secondary js-edit-objective"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
        <button
            class="btn btn-outline-secondary js-remove-objective"
            type="button"
        >
            <?php _e('Delete', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>


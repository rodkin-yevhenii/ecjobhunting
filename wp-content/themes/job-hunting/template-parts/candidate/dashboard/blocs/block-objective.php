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
    <?php if (! empty($candidate->getObjective())) : ?>
        <p><?php echo nl2br($candidate->getObjective()); ?></p>
    <?php else : ?>
        <p>
            <a
                href="#"
                class="js-edit-objective"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Add Objective', 'ecjobhunting'); ?>
            </a>
        </p>
    <?php endif;

    if ($isOwner && ! empty($candidate->getObjective())) : ?>
        <button
            class="btn btn-outline-secondary js-edit-objective"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>


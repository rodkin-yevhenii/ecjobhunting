<?php
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}

if (!empty($candidate->getSummary())) : ?>
    <div class="profile-header">
        <h2 class="no-decor"><?php _e('Executive Summary', 'ecjobhunting'); ?></h2>
        <p><?php echo nl2br($candidate->getSummary()); ?></p>
        <?php if ($isOwner) : ?>
            <button
                class="btn btn-outline-secondary js-edit-summary"
                type="button"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Edit', 'ecjobhunting'); ?>
            </button>
        <?php endif; ?>

    </div>
<?php elseif ($isOwner) : ?>
    <div class="profile-header">
        <p>
            <a href="#" class="js-edit-summary" data-toggle="modal" data-target="#edit">
                <?php _e('Add Executive Summary', 'ecjobhunting'); ?>
            </a>
        </p>
    </div>
<?php endif; ?>

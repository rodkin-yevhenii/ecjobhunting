<?php

use EcJobHunting\Entity\Candidate;

/**
 * @var Candidate $candidate
 */

$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;
$counter = 0;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Achievements', 'ecjobhunting'); ?></h2>
</div>
<?php if ($isOwner) : ?>
    <p>
        <a
            href="#"
            class="js-add-achievements-subitem"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Add Achievements', 'ecjobhunting'); ?>
        </a>
    </p>
<?php endif; ?>
<?php if (!empty($candidate->getAchievements())) :
    foreach ($candidate->getAchievements() as $achievements) : ?>
        <p><?php echo nl2br($achievements['text']); ?></p>
        <?php if ($isOwner) : ?>
            <button
                class="btn btn-outline-secondary js-edit-achievements-subitem"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-row-number="<?php echo $counter; ?>"
            >
                <?php _e('Edit', 'ecjobhunting'); ?>
            </button>
            <button
                class="btn btn-outline-secondary js-delete-achievements-subitem"
                type="button"
                data-row-number="<?php echo $counter++; ?>"
            >
                <?php _e('Delete', 'ecjobhunting'); ?>
            </button>
        <?php endif; ?>
    <?php endforeach;
endif;

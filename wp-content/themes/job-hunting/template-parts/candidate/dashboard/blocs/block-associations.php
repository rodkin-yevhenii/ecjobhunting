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
        <h2 class="no-decor"><?php _e('Associations', 'ecjobhunting'); ?></h2>
    </div>
<?php if ($isOwner) : ?>
    <p>
        <a
            href="#"
            class="js-add-associations-subitem"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Add Associations', 'ecjobhunting'); ?>
        </a>
    </p>
<?php endif; ?>
<?php if (!empty($candidate->getAssociations())) :
    foreach ($candidate->getAssociations() as $association) : ?>
        <p><?php echo nl2br($association['text']); ?></p>
        <?php if ($isOwner) : ?>
            <button
                class="btn btn-outline-secondary js-edit-associations-subitem"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-row-number="<?php echo $counter; ?>"
            >
                <?php _e('Edit', 'ecjobhunting'); ?>
            </button>
            <button
                class="btn btn-outline-secondary js-delete-associations-subitem"
                type="button"
                data-row-number="<?php echo $counter++; ?>"
            >
                <?php _e('Delete', 'ecjobhunting'); ?>
            </button>
        <?php endif; ?>
    <?php endforeach;
endif;

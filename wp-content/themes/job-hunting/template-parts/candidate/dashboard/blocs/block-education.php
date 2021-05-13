<?php
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;
$counter = 0;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Education', 'ecjobhunting'); ?></h2>
</div>
<?php if ($isOwner) : ?>
    <p>
        <a
            href="#"
            class="js-profile-edit-btn"
            data-toggle="modal"
            data-target="#edit"
            data-action="load_add_subitem_form"
            data-form-id="education"
        >
            <?php _e('Add Education', 'ecjobhunting'); ?>
        </a>
    </p>
<?php endif; ?>
<?php if (!empty($candidate->getEducation())) :
    foreach ($candidate->getEducation() as $education) : ?>
        <div class="profile-subitem"><span><?php echo getDatePeriod($education['period']); ?></span>
            <h3><?php echo $education['name']; ?></h3>
            <?php echo $education['degree'] ? "<strong>{$education['degree']}</strong>" : ""; ?>
            <?php echo $education['fields_of_study']
                ? "<strong>{$education['fields_of_study']}</strong>" : ""; ?>
            <?php if ($isOwner) : ?>
                <div class="profile-subitem__buttons">
                    <button
                        class="btn btn-outline-secondary js-profile-edit-btn"
                        type="button"
                        data-toggle="modal"
                        data-target="#edit"
                        data-action="load_edit_subitem_form"
                        data-form-id="education"
                        data-row-number="<?php echo $counter; ?>"
                    >
                        <?php _e('Edit', 'ecjobhunting'); ?>
                    </button>
                    <button
                        class="btn btn-outline-secondary js-profile-delete-subitem-btn"
                        type="button"
                        data-action="delete_profile_subitem"
                        data-block-id="education"
                        data-row-number="<?php echo $counter++; ?>"
                    >
                        <?php _e('Delete', 'ecjobhunting'); ?>
                    </button>
                </div>
            <?php endif; ?>
            <?php echo $education['description'] ? "<p>{$education['description']}</p>" : ""; ?>
        </div>
    <?php endforeach;
endif; ?>


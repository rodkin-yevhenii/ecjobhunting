<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="about-me">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('About Me', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <label class="field-label" for="name">
            <?php _e('Full Name', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="name" value="<?php echo $candidate->getName(); ?>">

        <label class="field-label" for="headline">
            <?php _e('Headline (optional)', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="headline" value="<?php echo $candidate->getHeadline(); ?>">

        <label class="field-label" for="location">
            <?php _e('Location', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="location" value="<?php echo $candidate->getLocation(); ?>">

        <label class="field-label" for="zip">
            <?php _e('ZIP / Postal Code', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="zip" value="<?php echo $candidate->getZipCode(); ?>">

        <fieldset>
            <input type="checkbox" id="edit_ready_to_relocate" <?php echo $candidate->isReadyToRelocate()
                ? 'checked' : ''; ?>>
            <label for="edit_ready_to_relocate">
                <?php _e('I am willing to relocate', 'ecjobhunting'); ?>
            </label>
        </fieldset>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

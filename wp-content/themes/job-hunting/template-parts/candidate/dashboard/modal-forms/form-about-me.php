<form class="modal-content" id="about_me" style="display: none">
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-header'); ?>
    <div class="modal-body">
        <label class="field-label" for="edit-name"><?php _e('Full Name', 'ecjobhunting'); ?></label>
        <input class="field-text" type="text" id="edit-full-name">
        <label class="field-label" for="edit-headline"><?php _e('Headline (optional)', 'ecjobhunting'); ?></label>
        <input class="field-text" type="text" id="edit-headline">
        <label class="field-label" for="edit-location"><?php _e('Location', 'ecjobhunting'); ?></label>
        <input class="field-text" type="text" id="edit-location">
        <label class="field-label" for="edit-zip"><?php _e('ZIP / Postal Code', 'ecjobhunting'); ?></label>
        <input class="field-text" type="text" id="edit-zip">
        <fieldset>
            <input type="checkbox" id="edit-checkbox">
            <label for="edit-checkbox"><?php _e('I am willing to relocate', 'ecjobhunting'); ?></label>
        </fieldset>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

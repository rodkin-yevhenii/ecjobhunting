<form class="modal-content" id="contacts" style="display: none">
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-header'); ?>
    <div class="modal-body">
        <label class="field-label" for="edit_phone"><?php _e('Phone', 'ecjobhunting'); ?></label>
        <input class="field-text" type="text" id="edit_phone">
        <label class="field-label" for="edit_email"><?php _e('Public email', 'ecjobhunting'); ?></label>
        <input class="field-text" type="email" id="edit_email" required>
        <?php echo wp_nonce_field('update_contacts', 'update_contacts_nonce'); ?>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

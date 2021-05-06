<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="contacts">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Contact Information', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <label class="field-label" for="phone">
            <?php _e('Phone', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="phone" value="<?php echo $candidate->getPhoneNumber(); ?>">

        <label class="field-label" for="public_email">
            <?php _e('Public email', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="email" id="public_email" value="<?php echo $candidate->getEmail(); ?>" required>

        <?php echo wp_nonce_field('update_contacts', 'update_contacts_nonce'); ?>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

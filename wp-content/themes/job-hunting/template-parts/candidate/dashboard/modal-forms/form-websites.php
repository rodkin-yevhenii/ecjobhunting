<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="websites">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Websites', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <label class="field-label" for="website">
            <?php _e('Website', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="website" value="<?php echo $candidate->getWebSite(); ?>">

        <label class="field-label" for="twitter">
            <?php _e('Twitter', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="twitter" value="<?php echo $candidate->getTwitter(); ?>">

        <label class="field-label" for="linkedin">
            <?php _e('LinkedIn', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="linkedin" value="<?php echo $candidate->getLinkedin(); ?>">

        <label class="field-label" for="facebook">
            <?php _e('Facebook', 'ecjobhunting'); ?>
        </label>
        <input class="field-text" type="text" id="facebook" value="<?php echo $candidate->getFacebook(); ?>">

        <?php echo wp_nonce_field('update_profile', 'update_profile_nonce'); ?>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

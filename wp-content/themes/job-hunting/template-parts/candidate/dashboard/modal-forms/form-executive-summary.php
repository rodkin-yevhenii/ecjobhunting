<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="executive-summary">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Executive Summary', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <textarea id="objective-text" class="field-textarea"><?php echo $candidate->getSummary(); ?></textarea>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

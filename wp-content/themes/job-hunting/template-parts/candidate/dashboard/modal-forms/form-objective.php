<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="objective">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Objective', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <textarea id="text" class="field-textarea"><?php echo $candidate->getObjective(); ?></textarea>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

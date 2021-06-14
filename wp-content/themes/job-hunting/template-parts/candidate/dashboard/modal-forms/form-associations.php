<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}

$action = $args['action'] ?? 'add';
$order = $args['row'] ?? 0;

if ('edit' === $action) {
    $heading = __('Edit Associations', 'ecjobhunting');
    $associations = $candidate->getAssociations();
    $association = $associations[$order]['text'] ?? '';
} else {
    $heading = __('Add Associations', 'ecjobhunting');
    $association = '';
}

?>
<form class="modal-content" id="associations">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Associations', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <textarea id="associations-text" class="field-textarea"><?php echo $association; ?></textarea>
    </div>
    <input type="hidden" id="row_number" value="<?php echo ++$order; ?>">
    <input type="hidden" id="do_action" value="<?php echo $action; ?>">
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

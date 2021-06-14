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
    $heading = __('Edit Achievements', 'ecjobhunting');
    $achievements = $candidate->getAchievements();
    $achievement = $achievements[$order]['text'] ?? '';
} else {
    $heading = __('Add Achievements', 'ecjobhunting');
    $achievement = '';
}

?>
<form class="modal-content" id="achievements">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Achievements', 'ecjobhunting')]
    ); ?>
    <div class="modal-body">
        <textarea id="achievements-text" class="field-textarea"><?php echo $achievement; ?></textarea>
    </div>
    <input type="hidden" id="row_number" value="<?php echo ++$order; ?>">
    <input type="hidden" id="do_action" value="<?php echo $action; ?>">
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;
$action = $args['action'] ?? 'add';
$workOrder = $args['row'] ?? 0;

if ('edit' === $action) {
    $heading = __('Edit Work Experience', 'ecjobhunting');
    $works = $candidate->getExperience();
    $work = $works[$workOrder];
    $isInProgress =  $work['period']['is_in_progress'];
    $to = !empty($work['period']['to'])
        ? date('d.m.Y', strtotime($work['period']['to'])) : '';
} else {
    $heading = __('Add Work Experience', 'ecjobhunting');
    $work = [];
    $isInProgress = false;
    $to = '';
}
?>
<form class="modal-content" id="work-experience">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => $heading]
    ); ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <label class="field-label" for="from">
                    <?php _e('From', 'ecjobhunting'); ?>
                </label>
                <input
                    class="field-text"
                    type="text"
                    id="from"
                    placeholder="01.01.2021"
                    value="<?php echo !empty($work['period']['from'])
                        ? date('d.m.Y', strtotime($work['period']['from'])) : ''; ?>"
                />
            </div>
            <div class="col-12 col-sm-6">
                <label class="field-label" for="to">
                    <?php _e('To', 'ecjobhunting'); ?>
                </label>
                <input
                    class="field-text"
                    type="text"
                    id="to"
                    placeholder="01.01.2021"
                    value="<?php echo $isInProgress ? 'Current' : $to; ?>"
                    <?php echo $isInProgress ? 'disabled' : ''; ?>
                />
            </div>
        </div>

        <input
            type="checkbox"
            id="is_in_progress"
            class="js-is-in-progress"
            <?php echo $work['period']['is_in_progress'] ? 'checked' : ''; ?>
        >
        <label class="field-label" for="is_in_progress">
            <?php _e('Currently in progress', 'ecjobhunting'); ?>
        </label>

        <label class="field-label" for="position">
            <?php _e('Position', 'ecjobhunting'); ?>
        </label>
        <input
            class="field-text"
            type="text"
            id="position"
            value="<?php echo $work['job_position'] ?? ''; ?>"
            required
        />

        <label class="field-label" for="company">
            <?php _e('Company', 'ecjobhunting'); ?>
        </label>
        <input
            class="field-text"
            type="text"
            id="company"
            value="<?php echo $work['company_name'] ?? ''; ?>"
            required
        />

        <label class="field-label" for="description">
            <?php _e('Description', 'ecjobhunting'); ?>
        </label>
        <textarea
            class="field-textarea"
            id="description"
        ><?php echo $work['description'] ?? ''; ?></textarea>

        <input type="hidden" id="row_number" value="<?php echo ++$workOrder; ?>">
        <input type="hidden" id="do_action" value="<?php echo $action; ?>">

        <?php echo wp_nonce_field('update_contacts', 'update_contacts_nonce'); ?>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

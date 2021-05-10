<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;
$action = $args['action'] ?? 'add';
$workOrder = $args['work-order'] ?? 0;

if ('edit' === $action) {
    $heading = __('Edit Work Experience', 'ecjobhunting');
    $works = $candidate->getExperience();
    $work = $works[$workOrder];
} else {
    $heading = __('Add Work Experience', 'ecjobhunting');
    $work = [];
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
                    value="<?php echo !empty($work['period']['to'])
                        ? date('d.m.Y', strtotime($work['period']['from'])) : ''; ?>"
                    required
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
                    value="<?php echo !empty($work['period']['to'])
                        ? date('d.m.Y', strtotime($work['period']['to'])) : ''; ?>"
                    required
                />
            </div>
        </div>

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

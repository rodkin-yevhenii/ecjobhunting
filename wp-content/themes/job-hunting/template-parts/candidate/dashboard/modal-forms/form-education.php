<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;
$action = $args['action'] ?? 'add';
$rowNumber = $args['row-number'] ?? 0;

if ('edit' === $action) {
    $heading = __('Edit education', 'ecjobhunting');
    $educations = $candidate->getEducation();
    $education = $educations[$rowNumber];
    $isInProgress =  $education['period']['is_in_progress'];
    $to = !empty($education['period']['to'])
        ? date('d.m.Y', strtotime($education['period']['to'])) : '';
} else {
    $heading = __('Add Education', 'ecjobhunting');
    $education = [];
    $isInProgress = false;
    $to = '';
}
?>
<form class="modal-content" id="education">
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
                    value="<?php echo !empty($education['period']['from'])
                        ? date('d.m.Y', strtotime($education['period']['from'])) : ''; ?>"
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
                    value="<?php echo $isInProgress ? 'Current' : $to; ?>"
                    <?php echo $isInProgress ? 'disabled' : ''; ?>
                />
            </div>
        </div>

        <input
            type="checkbox"
            id="is_in_progress"
            class="js-is-in-progress"
            <?php echo $education['period']['is_in_progress'] ? 'checked' : ''; ?>
        >
        <label class="field-label" for="is_in_progress">
            <?php _e('Currently in progress', 'ecjobhunting'); ?>
        </label>

        <label class="field-label" for="school">
            <?php _e('School', 'ecjobhunting'); ?>
        </label>
        <input
            class="field-text"
            type="text"
            id="school"
            value="<?php echo $education['name'] ?? ''; ?>"
            required
        />

        <label class="field-label" for="degree">
            <?php _e('Degree', 'ecjobhunting'); ?>
        </label>
        <input
            class="field-text"
            type="text"
            id="degree"
            value="<?php echo $education['degree'] ?? ''; ?>"
            required
        />

        <label class="field-label" for="fields_of_study">
            <?php _e('Major or field of study (optional)', 'ecjobhunting'); ?>
        </label>
        <input
            class="field-text"
            type="text"
            id="fields_of_study"
            value="<?php echo $education['fields_of_study'] ?? ''; ?>"
        />

        <label class="field-label" for="description">
            <?php _e('Description', 'ecjobhunting'); ?>
        </label>
        <textarea
            class="field-textarea"
            id="description"
        ><?php echo $education['description'] ?? ''; ?></textarea>

        <input type="hidden" id="row_number" value="<?php echo ++$rowNumber; ?>">
        <input type="hidden" id="do_action" value="<?php echo $action; ?>">

        <?php echo wp_nonce_field('update_contacts', 'update_contacts_nonce'); ?>
    </div>
    <?php get_template_part('template-parts/candidate/dashboard/modal-forms/form-footer'); ?>
</form>

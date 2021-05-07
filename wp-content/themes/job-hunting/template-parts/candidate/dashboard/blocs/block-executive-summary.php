<?php
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Executive Summary', 'ecjobhunting'); ?></h2>
    <p><?php echo nl2br($candidate->getSummary()); ?></p>
    <button
        class="btn btn-outline-secondary js-profile-edit-btn"
        type="button"
        data-toggle="modal"
        data-target="#edit"
        data-action="load_executive_summary_form"
        data-form-id="executive-summary"
    >
        <?php _e('Edit', 'ecjobhunting'); ?>
    </button>
</div>

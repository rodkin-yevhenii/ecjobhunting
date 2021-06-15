<?php

/**
 * @var $candidate \EcJobHunting\Entity\Candidate
 */
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<form class="modal-content" id="resume" enctype="multipart/form-data">
    <?php get_template_part(
        'template-parts/candidate/dashboard/modal-forms/form-header',
        null,
        ['heading' => __('Resume', 'ecjobhunting')]
    ); ?>
    <div class="modal-body d-flex flex-column justify-content-center align-items-center">
        <span class="mb-4 text-center">
            Uploading a new resume will replace your existing profile. Are you sure you want to continue?
        </span>
        <input
            id="resume_file"
            class="d-none"
            type="file"
            name="ResumeUpload"
            accept="application/msword,application/pdf,application/rtf,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,text/rtf,.pdf,.doc,.docx,.odt,.txt,.rtf"
            tabindex="-1"
        >
        <label for="resume_file" class="text-center">
            <span class="btn btn-outline-secondary" role="button" tabindex="0">Yes, Upload</span>
        </label>

        <?php echo wp_nonce_field('update_contacts', 'update_contacts_nonce'); ?>
    </div>
</form>

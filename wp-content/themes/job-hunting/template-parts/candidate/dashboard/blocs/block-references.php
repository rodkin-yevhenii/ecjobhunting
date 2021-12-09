<?php

use EcJobHunting\Entity\Candidate;

/**
 * @var Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;
$counter = 0;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('References', 'ecjobhunting'); ?></h2>
</div>
<?php if ($isOwner) : ?>
    <form class="profile-documents-upload" enctype="multipart/form-data">
        <label>
            <input
                id="add_references"
                type="file"
                name="references"
                accept="application/msword,application/pdf,application/rtf,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,text/rtf,.pdf,.doc,.docx,.odt,.txt,.rtf"
                tabindex="-1"
            >
            <span><?php _e('Add References', 'ecjobhunting'); ?></span>
        </label>
    </form>
<?php endif; ?>
<p>Hiring managers prefer candidates with references! Ask a former co-worker, manager, teacher or
    friend to write a reference for you.</p>
<?php if (!empty($candidate->getReferences())) :
    foreach ($candidate->getReferences() as $reference) :
        $file = $reference['file'] ?? false;

        if (!empty($file)) : ?>
            <div class="profile-subitem d-flex justify-content-start align-items-center mb-4">
                <?php if ($isOwner) : ?>
                    <a
                        href="#"
                        class="btn btn-delete btn-delete--circle mr-3 js-delete-references-item"
                        data-row-number="<?php echo $counter++; ?>"
                    >
                        <i class="fa fa-close"></i>
                    </a>
                <?php endif; ?>
                <img
                    class="m-0 mr-3"
                    src="<?php echo $file['icon']; ?>"
                    alt="<?php echo $file['name']; ?>"
                    width="24"
                    height="24"
                />
                <a href="<?php echo $file['url']; ?>" target="_blank">
                    <?php echo $file['filename']; ?>
                </a>
            </div>
            <?php
        endif;
    endforeach;
endif; ?>


<?php
/**
 * @var \EcJobHunting\Entity\Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;
$counter = 0;

if (!$candidate) {
    return;
}
?>

<div class="profile-header">
    <h2 class="no-decor"><?php _e('Work Experience', 'ecjobhunting'); ?></h2>
    <?php if ($isOwner) : ?>
        <p>
            <a
                href="#"
                class="js-add-work-experience-subitem"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Add Work Experience', 'ecjobhunting'); ?>
            </a>
        </p>
    <?php endif; ?>
</div>
<?php if (!empty($candidate->getExperience())) :
    foreach ($candidate->getExperience() as $experience) : ?>
        <div class="profile-subitem">
            <span>
                <?php echo getDatePeriod(
                    $experience['period']
                ); ?>
            </span>
            <h3>
                <?php echo $experience['job_position']; ?>
            </h3>
            <strong>
                <?php echo $experience['company_name']; ?>
            </strong>
            <?php if ($isOwner) : ?>
                <div class="profile-subitem__buttons">
                    <button
                        class="btn btn-outline-secondary js-edit-work-experience-subitem"
                        type="button"
                        data-toggle="modal"
                        data-target="#edit"
                        data-row-number="<?php echo $counter; ?>"
                    >
                        <?php _e('Edit', 'ecjobhunting'); ?>
                    </button>
                    <button
                        class="btn btn-outline-secondary js-delete-work-experience-subitem"
                        type="button"
                        data-row-number="<?php echo $counter++; ?>"
                    >
                        <?php _e('Delete', 'ecjobhunting'); ?>
                    </button>
                </div>
            <?php endif; ?>
            <?php if (!empty($experience['description'])) : ?>
                <p>
                    <?php echo nl2br($experience['description']); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endforeach;
endif; ?>

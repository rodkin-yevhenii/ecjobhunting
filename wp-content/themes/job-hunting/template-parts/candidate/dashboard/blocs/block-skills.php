<?php

use EcJobHunting\Entity\Candidate;

/**
 * @var Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <h2 class="no-decor"><?php _e('Skills', 'ecjobhunting'); ?></h2>
    <?php if ($isOwner && empty($candidate->getSkills())) : ?>
        <p>
            <a
                href="#"
                class="js-edit-skills"
                data-toggle="modal"
                data-target="#edit"
            >
                <?php _e('Add skills', 'ecjobhunting'); ?>
            </a>
        </p>
    <?php endif; ?>
    <div class="candidate-skills">
        <ul class="candidate-skills__container">
            <?php foreach ($candidate->getSkills() as $id => $name) : ?>
                <li class="candidate-skills__item">
                    <?php echo $name; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if ($isOwner && !empty($candidate->getSkills())) : ?>
        <button
            class="btn btn-outline-secondary js-edit-skills"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
</div>


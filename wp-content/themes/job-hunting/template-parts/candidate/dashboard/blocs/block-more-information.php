<?php

/**
 * @var \EcJobHunting\Entity\Candidate $candidate
 */
$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}
?>
<h2 class="no-decor"><?php _e('More Information', 'ecjobhunting'); ?></h2>
<?php if ($isOwner && empty($candidate->getSalaryExpectation())) : ?>
    <p>
        <a
            href="#"
            class="js-edit-more-information"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            Add Desired Salary
        </a>
    </p>
<?php else : ?>
    <div class="d-flex flex-column mb-2">
        <small>Desired Salary:</small>
        <span class="ml-4"><?php echo $candidate->getSalaryExpectation() ?>$ / year</span>
    </div>
<?php endif;

if ($isOwner && empty($candidate->getYearsOfExperience())) : ?>
    <p>
        <a
            href="#"
            class="js-edit-more-information"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            Add Years of Experience
        </a>
    </p>
<?php else : ?>
    <div class="d-flex flex-column mb-2">
        <small>Years of Experience:</small>
        <span class="ml-4"><?php echo $candidate->getYearsOfExperience() ?></span>
    </div>
    <?php
endif;

if ($isOwner && empty($candidate->getHighestDegreeEarned())) : ?>
    <p>
        <a
            href="#"
            class="js-edit-more-information"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            Add Highest Degree Earned
        </a>
    </p>
<?php else : ?>
    <div class="d-flex flex-column mb-2">
        <small>Highest Degree Earned:</small>
        <span class="ml-4"><?php echo $candidate->getHighestDegreeEarned() ?></span>
    </div>
    <?php
endif;

if ($isOwner && empty($candidate->getCategory())) : ?>
    <p>
        <a
            href="#"
            class="js-edit-more-information"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            Add Industry
        </a>
    </p>
<?php else : ?>
    <div class="d-flex flex-column mb-2">
        <small>Industry:</small>
        <span class="ml-4"><?php echo $candidate->getCategory() ?></span>
    </div>
    <?php
endif;

if ($isOwner && empty($candidate->getVeteranStatus())) : ?>
    <p>
        <a
            href="#"
            class="js-edit-more-information"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            Add Veteran Status
        </a>
    </p>
<?php else : ?>
    <div class="d-flex flex-column mb-2">
        <small>Veteran Status:</small>
        <span class="ml-4"><?php echo $candidate->getVeteranStatus() ?></span>
    </div>
    <?php
endif;

if ($isOwner) :
    ?>
    <button
        class="btn btn-outline-secondary js-edit-more-information"
        type="button"
        data-toggle="modal"
        data-target="#edit"
    >
        <?php _e('Edit', 'ecjobhunting'); ?>
    </button>
    <?php
endif;

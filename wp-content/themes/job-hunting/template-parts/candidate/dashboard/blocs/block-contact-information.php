<?php

use EcJobHunting\Entity\Candidate;

/**
 * @var $candidate Candidate
 */

$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <?php if ($isOwner) : ?>
        <button
            class="profile-edit-link js-edit-contacts"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
    <h2 class="no-decor"><?php _e('Contact Information', 'ecjobhunting'); ?></h2>
</div>
<ul>
    <li>
        <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
        <?php
        if ($candidate->isEmailConfirmed()) :
            ?>
            <span><?php echo $candidate->getEmail(); ?></span>
            <?php
        else :
            ?>
            <span><?php echo $candidate->getNewEmail(); ?></span>
            <?php
            if ($isOwner) : ?>
                <span class="color-red js-verification-text">
                    <?php _e(
                        'Verify your email to receive application updates from employers.',
                        'ecjobhunting'
                    ); ?>
                </span>
                <button class="btn btn-primary js-resend-email-confirmation">
                    <?php _e('Resend Confirmation', 'ecjobhunting'); ?>
                </button>
                <?php
            endif;
        endif;
        ?>
    </li>
    <?php if ($isOwner || !empty($candidate->getPhoneNumber())) : ?>
        <li>
            <div class="profile-icon"><?php echo getPhoneIcon(); ?></div>
            <?php if ($candidate->getPhoneNumber()) : ?>
                <span><?php echo $candidate->getPhoneNumber(); ?></span>
            <?php else : ?>
                <a
                    href="#"
                    class="profile-edit-link js-edit-contacts"
                    type="button"
                    data-toggle="modal"
                    data-target="#edit"
                >
                    <?php _e('Add Phone Number', 'ecjobhunting'); ?>
                </a>
            <?php endif; ?>
        </li>
    <?php endif; ?>
</ul>

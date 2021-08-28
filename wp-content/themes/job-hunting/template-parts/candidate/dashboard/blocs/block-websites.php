<?php

/**
 * @var $candidate Candidate
 */

use EcJobHunting\Entity\Candidate;

$candidate = $args['candidate'] ?? null;
$isOwner = $args['isOwner'] ?? false;
//$isOwner = false;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <?php if ($isOwner) : ?>
        <button
            class="profile-edit-link js-edit-websites"
            type="button"
            data-toggle="modal"
            data-target="#edit"
        >
            <?php _e('Edit', 'ecjobhunting'); ?>
        </button>
    <?php endif; ?>
    <h2 class="no-decor"><?php _e('Websites', 'ecjobhunting'); ?></h2>
</div>
<ul>
    <?php if ($isOwner || !empty($candidate->getWebSite())) : ?>
        <li>
            <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
            <?php if ($candidate->getWebSite()) : ?>
                <a href="<?php echo $candidate->getWebSite(); ?>">
                    <?php echo $candidate->getWebSite(); ?>
                </a>
            <?php else : ?>
                <span><?php _e('none', 'ecjobhunting'); ?></span>
            <?php endif; ?>
        </li>
    <?php endif;

    if ($isOwner || !empty($candidate->getTwitter())) : ?>
        <li>
            <div class="profile-icon"><?php echo getTwitterIcon(); ?></div>
            <?php if ($candidate->getTwitter()) : ?>
                <a href="<?php echo $candidate->getTwitter(); ?>">
                    <?php echo $candidate->getTwitter(); ?>
                </a>
            <?php else : ?>
                <span><?php _e('none', 'ecjobhunting'); ?></span>
            <?php endif; ?>
        </li>
    <?php endif;

    if ($isOwner || !empty($candidate->getLinkedin())) : ?>
        <li>
            <div class="profile-icon"><?php echo getLinkedinIcon(); ?></div>
            <?php if ($candidate->getLinkedin()) : ?>
                <a href="<?php echo $candidate->getLinkedin(); ?>">
                    <?php echo $candidate->getLinkedin(); ?>
                </a>
            <?php else : ?>
                <span><?php _e('none', 'ecjobhunting'); ?></span>
            <?php endif; ?>
        </li>
    <?php endif;

    if ($isOwner || !empty($candidate->getFacebook())) : ?>
        <li>
            <div class="profile-icon"><?php echo getFacebookIcon(); ?></div>
            <?php if ($candidate->getFacebook()) : ?>
                <a href="<?php echo $candidate->getFacebook(); ?>">
                    <?php echo $candidate->getFacebook(); ?>
                </a>
            <?php else : ?>
                <span><?php _e('none', 'ecjobhunting'); ?></span>
            <?php endif; ?>
        </li>
    <?php endif;

    if (!$isOwner) : ?>
        <li>
            <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
            <a
                href="#"
                class="js-start-chat"
                data-user-id="<?php echo $candidate->getUserId(); ?>"
                data-nonce="<?php echo wp_create_nonce('create_chat'); ?>"
            >
                Start chat
            </a>
        </li>
    <?php endif; ?>
</ul>

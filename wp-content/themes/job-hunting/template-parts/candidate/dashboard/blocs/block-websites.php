<?php
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<div class="profile-header">
    <button
        class="profile-edit-link js-profile-edit-link"
        type="button"
        data-toggle="modal"
        data-target="#edit"
        data-action="load_websites_form"
        data-form-id="websites"
    >
        <?php _e('Edit', 'ecjobhunting'); ?>
    </button>
    <h2 class="no-decor"><?php _e('Websites', 'ecjobhunting'); ?></h2>
</div>
<ul>
    <li>
        <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
        <?php if ($candidate->getWebSite()) : ?>
            <span><?php echo $candidate->getWebSite(); ?></span>
        <?php else : ?>
            <a
                href="#"
                class="profile-edit-link js-profile-edit-link"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-action="load_websites_form"
                data-form-id="websites"
            >
                <?php _e('Add Website', 'ecjobhunting'); ?>
            </a>
        <?php endif; ?>
    </li>
    <li>
        <div class="profile-icon"><?php echo getTwitterIcon(); ?></div>
        <?php if ($candidate->getTwitter()) : ?>
            <span><?php echo $candidate->getTwitter(); ?></span>
        <?php else : ?>
            <a
                href="#"
                class="profile-edit-link js-profile-edit-link"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-action="load_websites_form"
                data-form-id="websites"
            >
                <?php _e('Add Twitter Profile', 'ecjobhunting'); ?>
            </a>
        <?php endif; ?>
    </li>
    <li>
        <div class="profile-icon"><?php echo getLinkedinIcon(); ?></div>
        <?php if ($candidate->getLinkedin()) : ?>
            <span><?php echo $candidate->getLinkedin(); ?></span>
        <?php else : ?>
            <a
                href="#"
                class="profile-edit-link js-profile-edit-link"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-action="load_websites_form"
                data-form-id="websites"
            >
                <?php _e('Add LinkedIn Profile', 'ecjobhunting'); ?>
            </a>
        <?php endif; ?>
    </li>
    <li>
        <div class="profile-icon"><?php echo getFacebookIcon(); ?></div>
        <?php if ($candidate->getFacebook()) : ?>
            <span><?php echo $candidate->getFacebook(); ?></span>
        <?php else : ?>
            <a
                href="#"
                class="profile-edit-link js-profile-edit-link"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-action="load_websites_form"
                data-form-id="websites"
            >
                <?php _e('Add Facebook Profile', 'ecjobhunting'); ?>
            </a>
        <?php endif; ?>
    </li>
</ul>

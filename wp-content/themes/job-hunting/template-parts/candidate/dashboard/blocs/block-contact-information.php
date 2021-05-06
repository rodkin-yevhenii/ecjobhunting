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
        data-action="load_contacts_form"
        data-form-id="contacts"
    >
        <?php _e('Edit', 'ecjobhunting'); ?>
    </button>
    <h2 class="no-decor"><?php _e('Contact Information', 'ecjobhunting'); ?></h2>
</div>
<ul>
    <li>
        <div class="profile-icon"><?php echo getEnvelopIcon(); ?></div>
        <span><?php echo $candidate->getEmail(); ?></span>
        <?php if (!$candidate->isEmailConfirmed()) : ?>
            <span class="color-red">
                <?php _e(
                    'Verify your email to receive application updates from employers.',
                    'ecjobhunting'
                ); ?>
            </span>
            <button class="btn btn-primary"><?php _e('Resend Confirmation', 'ecjobhunting'); ?></button>
        <?php endif; ?>
    </li>
    <li>
        <div class="profile-icon"><?php echo getPhoneIcon(); ?></div>
        <?php if ($candidate->getPhoneNumber()) : ?>
            <span><?php echo $candidate->getPhoneNumber(); ?></span>
        <?php else : ?>
            <a
                href="#"
                class="profile-edit-link js-profile-edit-link"
                type="button"
                data-toggle="modal"
                data-target="#edit"
                data-action="load_contacts_form"
                data-form-id="contacts"
            >
                <?php _e('Add Phone Number', 'ecjobhunting'); ?>
            </a>
        <?php endif; ?>
    </li>
</ul>

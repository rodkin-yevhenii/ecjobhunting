<?php
$candidate = $args['candidate'] ?? null;

if (!$candidate) {
    return;
}
?>
<h3><?php _e('Let Employers Find You', 'ecjobhunting'); ?></h3>
<div
    id="profile-activation-switcher"
    class="custom-handler <?php echo $candidate->isPublished() ? "active" : ""; ?>"
>
    <div></div>
</div>
<div class="profile-activation__spinner spinner-grow text-muted d-none"></div>
<p class="profile-activation__text">
    <?php if ($candidate->isPublished()) :
        _e(
            'Public: Your profile is publicly accessible.',
            'ecjobhunting'
        );
    else :
        _e(
            'Private: Your profile is not publicly accessible.',
            'ecjobhunting'
        );
    endif; ?>
</p>


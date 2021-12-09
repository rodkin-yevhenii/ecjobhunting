<?php

if (empty($args['chats'])) {
    return;
}

$activeChat = $args['active_chat'] ?? null;
?>
<h1 class="title-decorated">
    <span>Messages</span>
    <img src="/wp-content/themes/job-hunting/assets/public/images/icons/pencil.png" alt="some text">
</h1>
<ul class="messages-controls js-contacts" data-nonce="<?php echo wp_create_nonce('reload_contacts'); ?>">
    <?php
    foreach ($args['chats'] as $chat) :
        get_template_part(
            'template-parts/chat/contacts',
            'item',
            [
                'chat' => $chat,
                'active_chat' => $activeChat,
            ]
        );
    endforeach;
    ?>
</ul>

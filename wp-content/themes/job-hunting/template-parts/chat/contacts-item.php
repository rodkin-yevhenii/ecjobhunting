<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Chat;

if (empty($args['chat'])) {
    return;
}

/**
 * @var $chat Chat
 */
$chat = $args['chat'];
$user = $chat->getOpponent();
$activeChat = $args['active_chat'] ?? null;
?>
<li
    class="js-chat-card <?php echo (int)$activeChat === $chat->getId() ? 'active' : ''; ?>"
    data-tab-item="1"
    data-chat-id="<?php
    echo $chat->getId(); ?>"
    data-contact-name="<?php
    echo $user->getName(); ?>"
>
    <strong class="d-block text-large color-primary text-regular mb-3 js-card__contact-name">
        <?php
        echo $user->getName();

        if (!$chat->isViewed()) :
            ?>
            <sup>*</sup>
            <?php
        endif;
        ?>
    </strong>
    <?php
    if ('candidate' === $user->getRole() && !empty($user->getCurrentPositionAndCompanyText())) :
        /**
         * @var $user Candidate
         */
        ?>
        <span class="color-secondary">
            <?php
            echo $user->getCurrentPositionAndCompanyText(); ?>
        </span>
        <?php
    endif;
    ?>
</li>

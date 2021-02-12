<?php

use EcJobHunting\Service\User\UserService;

global $post;
if ($args['candidate']) {
    $candidate = $args['candidate'];
} else {
    $candidate = UserService::getUser($post->post_author);
}
?>
<div class="candidate-card">
    <h4 class="text-large text-regular color-primary m-0"><a
                href="<?php echo $candidate->getProfileUrl(); ?>"><?php echo $candidate->getName(); ?></a></h4>
    <p class="m-0 mt-2">Applied to: Graphic Designer</p>
    <p class="m-0 color-secondary"><?php echo nicetime($post->post_modified); ?></p>
    <p class="m-0 mt-3">Director</p>
    <p class="m-0 color-secondary">at Galerie 255</p>
    <div class="rate-buttons">
        <button><?php echo getLikeIcon(); ?></button>
        <button><?php echo getNotSureIcon(); ?></button>
        <button><?php echo getDislikeIcon(); ?></button>
    </div>
</div>
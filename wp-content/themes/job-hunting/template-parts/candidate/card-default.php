<?php

use EcJobHunting\Service\User\UserService;
global $post;
$isFirst = $args['isFirst'] ?? false;
$candidate = UserService::getUser($post->post_author);
?>
    <div class="results-item <?php echo $isFirst ? 'mt-4' : ''; ?>">
        <div class="container-fluid">
            <div class="row d-flex justify-content-xl-center">
                <div class="col d-none d-md-block col-md-3 col-xl-2">
                    <div class="results-image"><img src="<?php echo $candidate->getPhoto(); ?>" alt="photo"></div>
                </div>
                <div class="col-12 col-md-6 col-xl-7 d-flex flex-wrap"><small><?php echo nicetime($post->post_modified); ?></small>
                    <h4 class="color-primary"><?php echo $candidate->getName(); ?></h4><span class="results-country color-secondary"><?php echo $candidate->getLocation(); ?></span>
                    <ul>
                        <li><span class="color-secondary">Applied to Graphic Designer</span></li>
                        <li class="color-black">Director <span class="color-secondary">at Galirie 255</span></li>
                        <li class="color-black">Independent Contractor <span class="color-secondary">at VIZ Media</span>
                        </li>
                        <li class="color-black">Bachelor of Fine Arts (BFA) <span class="color-secondary">in Graphic Design</span>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-3 mt-3 mt-md-0">
                    <div class="rate-buttons">
                        <button><?php echo getLikeIcon(); ?></button>
                        <button><?php echo getNotSureIcon(); ?></button>
                        <button><?php echo getDislikeIcon(); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
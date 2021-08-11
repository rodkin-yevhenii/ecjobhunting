<?php

use EcJobHunting\Entity\Candidate;
use EcJobHunting\Entity\Vacancy;
use EcJobHunting\Service\User\UserService;

/**
 * @var $args array
 */
if (empty($args['candidateData'])) {
    return;
}
$data = $args['candidateData'];
$candidate = UserService::getUser($data['employee']);
$vacancy = new Vacancy($data['vacancy']);
$cv = new Candidate(get_user_by('id', $candidate->getUserId()));
?>
<div class="candidate-card">
    <h4 class="text-large text-regular color-primary m-0">
         <a href="<?php echo $candidate->getProfileUrl(); ?>"><?php echo $candidate->getName(); ?></a>
    </h4>
    <p class="m-0 mt-2">Applied to: <?php echo $vacancy->getTitle(); ?></p>
    <p class="m-0 color-secondary"><?php echo $data['date']; ?></p>
    <p class="m-0 mt-3"><?php echo $cv->getHeadline(); ?></p>
    <p class="m-0 color-secondary">at Galerie 255</p>
    <div class="rate-buttons">
        <button><?php echo getLikeIcon(); ?></button>
        <button><?php echo getNotSureIcon(); ?></button>
        <button><?php echo getDislikeIcon(); ?></button>
    </div>
</div>

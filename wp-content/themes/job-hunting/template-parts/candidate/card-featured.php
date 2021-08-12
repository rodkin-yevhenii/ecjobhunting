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
$company = $args['company'];
$candidate = UserService::getUser($data['employee']);
$vacancy = new Vacancy($data['vacancy']);
$cv = new Candidate(get_user_by('id', $candidate->getUserId()));
$workExperience = $cv->getExperience();
?>
<div class="candidate-card">
    <h4 class="text-large text-regular color-primary m-0">
         <?php echo $candidate->getName(); ?>
    </h4>
    <p class="m-0 mt-2">Applied to: <?php echo $vacancy->getTitle(); ?></p>
    <p class="m-0 color-secondary"><?php echo $data['date']; ?></p>
    <?php
    foreach ($workExperience as $experience) :
        if (!empty($experience['job_position'])) :
            ?>
            <p class="m-0 mt-3"><?php echo $experience['job_position']; ?></p>
            <?php
        endif;

        if (!empty($experience['company_name'])) :
            ?>
            <p class="m-0 color-secondary">at <?php echo $experience['company_name']; ?></p>
            <?php
        endif;
    endforeach;

    renderRateButtons($candidate->getUserId(), $company->getRatedCandidates());
    ?>
</div>

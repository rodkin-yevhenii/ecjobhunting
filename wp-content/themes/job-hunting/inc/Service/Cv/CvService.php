<?php

namespace EcJobHunting\Service\Cv;

use EcJobHunting\Service\Cv\Ajax\AjaxFormAboutMe;
use EcJobHunting\Service\Cv\Ajax\AjaxFormAchievements;
use EcJobHunting\Service\Cv\Ajax\AjaxFormActivation;
use EcJobHunting\Service\Cv\Ajax\AjaxFormAssociations;
use EcJobHunting\Service\Cv\Ajax\AjaxFormCertificates;
use EcJobHunting\Service\Cv\Ajax\AjaxFormContacts;
use EcJobHunting\Service\Cv\Ajax\AjaxFormEducation;
use EcJobHunting\Service\Cv\Ajax\AjaxFormExecutiveSummary;
use EcJobHunting\Service\Cv\Ajax\AjaxFormMoreInformation;
use EcJobHunting\Service\Cv\Ajax\AjaxFormObjective;
use EcJobHunting\Service\Cv\Ajax\AjaxFormReferences;
use EcJobHunting\Service\Cv\Ajax\AjaxFormResume;
use EcJobHunting\Service\Cv\Ajax\AjaxFormSkills;
use EcJobHunting\Service\Cv\Ajax\AjaxFormWebsites;
use EcJobHunting\Service\Cv\Ajax\AjaxFormWorkExperience;
use EcJobHunting\Service\Cv\Ajax\AjaxGotHired;
use EcJobHunting\Service\User\UserService;
use Exception;

/**
 * Class CvService
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\Cv
 */
class CvService
{
    /**
     * Register hooks
     */
    public function __invoke()
    {
        add_action('ecjob-save-new-data', [$this, 'updateAvatar']);

        $this->registerAjaxControllers();

        new EmailConfirmation();
    }

    /**
     * Register ajax controllers.
     */
    private function registerAjaxControllers(): void
    {
        new AjaxFormAboutMe();
        new AjaxFormContacts();
        new AjaxFormWebsites();
        new AjaxFormActivation();
        new AjaxFormExecutiveSummary();
        new AjaxFormWorkExperience();
        new AjaxFormEducation();
        new AjaxFormObjective();
        new AjaxFormAchievements();
        new AjaxFormAssociations();
        new AjaxFormSkills();
        new AjaxFormMoreInformation();
        new AjaxFormResume();
        new AjaxFormReferences();
        new AjaxFormCertificates();
        new AjaxGotHired();
    }

    /**
     * Save user avatar
     *
     * @param int $userId
     * @throws Exception
     */
    public function updateAvatar(int $userId): void
    {
        if (
            get_current_user_id() !== $userId
            || empty($_FILES['avatar'])
            || !wp_verify_nonce($_POST['upload_avatar_nonce'] ?? '', 'upload_avatar')
        ) {
            return;
        }

        if (!is_admin()) {
            require_once ABSPATH . 'wp-admin/includes/media.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/image.php';
        }

        preg_match('/^(.{1,})\.[a-zA-Z]+$/', $_FILES['avatar']['name'], $matches);

        $images = get_posts(
            [
                'post_mime_type' => 'image',
                'post_type' => 'attachment',
                'name' => $matches[1],
                'numberposts' => 1,
                'fields' => 'ids'
            ]
        );

        if (!empty($images)) {
            $imgId = $images[0];
        } else {
            $imgId = media_handle_upload('avatar', 0);
        }

        if ($imgId === (int)get_field('photo', "user_$userId")) {
            return;
        }

        if (is_wp_error($imgId)) {
            throw new Exception(__('Avatar updating was failed.', 'ecjobhunting'));
        }

        update_field('photo', $imgId, "user_$userId");
    }

    public static function calculateProgress(): int
    {
        $part = 100 / 6;
        $progress = $part;
        $candidate = UserService::getUser(get_current_user_id());

        if ($candidate->getPhoneNumber()) {
            $progress += $part;
        }

        if ($candidate->getSkills()) {
            $progress += $part;
        }

        if ($candidate->getHeadline()) {
            $progress += $part;
        }

        if ($candidate->getExperience()) {
            $progress += $part;
        }

        if (!empty($candidate->getResumeFile())) {
            $progress += $part;
        }

        return ceil($progress);
    }
}

<?php

namespace EcJobHunting\Service\Cv;

use EcJobHunting\Service\User\UserService;
use Exception;

/**
 * Class EmailConfirmation
 *
 * @author Yevhenii Rodkin <rodkin.yevhenii@gmail.com>
 * @package EcJobHunting\Service\User
 */
class EmailConfirmation
{
    public function __construct()
    {
        add_action('candidate_email_verification', [$this, 'verifyEmailChange'], 20);
    }

    /**
     * Send confirmation email with verification code.
     *
     * @throws Exception
     */
    public static function sendCvEmailConfirmation(): void
    {
        $candidate = UserService::getUser(get_current_user_id());

        if ($candidate->getEmail() === $candidate->getNewEmail()) {
            throw new Exception(__('The e-mail has already used', 'ecjobhunting'), 204);
        }

        $hash = md5($candidate->getNewEmail() . time() . mt_rand());
        update_field('hash', $hash, $candidate->getCvId());
        ob_start();
        ?>
Dear <?php echo $candidate->getName(); ?>,
Please click on the following link to confirm your email address:
###ADMIN_URL###

Sincerely yours,
###SITENAME###.
        <?php
        $content = apply_filters(
            'new_cv_verify_email_content',
            ob_get_clean(),
            $candidate
        );

        $content = str_replace(
            '###ADMIN_URL###',
            esc_url(site_url('/dashboard/?new_email_hash=' . $hash)),
            $content
        );
        $content = str_replace('###EMAIL###', $candidate->getNewEmail(), $content);
        $content = str_replace('###SITENAME###', 'EC Jobhunting', $content);
        $content = str_replace('###SITEURL###', home_url(), $content);

        if (
            !wp_mail(
                $candidate->getNewEmail(),
                'EC Jobhunting > New Email Address',
                $content
            )
        ) {
            throw new Exception('The confirmation email wasn\'t sent', 500);
        }
    }

    /**
     * Verify email changing.
     *
     * @throws Exception
     */
    public function verifyEmailChange(): void
    {
        if (
            !preg_match('/^\/dashboard\/.*/', $_SERVER['REQUEST_URI'])
            || !UserService::isCandidate()
            || empty($_REQUEST['new_email_hash'])
        ) {
            return;
        }

        $candidate = UserService::getUser(get_current_user_id());

        if ($_REQUEST['new_email_hash'] !== $candidate->getHash()) {
            throw new Exception(__('Invalid hash code', 'ecjobhunting'), 403);
        }

        update_field('hash', '', $candidate->getCvId());
        update_field('new_email', '', $candidate->getCvId());
        update_field('public_email', $candidate->getNewEmail(), $candidate->getCvId());
        update_field('is_email_confirmed', true, $candidate->getCvId());
    }
}

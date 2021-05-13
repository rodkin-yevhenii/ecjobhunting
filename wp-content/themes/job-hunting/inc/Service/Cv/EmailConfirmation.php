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
        $content = apply_filters(
            'new_cv_verify_email_content',
            __(
                "Dear user,

    You recently requested to have the email address on your account changed.
    If this is correct, please click on the following link to change it:
    ###ADMIN_URL###

    You can safely ignore and delete this email if you do not want to
    take this action.

    This email has been sent to ###EMAIL###

    Regards,
    All at ###SITENAME###
    ###SITEURL###",
                'ecjobhunting'
            ),
            $candidate
        );

        $content = str_replace(
            '###ADMIN_URL###',
            esc_url(site_url('/dashboard/?new_email_hash=' . $hash)),
            $content
        );
        $content = str_replace('###EMAIL###', $candidate->getNewEmail(), $content);
        $content = str_replace('###SITENAME###', get_site_option('site_name'), $content);
        $content = str_replace('###SITEURL###', home_url(), $content);

        if (
            !wp_mail(
                $candidate->getNewEmail(),
                sprintf(__('[%s] New Email Address'), get_site_option('site_name')),
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

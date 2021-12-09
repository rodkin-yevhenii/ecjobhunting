<?php

/**
 * Template Name: Employer Help
 * Post type: page
 */

$faq = get_field('faq');
$contactsPageLink = get_field('contacts_page');

$isShowPhoneEmail = get_field('is_show_help_phone_and_email') ?? false;
$isShowFAQ = get_field('is_show_faq') ?? false;
$isContactButton = get_field('is_show_contact_btn') ?? false;
$phone = get_field('help_phone');
$email = get_field('help_email');

if (empty($phone)) {
    $phone = get_field('site_phone', 'option');
}

if (empty($email)) {
    $email = get_field('site_email', 'option');
}

$cleanedPhone = trim($phone);
$cleanedPhone = str_replace([' ', '-', '(', ')'], '', $cleanedPhone);

get_header();
?>
    <div class="page employer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo the_title(); ?></h1>
                </div>
                <?php if ($isShowPhoneEmail && !empty($phone)) : ?>
                    <div class="col-12 col-md-6 col-xl-4 pb-4">
                        <p class="m-0"><?php _e('Our service is available by dialing', 'ecjobhunting'); ?>:</p>
                        <a class="link-phone" href="tel:<?php echo $cleanedPhone; ?>"><?php echo $phone; ?></a>
                    </div>
                <?php endif;

                if ($isShowPhoneEmail && !empty($email)) : ?>
                    <div class="col-12 col-md-6 pb-4">
                        <p class="m-0"><?php _e('Our email', 'ecjobhunting'); ?>:</p>
                        <a class="link-email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </div>
                <?php endif; ?>

                <div class="col-12">
                    <?php if ($isShowFAQ && !empty($faq)) : ?>
                        <div class="accordion" id="help">
                            <?php
                            $counter = 1;

                            foreach ($faq as $item) : ?>
                                <div class="card py-4 pl-md-4">
                                    <div class="card-header-custom">
                                        <div
                                            class="color-primary text-large"
                                            data-toggle="collapse"
                                            data-target="#help-<?php echo $counter; ?>"
                                            aria-expanded="true"
                                            aria-controls="help-<?php echo $counter; ?>"
                                        >
                                            <?php echo $item['question']; ?>
                                        </div>
                                    </div>
                                    <div
                                        class="collapse <?php echo 1 === $counter ? 'show' : ''; ?>"
                                        data-parent="#help"
                                        id="help-<?php echo $counter++; ?>"
                                    >
                                        <div class="card-body p-0">
                                            <?php echo $item['answer']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($isContactButton && !empty($contactsPageLink)) : ?>
                <div class="row">
                    <div class="col-12 mt-4 mt-md-5">
                        <p class="mt-0 text-large text-center">Still need help?</p>
                    </div>
                    <div class="col-12 d-md-flex justify-content-center align-items-center mt-md-3">
                        <a class="btn btn-primary d-block mt-3 mt-md-0 px-md-5" href="<?php echo $contactsPageLink; ?>">
                            Contact Support
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
get_footer();

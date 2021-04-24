<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 */

$phone = get_field('site_phone', 'option');
$email = get_field('site_email', 'option');
$siteProfiles = get_field('site_social_profiles', 'option');

$cleanedPhone = trim($phone);
$cleanedPhone = str_replace([' ', '-', '(', ')'], '', $cleanedPhone);

get_header();
?>
<section class="my-3">
    <div class="container">
        <div class="row">
            <div class="col-12 order-0">
                <h1 class="mb-5"><?php the_title(); ?></h1>
            </div>
            <?php if (!empty($phone)) : ?>
                <div class="col-12 col-md-6 order-1 col-xl-4">
                    <p class="m-0"><?php _e('Our service is available by dialing', 'ecjobhunting'); ?>:</p>
                    <a class="link-phone" href="tel:<?php echo $cleanedPhone; ?>"><?php echo $phone; ?></a>
                </div>
            <?php endif;

            if (!empty($siteProfiles)) : ?>
                <div class="col-12 col-md-6 order-2 order-md-3 col-xl-8">
                    <div class="social social-full my-4">
                        <ul>
                            <?php foreach ($siteProfiles as $profile) :
                                $networkName = trim($profile['site_social_network_name']);
                                $networkName = strtolower($networkName); ?>
                                <li>
                                    <a
                                        href="<?php echo $profile['site_social_profile_url'] ?>"
                                        target="_blank"
                                        rel="nofollow noopener noreferrer"
                                    >
                                        <i class="fa fa-<?php echo $networkName; ?>"></i>
                                        <span><?php echo $profile['site_social_profile_name']; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif;

            if (!empty($email)) : ?>
                <div class="col-12 col-md-6 order-3 order-md-2">
                    <p class="m-0"><?php _e('Our email', 'ecjobhunting'); ?>:</p>
                    <a class="link-email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                </div>
            <?php endif; ?>
            <div class="col-12 order-4">
                <h3 class="mt-5 mb-0 mt-md-3"><?php _e('Say digital Hello', 'ecjobhunting'); ?></h3>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer();

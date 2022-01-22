<?php
$aboutText = get_field('footer_about_us_description', 'option');
$siteProfiles = get_field('site_social_profiles', 'option');
?>
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-9">
                <h3><?php _e('About Us', 'ecjobhunting'); ?></h3>
                <?php if (!empty($aboutText)) : ?>
                    <p><?php echo $aboutText; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 col-xl-3">
                <h3><?php _e('For Candidates', 'ecjobhunting'); ?></h3>
                <?php wp_nav_menu(
                    [
                        'theme_location'  => 'footer-left',
                        'menu'            => '',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'footer-menu footer-menu--left',
                        'menu_id'         => 'footer-left-menu',
                        'echo'            => true,
                        'fallback_cb'     => '__return_empty_string',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ]
                ); ?>
            </div>
            <div class="col-12 col-md-4 col-xl-3">
                <h3><?php _e('For Employers', 'ecjobhunting'); ?></h3>
                <?php wp_nav_menu(
                    [
                        'theme_location'  => 'footer-center',
                        'menu'            => '',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'footer-menu footer-menu--center',
                        'menu_id'         => 'footer-center-menu',
                        'echo'            => true,
                        'fallback_cb'     => '__return_empty_string',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ]
                ); ?>
            </div>
            <div class="col-12 col-md-4 col-xl-3">
                <h3><?php _e('Other', 'ecjobhunting'); ?></h3>
                <?php wp_nav_menu(
                    [
                        'theme_location'  => 'footer-right',
                        'menu'            => '',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'footer-menu footer-menu--right',
                        'menu_id'         => 'footer-right-menu',
                        'echo'            => true,
                        'fallback_cb'     => '__return_empty_string',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ]
                ); ?>
                <div class="footer-buttons">
                    <?php if (!empty($siteProfiles)) : ?>
                        <div class="social">
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
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="apps-links">
                        <ul>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=com.app.ecjobhuntingo&amp;pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1">
                                    <img src="/wp-content/themes/job-hunting/assets/public/images/google-play.png" alt="Get it on Google Play" />
                                </a>
                            </li>
                            <li>
                                <a href="https://apps.apple.com/us/app/ec-job-hunting-sr/id1602294300?itsct=apps_box_badge&amp;amp;itscg=30200">
                                    <img src="/wp-content/themes/job-hunting/assets/public/images/apple-play.png" alt="Download on the App Store" />
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
<div class="modal fade" id="notification-popup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="content"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>

</body>
</html>

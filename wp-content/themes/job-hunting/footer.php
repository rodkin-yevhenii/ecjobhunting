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
                <?php if (!empty($siteProfiles)) : ?>
                    <div class="social">
                        <ul>
                            <?php foreach ($siteProfiles as $profile) :
                                $networkName = trim($profile['site_social_network_name']);
                                $networkName = strtolower($networkName); ?>
                                <li>
                                    <a href="<?php echo $profile['site_social_profile_url'] ?>">
                                        <i class="fa fa-<?php echo $networkName; ?>"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
<?php

use EcJobHunting\Entity\EcJobUser;

global $ec_site;
$user = new EcJobUser(wp_get_current_user());
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
    <header class="header">
        <div class="container">
            <div class="row align-items-md-center">
                <div class="col-6 col-md-3">
                    <div class="header-logo">
                        <?php if (is_front_page()): ?>
                            <img src="<?php echo $ec_site->getLogoUrl(); ?>"
                                 alt="<?php _e('EC Job Hunting Logo', 'ecjobhunting'); ?>">
                        <?php else: ?>
                            <a href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'ecjobhunting'); ?>"><img
                                        src="<?php echo $ec_site->getLogoUrl(); ?>" alt="<?php _e('EC Job Hunting Logo', 'ecjobhunting'); ?>"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (has_nav_menu('top')) : ?>
                    <?php wp_nav_menu(
                        [
                            'container_class' => 'col-6 col-md-5 col-xl-6 align-self-md-center d-flex justify-content-end justify-content-xl-start',
                            'theme_location' => 'top',
                            'menu_class' => 'header-menu',
                            'items_wrap' => '<div class="header-burger d-md-none"><span></span></div><nav><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
                        ]
                    ); ?>
                <?php endif; ?>
                <?php if (is_user_logged_in()): ?>
                    <div class="col d-none d-md-block col-md-4 col-xl-3 header-account-wrapper">
                        <div class="header-account">
                            <div class="header-account-image">
                                <a href="<?php echo $user->getProfileUrl(); ?>"
                                   title="<?php echo sprintf(
                                       __('Go to %s profile ', 'ecjobhunting'),
                                       $user->getName()
                                   ); ?>"><img src="<?php echo $user->getPhoto(); ?>"
                                               alt="account"></a></div>
                            <div class="header-account-content"><span><?php echo $user->getName(); ?></span><i
                                        class="fa fa-power-off"></i><a
                                        href="<?php echo wp_logout_url(); ?>" data-abc="true"><?php _e(
                                        'logout',
                                        'ecjobhunting'
                                    ); ?></a></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col d-none d-md-block col-md-3 col-xl-2 header-button-wrapper">
                        <a class="btn btn-outline-white" href="<?php echo wp_login_url(); ?>"
                           title="<?php _e('Login / Sign Up', 'ecjobhunting'); ?>"><?php _e(
                                'Login / Sign Up',
                                'ecjobhunting'
                            ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main>
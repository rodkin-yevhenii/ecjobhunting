<?php  global $ec_site; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php wp_title(); ?>
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
                    <div class="header-logo"><img src="<?php echo $ec_site->getLogoUrl(); ?>" alt=""></div>
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
                <div class=" col d-none d-md-block col-md-4 col-xl-3 header-account-wrapper">
                        <div class="header-account">
                            <div class="header-account-image"><img src="<?php echo IMG_URI; ?>account.jpg"
                                                                   alt="account">
                            </div>
                            <div class="header-account-content"><span>EmployerName</span><i class="fa fa-power-off"></i><a
                                        href="#">logout</a></div>
                        </div>
                    </div>
                </div>
            </div>
    </header>
    <main>
<?php if (has_nav_menu('employer')) : ?>
    <?php wp_nav_menu(
        [
            'container' => 'nav',
            'container_class' => 'menu menu-jobs',
            'theme_location' => 'employer',
            'menu_class' => '',
            'items_wrap' => '
    <div class="container p-0">
        <div class="row">
            <div class="col-12 col-md-3 d-xl-none"><span>Account menu:</span></div>
            <div class="col-12 col-md-6 col-xl-12"><ul data-select>%3$s<li><a href="/activation/">' . getActivateProfileIcon(
                ) . 'Activate</a></li></ul></div>
        </div>
    </div>',
        ]
    ); ?>
<?php endif;
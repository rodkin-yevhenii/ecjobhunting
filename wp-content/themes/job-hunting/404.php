<?php get_header(); ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="mt-3 my-md-5">
                    <header>
                        <h1 class="mb-md-5"><?php _e('404 Page Not Found', 'ecjobhunting'); ?></h1>
                        <p><?php _e("The page you've requested does not exist or was moved.", 'ecjobhunting'); ?></p>
                    </header>
                    <?php get_template_part('template-parts/vacancy/form', 'search'); ?>
                </section>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>

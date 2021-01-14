<?php

/**
 * Template Name: Fullwidth
 */
get_header(); ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if (have_posts()): the_post();
                        get_template_part('content');
                    else:
                        get_template_part('content', 'none');
                    endif; ?>
                </div>
            </div>
        </div>
    </main>
<?php get_footer();

<?php

get_header(); ?>

<?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>
        <?php get_template_part('content'); ?>
    <?php endwhile; ?>
<?php else: ?>
    <?php get_template_part('content-none'); ?>
<?php endif; ?>
<?php get_footer();

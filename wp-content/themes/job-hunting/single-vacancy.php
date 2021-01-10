<?php get_header(); ?>
<?php if (have_posts()): the_post(); ?>
    <?php the_title(); ?>
    <?php else: ?>
        <?php get_template_part('content-none'); endif; ?>
    <?php get_footer();

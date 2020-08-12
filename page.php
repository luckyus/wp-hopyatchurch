<?php
/*
 * Hop Yat Church single post template (200810)
 */
?>

<?php get_header() ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
        the_content();
    endwhile;
else : ?>
    <p><?php _e('Sorry, no pages matched your criteria'); ?></p>
<?php endif; ?>

<?php get_footer() ?>
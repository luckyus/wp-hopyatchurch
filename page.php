<?php
/*
 * Hop Yat Church single post template (200810)
 */
?>

<?php get_header() ?>

<div class="container-xl text-center">
    <h3><?php the_title() ?></h3>
    <h4>整緊整緊!</h4>
</div>

<?php if (have_posts()) : while (have_posts()) : the_post();
        the_content();
    endwhile;
else : ?>
    <p><?php _e('Sorry, no pages matched your criteria'); ?></p>
<?php endif; ?>

<?php get_footer() ?>
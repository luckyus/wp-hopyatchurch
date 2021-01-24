<?php
/*
 * Hop Yat Church single post template (200810)
 */
?>

<?php get_header() ?>

<div class="container-xl px-0 px-md-2 text-center">
    <h3><?php the_title() ?></h3>
    <?php if (have_posts()) : while (have_posts()) : the_post();
            the_content();
        endwhile;
    else : ?>
        <p><?php _e('Sorry, no pages matched your criteria'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer() ?>
<?php
/*
 * Function defination for Hop Yat Church theme (200809)
 */

?>

<?php
if (!isset($content_width)) {
    $content_width = 660;
}

function hopyatchurch_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'hopyatchurch_setup');

?>
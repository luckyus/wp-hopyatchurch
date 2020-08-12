<?php
/*
 * function defination for Hop Yat Church theme (200809)
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

    // menu ref: https://github.com/wp-bootstrap/wp-bootstrap-navwalker (200809)
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    register_nav_menus(array(
        'primary' => __('Main header menu', 'hopyatchurch'),
    ));
}

add_action('after_setup_theme', 'hopyatchurch_setup');

function hopyatchurch_scripts()
{
    wp_enqueue_style('bootstrap-core', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/fontawesome/css/all.min.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'hopyatchurch_scripts');

function new_excerpt_text()
{
    return '...';
}

add_filter('excerpt_more', 'new_excerpt_tet');

function featureText()
{
    if (is_front_page()) {
        _e('中華基督教會<br/>合一堂九龍堂');
    } elseif (is_home() || is_single()) {
        _e('中華基督教會<br/>教牧團隊博客');
    } else {
        _e('中華基督教會<br/>合一堂九龍堂');
    }
}

?>
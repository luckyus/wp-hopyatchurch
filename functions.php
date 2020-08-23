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

    // featured images using post thumbnails (200819)
    add_theme_support('post-thumbnails');

    // menu ref: https://github.com/wp-bootstrap/wp-bootstrap-navwalker (200809)
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    register_nav_menus(array(
        'primary' => __('Main header menu', 'hopyatchurch'),
    ));

    // custom headers (200821)
    $args = array(
        'default-image'      => get_template_directory_uri() . '/images/churchBanner00.jpg',
        'default-text-color' => '000',
        'width'              => 1020,
        'height'             => 150,
        'flex-width'         => true,
        'flex-height'        => true,
    );

    add_theme_support('custom-header', $args);

    register_default_headers(array(
        'banner01' => array(
            'url' => get_template_directory_uri() . '/images/churchBanner01.jpg',
            'thumbnail_url' => get_template_directory_uri() . '/images/churchBanner01.jpg',
            'description' => __('Banner 01')
        ),
        'banner02' => array(
            'url' => get_template_directory_uri() . '/images/churchBanner02.jpg',
            'thumbnail_url' => get_template_directory_uri() . '/images/churchBanner02.jpg',
            'description' => __('Banner 02')
        ),
        'banner03' => array(
            'url' => get_template_directory_uri() . '/images/churchBanner03.jpg',
            'thumbnail_url' => get_template_directory_uri() . '/images/churchBanner03.jpg',
            'description' => __('Banner 03')
        ),
        'banner04' => array(
            'url' => get_template_directory_uri() . '/images/churchBanner04.jpg',
            'thumbnail_url' => get_template_directory_uri() . '/images/churchBanner04.jpg',
            'description' => __('Banner 04')
        ),
    ));
}

add_action('after_setup_theme', 'hopyatchurch_setup');

function hopyatchurch_scripts()
{
    wp_enqueue_style('bootstrap-core', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/fontawesome/css/all.min.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
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
        if (get_field('header_text_front_page')) {
            the_field('header_text_front_page');
        } else {
            _e('ACF sucks!');
        }
    } elseif (is_home()) {
        _e('中華基督教會<br/>教牧團隊博客 (home)');
    } elseif (is_single()) {
        _e('中華基督教會<br/>教牧團隊博客 (single)');
    } elseif (is_search()) {
        _e('中華基督教會<br/>教牧團隊博客 (search)');
        _e("<br/>");
        printf(__('Search results for: %s'), get_search_query());
    } elseif (is_404()) {
        _e('中華基督教會<br/>教牧團隊博客 (404)');
    } else {
        _e('中華基督教會<br/>合一堂九龍堂');
    }
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Home left sidebar',
        'id'            => 'home_left_1',
        'before_widget' => '<div class="pb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="my-sidebar-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'arphabet_widgets_init');

?>
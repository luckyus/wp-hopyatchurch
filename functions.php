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
    require_once get_template_directory() . '/class-my-navwalker.php';
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

    // user comments walker (change 'says' to '留言') (200912)
    require_once get_template_directory() . '/class-my-commentwalker.php';

    // widgets (200921)
    require_once get_template_directory() . '/widgets/latest-blog.php';
    require_once get_template_directory() . '/widgets/sunday-service.php';
    require_once get_template_directory() . '/widgets/poster.php';
}

add_action('after_setup_theme', 'hopyatchurch_setup');

// scripts & css 
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('bootstrap-core', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/fontawesome/css/all.min.css');
    wp_enqueue_style('custom', get_template_directory_uri() . '/style.css');

    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        // wp_enqueue_script('comment-reply');
        wp_enqueue_script('my-comment-reply', get_template_directory_uri() . '/js/my-comment-reply.js', null, null, true);
    }
});

add_action('admin_enqueue_scripts', function () {
    // jquery ui datepicker for widget 主日崇拜 (201013)
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css');
    wp_enqueue_script('my-datepicker', get_template_directory_uri() . '/js/my-datepicker.js', null, null, true);
    // wp_enqueue_script('datepicker-zh-TW', get_template_directory_uri() . '/js/datepicker-zh-TW.js', null, null, true);
});

// new_excerpt_text() (xxxxxx)
add_filter('excerpt_more', function () {
    return '...';
});

function featureText()
{
    global $template;
    _e("中華基督教會合一堂九龍堂<br/><h5 class='text-monospace'>*** " . basename($template) . "***</h5>");

    // if (is_front_page()) {
    //     if (get_field('header_text_front_page')) {
    //         the_field('header_text_front_page');
    //     } else {
    //         _e('ACF sucks!');
    //     }
    // } elseif (is_home()) {
    //     _e('中華基督教會<br/>教牧團隊博客 (home)');
    // } elseif (is_single()) {
    //     _e('中華基督教會<br/>教牧團隊博客 (single)');
    // } elseif (is_search()) {
    //     _e('中華基督教會<br/>教牧團隊博客 (search)');
    //     _e("<br/>");
    //     printf(__('Search results for: %s'), get_search_query());
    // } elseif (is_404()) {
    //     _e('中華基督教會<br/>教牧團隊博客 (404)');
    // } else {
    //     _e('中華基督教會<br/>合一堂九龍堂');
    // }
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init()
{
    register_sidebar(array(
        'name'          => 'Home Main',
        'id'            => 'home_main',
        'before_widget' => '<div class="card mb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="card-header d-flex justify-content-between">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => 'Home Left Sidebar',
        'id'            => 'home_left_sidebar',
        'before_widget' => '<div class="card mb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="card-header d-flex justify-content-between">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => 'Blog Left Sidebar',
        'id'            => 'home_left_1',
        'before_widget' => '<div class="pb-3">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="my-sidebar-title">',
        'after_title'   => '</h4>',
    ));

    // other widgets (200921)
    register_widget('WP_Widget_Latest_Blog');
    register_widget('WP_Widget_Sunday_Service');
    register_widget('WP_Widget_Poster');
}

add_action('widgets_init', 'arphabet_widgets_init');

// remove the string "Log in to reply" (200917)
function change_comment_reply_text($link)
{
    $link = str_replace('Log in to Reply', '', $link);
    return $link;
}
add_filter('comment_reply_link', 'change_comment_reply_text');

function dez_filter_chinese_excerpt($output)
{
    global $post;

    //check if its chinese character input
    $chinese_output = preg_match_all("/\p{Han}+/u", $post->post_content, $matches);
    if ($chinese_output) {
        $output = mb_substr($output, 0, 150) . '...';
    }
    return $output;
}

add_filter('get_the_excerpt', 'dez_filter_chinese_excerpt');

?>
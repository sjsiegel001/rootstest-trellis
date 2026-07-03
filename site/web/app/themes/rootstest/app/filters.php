<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Style primary navigation links with Tailwind utilities.
 *
 * @return array
 */
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if (($args->theme_location ?? '') === 'primary_navigation') {
        $atts['class'] = 'block rounded-md px-2 py-2 text-sm text-slate-300 transition hover:text-white md:py-1';
    }

    return $atts;
}, 10, 3);

/**
 * Disable the WordPress emoji detection script and inline styles — unused
 * weight on every page (wp-emoji-release.min.js + wp-emoji-styles-inline-css).
 */
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
});

add_filter('tiny_mce_plugins', fn ($plugins) => is_array($plugins) ? array_diff($plugins, ['wpemoji']) : $plugins);

add_filter('wp_resource_hints', function ($urls, $relation_type) {
    if ($relation_type === 'dns-prefetch') {
        $urls = array_filter($urls, fn ($url) => strpos($url, 's.w.org') === false);
    }

    return $urls;
}, 10, 2);

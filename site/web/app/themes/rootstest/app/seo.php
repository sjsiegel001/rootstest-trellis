<?php

/**
 * Lightweight, plugin-free SEO metadata:
 * meta description, Open Graph + Twitter cards, a Referrer-Policy header,
 * and a richer document title on the front page.
 */

namespace App;

/**
 * Best-effort meta description for the current view.
 */
function meta_description(): string
{
    $object = get_queried_object();

    if (is_singular() && $object instanceof \WP_Post) {
        if (has_excerpt($object)) {
            return wp_strip_all_tags(get_the_excerpt($object));
        }

        $text = wp_strip_all_tags(strip_shortcodes($object->post_content));

        if (trim($text) !== '') {
            return wp_trim_words($text, 30, '…');
        }
    }

    return get_bloginfo('description');
}

add_action('wp_head', function () {
    // Defer to a dedicated SEO plugin (e.g. The SEO Framework) when present,
    // so we don't emit duplicate description/OG/Twitter tags.
    if (defined('THE_SEO_FRAMEWORK_PRESENT')) {
        return;
    }

    $description = trim(meta_description());
    $title = wp_get_document_title();
    $url = is_singular() ? (get_permalink() ?: home_url('/')) : home_url('/');
    $image = home_url('/icon-512.png');
    $type = (is_singular() && ! is_front_page()) ? 'article' : 'website';

    $tags = [
        ['name' => 'description', 'content' => $description],
        ['property' => 'og:type', 'content' => $type],
        ['property' => 'og:site_name', 'content' => get_bloginfo('name')],
        ['property' => 'og:title', 'content' => $title],
        ['property' => 'og:description', 'content' => $description],
        ['property' => 'og:url', 'content' => $url],
        ['property' => 'og:image', 'content' => $image],
        ['name' => 'twitter:card', 'content' => 'summary_large_image'],
        ['name' => 'twitter:title', 'content' => $title],
        ['name' => 'twitter:description', 'content' => $description],
        ['name' => 'twitter:image', 'content' => $image],
    ];

    foreach ($tags as $tag) {
        if (($tag['content'] ?? '') === '') {
            continue;
        }

        $attr = isset($tag['property'])
            ? 'property="' . esc_attr($tag['property']) . '"'
            : 'name="' . esc_attr($tag['name']) . '"';

        printf('<meta %s content="%s">' . "\n", $attr, esc_attr($tag['content']));
    }
}, 5);

/**
 * Add the tagline to the front-page <title> so it isn't just the site name.
 */
add_filter('document_title_parts', function ($parts) {
    if (defined('THE_SEO_FRAMEWORK_PRESENT')) {
        return $parts;
    }

    if (is_front_page() && ($tagline = get_bloginfo('description'))) {
        $parts['tagline'] = $tagline;
    }

    return $parts;
});

/**
 * Security/privacy headers flagged by SEO crawlers.
 */
add_action('send_headers', function () {
    if (headers_sent()) {
        return;
    }

    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Content-Type-Options: nosniff');
});

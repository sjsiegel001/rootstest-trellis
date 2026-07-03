<?php
/**
 * Plugin Name: Avatar Alt Text
 * Description: WordPress renders comment/author Gravatars with an empty alt
 *   attribute (alt=""), which SEO crawlers flag as "missing alt text". This
 *   fills in descriptive alt text from the commenter or user name.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_filter('get_avatar_data', function (array $args, $id_or_email): array {
    if (! empty($args['alt'])) {
        return $args;
    }

    $name = '';

    if ($id_or_email instanceof WP_Comment) {
        $name = $id_or_email->comment_author;
    } elseif ($id_or_email instanceof WP_User) {
        $name = $id_or_email->display_name;
    } elseif (is_object($id_or_email) && isset($id_or_email->comment_author)) {
        $name = $id_or_email->comment_author;
    }

    $args['alt'] = $name
        ? sprintf(__('Avatar for %s', 'sage'), $name)
        : __('Commenter avatar', 'sage');

    return $args;
}, 10, 2);

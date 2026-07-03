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

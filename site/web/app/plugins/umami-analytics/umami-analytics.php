<?php
/**
 * Plugin Name:  Umami Analytics
 * Description:  Adds the Umami Cloud tracking script to the site head. Activate to enable tracking, deactivate to disable it. The website id comes from the UMAMI_WEBSITE_ID environment variable — no id set means no script is output.
 * Version:      1.0.0
 * Author:       rootstest.de
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('wp_head', function () {
    $website_id = $_ENV['UMAMI_WEBSITE_ID'] ?? '';

    if (! $website_id) {
        return;
    }

    printf(
        '<script defer src="https://cloud.umami.is/script.js" data-website-id="%s"></script>' . "\n",
        esc_attr($website_id)
    );
}, 20);

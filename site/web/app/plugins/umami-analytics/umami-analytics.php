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
    // Only ever track on production, so dev/staging traffic never hits Umami.
    if (! defined('WP_ENV') || WP_ENV !== 'production') {
        return;
    }

    $website_id = $_ENV['UMAMI_WEBSITE_ID'] ?? '';

    if (! $website_id) {
        return;
    }

    // Served first-party through /u (see trellis nginx-includes/umami-proxy) so
    // blockers that match the umami.is domain don't drop the script or beacon.
    printf(
        '<script defer src="%s" data-website-id="%s" data-host-url="%s"></script>' . "\n",
        esc_url(home_url('/u/script.js')),
        esc_attr($website_id),
        esc_url(home_url('/u'))
    );
}, 20);

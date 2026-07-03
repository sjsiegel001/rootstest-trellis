<?php
/**
 * Plugin Name: Mail defaults
 * Description: Align the envelope sender (Return-Path) with the From domain so
 *   outgoing mail isn't a @gmail.com envelope sent via SES (which fails SPF and
 *   looks like spoofing). The header From is already wordpress@rootstest.de.
 */

add_action('phpmailer_init', function ($phpmailer) {
    // Only on production, where mail actually relays through SES.
    if (defined('WP_ENV') && WP_ENV === 'production') {
        $phpmailer->Sender = 'wordpress@rootstest.de';
    }
});

<?php

/**
 * Custom blocks.
 *
 * A free, native dynamic block (no ACF) rendered with Blade. The editor UI is
 * registered in resources/js/editor.js; here we declare its attributes and the
 * server-side render callback so front-end and editor stay in sync.
 */

namespace App;

add_action('init', function () {
    register_block_type('rootstest/callout', [
        'api_version' => 3,
        'title' => __('Callout', 'sage'),
        'category' => 'design',
        'icon' => 'megaphone',
        'attributes' => [
            'heading' => ['type' => 'string', 'default' => 'Callout heading'],
            'body' => ['type' => 'string', 'default' => 'Supporting text for the callout goes here.'],
            'tone' => ['type' => 'string', 'default' => 'violet'],
        ],
        'supports' => [
            'html' => false,
            'align' => ['wide', 'full'],
        ],
        'render_callback' => fn ($attributes) => view('blocks.callout', ['attributes' => $attributes])->render(),
    ]);
});

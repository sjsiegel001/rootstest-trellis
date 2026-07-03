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

    register_block_type('rootstest/stack-grid', [
        'api_version' => 3,
        'title' => __('Stack Grid', 'sage'),
        'category' => 'design',
        'icon' => 'grid-view',
        'attributes' => [
            'items' => [
                'type' => 'array',
                'default' => [
                    ['icon' => '📦', 'title' => 'Bedrock', 'body' => 'WordPress structured as a Composer project — env-based config, sane folder layout, dependencies locked and versioned.'],
                    ['icon' => '🔧', 'title' => 'Trellis', 'body' => 'Ansible playbooks provision the Ubuntu 24.04 server (nginx, PHP 8.3, MariaDB) and ship zero-downtime deploys.'],
                    ['icon' => '🌱', 'title' => 'Sage 11', 'body' => 'This very theme: Blade templates and Acorn (Laravel) components, bundled by Vite and styled with Tailwind.'],
                    ['icon' => '☁️', 'title' => 'AWS + Terraform', 'body' => 'Every resource — VPC, EC2, IAM, S3, CloudFront — defined as code in Terraform and tagged for one-command teardown.'],
                    ['icon' => '🖼️', 'title' => 'S3 + CloudFront', 'body' => 'Media offloaded to a private S3 bucket and served worldwide through a CloudFront CDN at cdn.rootstest.de.'],
                    ['icon' => '⚡', 'title' => 'Redis + HTTPS', 'body' => 'A persistent Redis object cache keeps things fast, and Let\'s Encrypt handles automatic, auto-renewing TLS.'],
                ],
            ],
        ],
        'supports' => [
            'html' => false,
            'align' => ['wide', 'full'],
        ],
        'render_callback' => fn ($attributes) => view('blocks.stack-grid', ['attributes' => $attributes])->render(),
    ]);

    register_block_type('rootstest/hero', [
        'api_version' => 3,
        'title' => __('Hero', 'sage'),
        'category' => 'design',
        'icon' => 'cover-image',
        'attributes' => [
            'eyebrow' => ['type' => 'string', 'default' => 'Live on AWS · deployed with Trellis'],
            'title' => ['type' => 'string', 'default' => 'The Roots stack, shipped to production.'],
            'lead' => ['type' => 'string', 'default' => 'A WordPress site built on Bedrock, provisioned with Trellis, and themed with Sage 11. Infrastructure lives in Terraform; media rides a CloudFront CDN. This whole page is a Blade template compiled by Vite.'],
            'primaryLabel' => ['type' => 'string', 'default' => 'Explore Roots'],
            'primaryUrl' => ['type' => 'string', 'default' => 'https://roots.io'],
            'secondaryLabel' => ['type' => 'string', 'default' => 'See the stack ↓'],
            'secondaryUrl' => ['type' => 'string', 'default' => '#stack'],
        ],
        'supports' => [
            'html' => false,
            'align' => ['full'],
        ],
        'render_callback' => fn ($attributes) => view('blocks.hero', ['attributes' => $attributes])->render(),
    ]);
});

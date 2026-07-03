<?php

namespace App\Blocks;

class StackGrid extends Block
{
    public string $name = 'rootstest/stack-grid';

    public string $title = 'Stack Grid';

    public string $icon = 'grid-view';

    public string $view = 'blocks.stack-grid';

    public array $supports = ['html' => false, 'align' => ['wide', 'full']];

    public array $fields = [
        'heading' => ['type' => 'text', 'label' => 'Heading', 'group' => 'Section', 'default' => 'Built on the Roots stack'],
        'intro' => ['type' => 'textarea', 'label' => 'Intro', 'group' => 'Section', 'default' => 'Every layer of this page — from local development through a zero-downtime production release — runs on the same battle-tested WordPress toolchain, hosted on AWS and defined entirely in code.'],
        'items' => [
            'type' => 'repeater',
            'label' => 'Item',
            'itemLabel' => 'title',
            'subfields' => [
                'icon' => ['type' => 'text', 'label' => 'Icon (emoji)'],
                'title' => ['type' => 'text', 'label' => 'Title'],
                'body' => ['type' => 'textarea', 'label' => 'Body'],
            ],
            'default' => [
                ['icon' => '📦', 'title' => 'Bedrock', 'body' => 'WordPress structured as a Composer project — env-based config, sane folder layout, dependencies locked and versioned.'],
                ['icon' => '🔧', 'title' => 'Trellis', 'body' => 'Ansible playbooks provision the Ubuntu 24.04 server (nginx, PHP 8.3, MariaDB) and ship zero-downtime deploys.'],
                ['icon' => '🌱', 'title' => 'Sage 11', 'body' => 'This very theme: Blade templates and Acorn (Laravel) components, bundled by Vite and styled with Tailwind.'],
                ['icon' => '☁️', 'title' => 'AWS + Terraform', 'body' => 'Every resource — VPC, EC2, IAM, S3, CloudFront — defined as code in Terraform and tagged for one-command teardown.'],
                ['icon' => '🖼️', 'title' => 'S3 + CloudFront', 'body' => 'Media offloaded to a private S3 bucket and served worldwide through a CloudFront CDN at cdn.rootstest.de.'],
                ['icon' => '⚡', 'title' => 'Redis + HTTPS', 'body' => "A persistent Redis object cache keeps things fast, and Let's Encrypt handles automatic, auto-renewing TLS."],
            ],
        ],
    ];
}

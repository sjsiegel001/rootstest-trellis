<?php

namespace App\Blocks;

class Hero extends Block
{
    public string $name = 'rootstest/hero';

    public string $title = 'Hero';

    public string $icon = 'cover-image';

    public string $view = 'blocks.hero';

    public array $supports = ['html' => false, 'align' => ['full']];

    public array $fields = [
        'eyebrow' => ['type' => 'text', 'label' => 'Eyebrow', 'group' => 'Content', 'default' => 'Live on AWS · deployed with Trellis'],
        'title' => ['type' => 'text', 'label' => 'Title', 'group' => 'Content', 'default' => 'The Roots stack, shipped to production.'],
        'lead' => ['type' => 'textarea', 'label' => 'Lead', 'group' => 'Content', 'default' => 'A WordPress site built on Bedrock, provisioned with Trellis, and themed with Sage 11. Infrastructure lives in Terraform; media rides a CloudFront CDN. This whole page is a Blade template compiled by Vite.'],
        'primaryLabel' => ['type' => 'text', 'label' => 'Primary label', 'group' => 'Buttons', 'default' => 'Explore Roots'],
        'primaryUrl' => ['type' => 'text', 'label' => 'Primary URL', 'group' => 'Buttons', 'default' => 'https://roots.io'],
        'secondaryLabel' => ['type' => 'text', 'label' => 'Secondary label', 'group' => 'Buttons', 'default' => 'See the stack ↓'],
        'secondaryUrl' => ['type' => 'text', 'label' => 'Secondary URL', 'group' => 'Buttons', 'default' => '#stack'],
    ];
}

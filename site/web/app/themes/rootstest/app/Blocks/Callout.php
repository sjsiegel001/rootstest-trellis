<?php

namespace App\Blocks;

class Callout extends Block
{
    public string $name = 'rootstest/callout';

    public string $title = 'Callout';

    public string $icon = 'megaphone';

    public string $view = 'blocks.callout';

    public array $fields = [
        'heading' => ['type' => 'text', 'label' => 'Heading', 'default' => 'Callout heading'],
        'body' => ['type' => 'text', 'label' => 'Body', 'default' => 'Supporting text for the callout goes here.'],
        'tone' => [
            'type' => 'select',
            'label' => 'Tone',
            'default' => 'violet',
            'options' => ['violet' => 'Violet', 'emerald' => 'Emerald', 'amber' => 'Amber'],
        ],
    ];
}

<?php

namespace App\Blocks;

/**
 * Base class for native, Blade-rendered Gutenberg blocks — a free, no-ACF
 * alternative to acf-composer. Extend it, declare $name/$title/$view/$fields,
 * and the framework handles server registration (render callback -> Blade) and
 * generates the editor UI from the field definitions (see resources/js/editor.js).
 */
abstract class Block
{
    /** Block name, e.g. 'rootstest/hero'. */
    public string $name;

    /** Editor title. */
    public string $title;

    /** Dashicon slug or block icon. */
    public string $icon = 'block-default';

    /** Block category. */
    public string $category = 'design';

    /** Blade view, e.g. 'blocks.hero'. */
    public string $view;

    /** Block supports. */
    public array $supports = ['html' => false];

    /**
     * Editor fields keyed by attribute name. Each entry:
     *   'type'      => 'text' | 'textarea' | 'select' | 'repeater'
     *   'label'     => 'Human label'
     *   'default'   => mixed
     *   'group'     => 'Content'          (optional; groups scalar fields into a panel)
     *   'options'   => ['value' => 'Label'] (select only)
     *   'subfields' => [...]              (repeater only; same field shape)
     *   'itemLabel' => 'subfieldKey'      (repeater only; row title in the editor)
     */
    public array $fields = [];

    /** Derive WordPress block attributes from the field definitions. */
    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->fields as $key => $field) {
            $isArray = ($field['type'] ?? 'text') === 'repeater';

            $attributes[$key] = [
                'type' => $isArray ? 'array' : 'string',
                'default' => $field['default'] ?? ($isArray ? [] : ''),
            ];
        }

        return $attributes;
    }

    /** Register the block with WordPress. */
    public function register(): void
    {
        register_block_type($this->name, [
            'api_version' => 3,
            'title' => $this->title,
            'category' => $this->category,
            'icon' => $this->icon,
            'supports' => $this->supports,
            'attributes' => $this->attributes(),
            'render_callback' => [$this, 'render'],
        ]);
    }

    /** Server-side render through Blade. */
    public function render(array $attributes = []): string
    {
        $defaults = [];

        foreach ($this->attributes() as $key => $attribute) {
            $defaults[$key] = $attribute['default'];
        }

        return view($this->view, ['attributes' => array_merge($defaults, $attributes)])->render();
    }

    /** Config handed to the editor JavaScript (window.__rootstestBlocks). */
    public function editorConfig(): array
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'icon' => $this->icon,
            'category' => $this->category,
            'supports' => $this->supports,
            'attributes' => $this->attributes(),
            'fields' => $this->fields,
        ];
    }
}

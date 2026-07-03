import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button } from '@wordpress/components';
import { createElement as el, Fragment } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';

// Editor UI for the `rootstest/callout` block. Attributes + rendering live in
// app/blocks.php; the preview here is server-rendered, so it matches the front
// end exactly. Written with createElement (no JSX) to avoid extra build config.
registerBlockType('rootstest/callout', {
  apiVersion: 3,
  title: 'Callout',
  icon: 'megaphone',
  category: 'design',
  attributes: {
    heading: { type: 'string', default: 'Callout heading' },
    body: { type: 'string', default: 'Supporting text for the callout goes here.' },
    tone: { type: 'string', default: 'violet' },
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return el(
      Fragment,
      null,
      el(
        InspectorControls,
        null,
        el(
          PanelBody,
          { title: 'Callout settings', initialOpen: true },
          el(TextControl, {
            label: 'Heading',
            value: attributes.heading,
            onChange: (heading) => setAttributes({ heading }),
          }),
          el(TextControl, {
            label: 'Body',
            value: attributes.body,
            onChange: (body) => setAttributes({ body }),
          }),
          el(SelectControl, {
            label: 'Tone',
            value: attributes.tone,
            options: [
              { label: 'Violet', value: 'violet' },
              { label: 'Emerald', value: 'emerald' },
              { label: 'Amber', value: 'amber' },
            ],
            onChange: (tone) => setAttributes({ tone }),
          }),
        ),
      ),
      el(
        'div',
        blockProps,
        el(ServerSideRender, { block: 'rootstest/callout', attributes }),
      ),
    );
  },
  save() {
    return null;
  },
});

// `rootstest/stack-grid`: an editable repeater of icon/title/body cards,
// rendered by resources/views/blocks/stack-grid.blade.php. This replaces the
// hardcoded $stack array — the cards now live in the page content.
registerBlockType('rootstest/stack-grid', {
  apiVersion: 3,
  title: 'Stack Grid',
  icon: 'grid-view',
  category: 'design',
  attributes: {
    items: { type: 'array', default: [] },
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const items = attributes.items || [];

    const update = (index, key, value) =>
      setAttributes({
        items: items.map((item, i) => (i === index ? { ...item, [key]: value } : item)),
      });

    const add = () =>
      setAttributes({ items: [...items, { icon: '⭐', title: 'New item', body: '' }] });

    const remove = (index) =>
      setAttributes({ items: items.filter((_, i) => i !== index) });

    return el(
      Fragment,
      null,
      el(
        InspectorControls,
        null,
        items.map((item, index) =>
          el(
            PanelBody,
            { key: index, title: item.title || `Item ${index + 1}`, initialOpen: false },
            el(TextControl, {
              label: 'Icon (emoji)',
              value: item.icon || '',
              onChange: (value) => update(index, 'icon', value),
            }),
            el(TextControl, {
              label: 'Title',
              value: item.title || '',
              onChange: (value) => update(index, 'title', value),
            }),
            el(TextareaControl, {
              label: 'Body',
              value: item.body || '',
              onChange: (value) => update(index, 'body', value),
            }),
            el(
              Button,
              { isDestructive: true, variant: 'secondary', onClick: () => remove(index) },
              'Remove item',
            ),
          ),
        ),
        el(
          PanelBody,
          { title: 'Add item', initialOpen: true },
          el(Button, { variant: 'primary', onClick: add }, '+ Add item'),
        ),
      ),
      el('div', blockProps, el(ServerSideRender, { block: 'rootstest/stack-grid', attributes })),
    );
  },
  save() {
    return null;
  },
});

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components';
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

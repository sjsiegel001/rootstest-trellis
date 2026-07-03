import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button } from '@wordpress/components';
import { createElement as el, Fragment } from '@wordpress/element';

// These blocks render with the theme's dark Tailwind styling on the FRONT END
// (via Blade render callbacks in app/blocks.php). Inside the editor we don't try
// to reproduce that — a full preview looks broken on the light editor canvas.
// Instead each block shows a minimal, neutral placeholder summarising what the
// admin has configured. All actual editing happens in the sidebar controls.

const BOX = {
  border: '1px dashed #949494',
  borderRadius: '2px',
  padding: '14px 16px',
  background: '#f6f7f7',
  color: '#1e1e1e',
  lineHeight: 1.5,
};

const LABEL = {
  display: 'block',
  fontSize: '11px',
  fontWeight: 600,
  textTransform: 'uppercase',
  letterSpacing: '0.04em',
  color: '#757575',
  marginBottom: '8px',
};

const MUTED = { color: '#757575', margin: '2px 0' };

const label = (text) => el('span', { style: LABEL }, text);

// --- Callout ---------------------------------------------------------------
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
    const { heading, body, tone } = attributes;

    return el(
      Fragment,
      null,
      el(
        InspectorControls,
        null,
        el(
          PanelBody,
          { title: 'Callout settings', initialOpen: true },
          el(TextControl, { label: 'Heading', value: heading, onChange: (v) => setAttributes({ heading: v }) }),
          el(TextControl, { label: 'Body', value: body, onChange: (v) => setAttributes({ body: v }) }),
          el(SelectControl, {
            label: 'Tone',
            value: tone,
            options: [
              { label: 'Violet', value: 'violet' },
              { label: 'Emerald', value: 'emerald' },
              { label: 'Amber', value: 'amber' },
            ],
            onChange: (v) => setAttributes({ tone: v }),
          }),
        ),
      ),
      el(
        'div',
        useBlockProps({ style: BOX }),
        label(`Callout · ${tone}`),
        el('strong', null, heading || 'Callout heading'),
        body ? el('p', { style: { margin: '4px 0 0' } }, body) : null,
      ),
    );
  },
  save: () => null,
});

// --- Stack Grid ------------------------------------------------------------
registerBlockType('rootstest/stack-grid', {
  apiVersion: 3,
  title: 'Stack Grid',
  icon: 'grid-view',
  category: 'design',
  attributes: {
    heading: { type: 'string', default: '' },
    intro: { type: 'string', default: '' },
    items: { type: 'array', default: [] },
  },
  edit({ attributes, setAttributes }) {
    const items = attributes.items || [];
    const update = (i, key, val) =>
      setAttributes({ items: items.map((it, idx) => (idx === i ? { ...it, [key]: val } : it)) });
    const add = () => setAttributes({ items: [...items, { icon: '⭐', title: 'New item', body: '' }] });
    const remove = (i) => setAttributes({ items: items.filter((_, idx) => idx !== i) });

    return el(
      Fragment,
      null,
      el(
        InspectorControls,
        null,
        el(
          PanelBody,
          { title: 'Section', initialOpen: true },
          el(TextControl, { label: 'Heading', value: attributes.heading || '', onChange: (v) => setAttributes({ heading: v }) }),
          el(TextareaControl, { label: 'Intro', value: attributes.intro || '', onChange: (v) => setAttributes({ intro: v }) }),
        ),
        items.map((item, i) =>
          el(
            PanelBody,
            { key: i, title: item.title || `Item ${i + 1}`, initialOpen: false },
            el(TextControl, { label: 'Icon (emoji)', value: item.icon || '', onChange: (v) => update(i, 'icon', v) }),
            el(TextControl, { label: 'Title', value: item.title || '', onChange: (v) => update(i, 'title', v) }),
            el(TextareaControl, { label: 'Body', value: item.body || '', onChange: (v) => update(i, 'body', v) }),
            el(Button, { isDestructive: true, variant: 'secondary', onClick: () => remove(i) }, 'Remove item'),
          ),
        ),
        el(PanelBody, { title: 'Add item', initialOpen: true }, el(Button, { variant: 'primary', onClick: add }, '+ Add item')),
      ),
      el(
        'div',
        useBlockProps({ style: BOX }),
        label(`Stack Grid · ${items.length} item${items.length === 1 ? '' : 's'}`),
        attributes.heading ? el('strong', null, attributes.heading) : null,
        attributes.intro ? el('p', { style: MUTED }, attributes.intro) : null,
        el(
          'div',
          { style: { marginTop: '8px' } },
          items.map((item, i) =>
            el(
              'div',
              { key: i, style: { padding: '8px 0', borderTop: '1px solid #e0e0e0' } },
              el('div', null, el('strong', null, `${item.icon || ''} ${item.title || ''}`.trim())),
              item.body ? el('div', { style: MUTED }, item.body) : null,
            ),
          ),
        ),
      ),
    );
  },
  save: () => null,
});

// --- Hero ------------------------------------------------------------------
registerBlockType('rootstest/hero', {
  apiVersion: 3,
  title: 'Hero',
  icon: 'cover-image',
  category: 'design',
  attributes: {
    eyebrow: { type: 'string', default: '' },
    title: { type: 'string', default: '' },
    lead: { type: 'string', default: '' },
    primaryLabel: { type: 'string', default: '' },
    primaryUrl: { type: 'string', default: '' },
    secondaryLabel: { type: 'string', default: '' },
    secondaryUrl: { type: 'string', default: '' },
  },
  edit({ attributes, setAttributes }) {
    const field = (key, lbl) =>
      el(TextControl, { label: lbl, value: attributes[key] || '', onChange: (v) => setAttributes({ [key]: v }) });

    const ctas = [attributes.primaryLabel, attributes.secondaryLabel].filter(Boolean).join(' · ');

    return el(
      Fragment,
      null,
      el(
        InspectorControls,
        null,
        el(
          PanelBody,
          { title: 'Content', initialOpen: true },
          field('eyebrow', 'Eyebrow'),
          field('title', 'Title'),
          el(TextareaControl, { label: 'Lead', value: attributes.lead || '', onChange: (v) => setAttributes({ lead: v }) }),
        ),
        el(
          PanelBody,
          { title: 'Buttons', initialOpen: false },
          field('primaryLabel', 'Primary label'),
          field('primaryUrl', 'Primary URL'),
          field('secondaryLabel', 'Secondary label'),
          field('secondaryUrl', 'Secondary URL'),
        ),
      ),
      el(
        'div',
        useBlockProps({ style: BOX }),
        label('Hero'),
        attributes.eyebrow ? el('p', { style: MUTED }, attributes.eyebrow) : null,
        el('strong', { style: { fontSize: '15px' } }, attributes.title || 'Hero title'),
        attributes.lead ? el('p', { style: { margin: '6px 0 0' } }, attributes.lead) : null,
        ctas ? el('p', { style: { ...MUTED, marginTop: '8px' } }, `▸ ${ctas}`) : null,
      ),
    );
  },
  save: () => null,
});

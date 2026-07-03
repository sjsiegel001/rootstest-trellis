import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button } from '@wordpress/components';
import { createElement as el, Fragment } from '@wordpress/element';

// Blocks are declared as PHP classes in app/Blocks and registered server-side
// (render callback -> Blade). Their field definitions arrive via
// window.__rootstestBlocks; this file generates a matching sidebar UI plus a
// neutral placeholder for ALL of them. Adding a block never touches this file.

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

function scalarControl(field, value, onChange) {
  if (field.type === 'textarea') {
    return el(TextareaControl, { label: field.label, value: value || '', onChange });
  }

  if (field.type === 'select') {
    const options = Object.entries(field.options || {}).map(([v, l]) => ({ value: v, label: l }));

    return el(SelectControl, { label: field.label, value: value || '', options, onChange });
  }

  return el(TextControl, { label: field.label, value: value || '', onChange });
}

function inspector(cfg, attributes, setAttributes) {
  const children = [];
  const groups = {};

  // Scalar fields grouped into panels.
  Object.entries(cfg.fields).forEach(([key, field]) => {
    if (field.type === 'repeater') {
      return;
    }

    const group = field.group || 'Content';
    (groups[group] = groups[group] || []).push(
      scalarControl(field, attributes[key], (v) => setAttributes({ [key]: v })),
    );
  });

  Object.entries(groups).forEach(([group, controls], i) => {
    children.push(el(PanelBody, { key: `group-${group}`, title: group, initialOpen: i === 0 }, ...controls));
  });

  // Repeater fields: one collapsible panel per row + an add button.
  Object.entries(cfg.fields).forEach(([key, field]) => {
    if (field.type !== 'repeater') {
      return;
    }

    const items = attributes[key] || [];
    const sub = field.subfields || {};
    const set = (next) => setAttributes({ [key]: next });
    const update = (i, sk, val) => set(items.map((it, idx) => (idx === i ? { ...it, [sk]: val } : it)));
    const remove = (i) => set(items.filter((_, idx) => idx !== i));
    const add = () => {
      const blank = {};
      Object.keys(sub).forEach((sk) => {
        blank[sk] = '';
      });
      set([...items, blank]);
    };

    items.forEach((item, i) => {
      children.push(
        el(
          PanelBody,
          { key: `${key}-${i}`, title: item[field.itemLabel] || `${field.label} ${i + 1}`, initialOpen: false },
          ...Object.entries(sub).map(([sk, sf]) => scalarControl(sf, item[sk], (v) => update(i, sk, v))),
          el(Button, { isDestructive: true, variant: 'secondary', onClick: () => remove(i) }, 'Remove'),
        ),
      );
    });

    children.push(
      el(
        PanelBody,
        { key: `${key}-add`, title: `Add ${field.label}`, initialOpen: true },
        el(Button, { variant: 'primary', onClick: add }, `+ Add ${field.label}`),
      ),
    );
  });

  return el(InspectorControls, null, ...children);
}

function placeholder(cfg, attributes) {
  const rows = [el('span', { key: '__label', style: LABEL }, cfg.title)];

  Object.entries(cfg.fields).forEach(([key, field]) => {
    const value = attributes[key];

    if (field.type === 'repeater') {
      const items = value || [];
      const sub = field.subfields || {};

      rows.push(
        el(
          'div',
          { key, style: { marginTop: '6px' } },
          items.map((item, i) => {
            const head = Object.entries(sub)
              .filter(([, sf]) => sf.type !== 'textarea')
              .map(([sk]) => item[sk])
              .filter(Boolean)
              .join(' ');
            const bodies = Object.entries(sub)
              .filter(([, sf]) => sf.type === 'textarea')
              .map(([sk]) => item[sk])
              .filter(Boolean);

            return el(
              'div',
              { key: i, style: { padding: '6px 0', borderTop: '1px solid #e0e0e0' } },
              head ? el('div', null, el('strong', null, head)) : null,
              ...bodies.map((b, bi) => el('div', { key: bi, style: MUTED }, b)),
            );
          }),
        ),
      );

      return;
    }

    if (value) {
      rows.push(
        field.type === 'textarea'
          ? el('div', { key, style: MUTED }, value)
          : el('div', { key, style: { margin: '2px 0' } }, el('strong', null, value)),
      );
    }
  });

  return el('div', useBlockProps({ style: BOX }), ...rows);
}

(window.__rootstestBlocks || []).forEach((cfg) => {
  registerBlockType(cfg.name, {
    apiVersion: 3,
    title: cfg.title,
    icon: cfg.icon,
    category: cfg.category,
    supports: cfg.supports,
    attributes: cfg.attributes,
    edit: ({ attributes, setAttributes }) =>
      el(Fragment, null, inspector(cfg, attributes, setAttributes), placeholder(cfg, attributes)),
    save: () => null,
  });
});

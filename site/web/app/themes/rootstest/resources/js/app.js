// Mobile navigation toggle.
document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('[data-nav-toggle]');
  const panel = document.getElementById('mobile-nav');

  if (!button || !panel) {
    return;
  }

  button.addEventListener('click', () => {
    const isHidden = panel.toggleAttribute('hidden');
    button.setAttribute('aria-expanded', String(!isHidden));
  });
});

/**
 * main.js
 * ES module entry point for FN Mining Advisor frontend.
 *
 * Initialization order:
 * 1. Header (runs immediately — header is critical for UX)
 * 2. Animations (runs after DOMContentLoaded)
 *
 * Future phases will add:
 * - import { initHero } from './sections/hero.js';
 * - import { initServices } from './sections/services.js';
 * - import { initInsights } from './sections/insights.js';
 * - import { initContact } from './sections/contact.js';
 */

import { initHeader } from './header.js';
import { initAnimations } from './animations.js';

// Initialize header immediately (no need to wait for full DOM)
initHeader();

// Initialize animations after DOM is fully parsed
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initAnimations);
} else {
  // DOMContentLoaded already fired
  initAnimations();
}

// Update footer year dynamically
const yearEl = document.getElementById('footer-year');
if (yearEl) {
  yearEl.textContent = new Date().getFullYear();
}

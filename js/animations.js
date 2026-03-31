/**
 * animations.js
 * Animations for FN Mining Advisor.
 *
 * Architecture:
 * - IntersectionObserver handles ALL scroll-reveal (.fade-in) — reliable, no CDN required
 * - GSAP handles the hero entrance timeline only (no ScrollTrigger dependency)
 * - If GSAP is unavailable, hero elements are made visible immediately via CSS
 */

export function initAnimations() {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ----------------------------------------------------------------
  // SCROLL REVEAL — IntersectionObserver for all .fade-in elements
  // This runs unconditionally, regardless of GSAP availability.
  // ----------------------------------------------------------------
  if (prefersReducedMotion) {
    // Skip animations entirely — show everything immediately
    document.querySelectorAll('.fade-in').forEach((el) => el.classList.add('is-visible'));
  } else {
    initScrollReveal();
  }

  // ----------------------------------------------------------------
  // HERO entrance — GSAP timeline (no ScrollTrigger, no CDN risk)
  // ----------------------------------------------------------------
  if (!prefersReducedMotion && typeof gsap !== 'undefined') {
    initHeroTimeline();
  } else {
    // Make hero elements visible without animation
    makeHeroVisible();
  }
}

// ----------------------------------------------------------------
// IntersectionObserver scroll reveal
// ----------------------------------------------------------------
function initScrollReveal() {
  if (!('IntersectionObserver' in window)) {
    // No IO support — show everything
    document.querySelectorAll('.fade-in').forEach((el) => el.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
  );

  document.querySelectorAll('.fade-in').forEach((el) => observer.observe(el));
}

// ----------------------------------------------------------------
// Hero entrance via GSAP timeline (fires on page load, no scroll needed)
// ----------------------------------------------------------------
function initHeroTimeline() {
  const tl = gsap.timeline({
    defaults: { ease: 'power2.out', duration: 0.75 },
    delay: 0.15,
    onComplete: makeHeroVisible, // safety: ensure elements are visible after timeline
  });

  tl.from('.hero__heading',       { y: 40, opacity: 0 }, 0)
    .from('.hero__pain-points li', { y: 20, opacity: 0, stagger: 0.14 }, '-=0.4')
    .from('.hero__ctas .btn',      { y: 16, opacity: 0, stagger: 0.10 }, '-=0.3')
    .from('.hero__trayectoria',    { opacity: 0, duration: 0.5 }, '-=0.15')
    .from('.hero__scroll-indicator', { opacity: 0, y: -8, duration: 0.4 }, '-=0.1');
}

// ----------------------------------------------------------------
// Ensure hero elements are visible (fallback / post-animation)
// ----------------------------------------------------------------
function makeHeroVisible() {
  const heroSelectors = [
    '.hero__heading',
    '.hero__pain-points li',
    '.hero__ctas .btn',
    '.hero__trayectoria',
    '.hero__scroll-indicator',
  ];
  heroSelectors.forEach((sel) => {
    document.querySelectorAll(sel).forEach((el) => {
      el.style.opacity = '';
      el.style.visibility = '';
      el.style.transform = '';
    });
  });
}

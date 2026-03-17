/**
 * animations.js
 * Adds scroll-triggered fade-in animations using IntersectionObserver.
 *
 * Target: all elements with class .fade-in
 * Trigger: element reaches 15% visibility (threshold: 0.15)
 * Effect: CSS transition defined in utilities.css (.fade-in.is-visible)
 *
 * No external libraries. Gracefully skips if IntersectionObserver unavailable.
 * Respects prefers-reduced-motion (CSS handles this via media query in base.css).
 */

export function initAnimations() {
  if (!('IntersectionObserver' in window)) {
    // Fallback: make all fade-in elements immediately visible
    document.querySelectorAll('.fade-in').forEach((el) => {
      el.classList.add('is-visible');
    });
    return;
  }

  const fadeObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          // Once visible, stop observing — no need to reverse the animation
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.15,
      rootMargin: '0px 0px -48px 0px' // Trigger 48px before element fully enters viewport
    }
  );

  // Observe all fade-in elements that exist at init time
  document.querySelectorAll('.fade-in').forEach((el) => {
    fadeObserver.observe(el);
  });
}

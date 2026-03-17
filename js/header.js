/**
 * header.js
 * Handles:
 * 1. Header solidification when user scrolls past the hero section
 * 2. Mobile navigation overlay open/close
 *
 * Uses IntersectionObserver for header solidification (more performant than scroll event).
 * Falls back gracefully if IntersectionObserver is not available (old browsers).
 */

export function initHeader() {
  const header = document.getElementById('site-header');
  const hero = document.getElementById('hero');
  const navToggle = document.getElementById('nav-toggle');
  const navClose = document.getElementById('nav-close');
  const mobileNav = document.getElementById('mobile-nav');
  const mobileNavLinks = mobileNav ? mobileNav.querySelectorAll('.mobile-nav__link') : [];

  if (!header) return; // Guard: header must exist

  // ---------------------------------------------------------------
  // 1. Header solidification via IntersectionObserver on hero section
  // When hero exits the viewport (isIntersecting = false), add .header--scrolled
  // ---------------------------------------------------------------
  if (hero && 'IntersectionObserver' in window) {
    const heroObserver = new IntersectionObserver(
      (entries) => {
        const [entry] = entries;
        if (entry.isIntersecting) {
          // Hero is visible — transparent header
          header.classList.remove('header--scrolled');
        } else {
          // Hero has left viewport — solidify header
          header.classList.add('header--scrolled');
        }
      },
      {
        threshold: 0,
        rootMargin: `-${header.offsetHeight}px 0px 0px 0px` // Trigger at header height
      }
    );
    heroObserver.observe(hero);
  } else {
    // Fallback: use scroll event for older browsers or if hero is missing
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        header.classList.add('header--scrolled');
      } else {
        header.classList.remove('header--scrolled');
      }
    }, { passive: true });
  }

  // ---------------------------------------------------------------
  // 2. Mobile nav — open
  // ---------------------------------------------------------------
  function openNav() {
    if (!mobileNav) return;
    mobileNav.classList.add('nav--open');
    mobileNav.removeAttribute('aria-hidden');
    navToggle.setAttribute('aria-expanded', 'true');
    navToggle.setAttribute('aria-label', 'Cerrar menú');
    // Trap focus inside overlay
    document.body.style.overflow = 'hidden';
    // Move focus to close button
    if (navClose) navClose.focus();
  }

  // ---------------------------------------------------------------
  // 3. Mobile nav — close
  // ---------------------------------------------------------------
  function closeNav() {
    if (!mobileNav) return;
    mobileNav.classList.remove('nav--open');
    mobileNav.setAttribute('aria-hidden', 'true');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.setAttribute('aria-label', 'Abrir menú');
    document.body.style.overflow = '';
    // Return focus to hamburger
    if (navToggle) navToggle.focus();
  }

  // Hamburger button opens nav
  if (navToggle) {
    navToggle.addEventListener('click', openNav);
  }

  // Close button closes nav
  if (navClose) {
    navClose.addEventListener('click', closeNav);
  }

  // Nav links close overlay and let scroll-behavior handle the rest
  mobileNavLinks.forEach((link) => {
    link.addEventListener('click', () => {
      closeNav();
    });
  });

  // Close overlay on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('nav--open')) {
      closeNav();
    }
  });

  // Close overlay if user clicks the dark backdrop (outside nav content)
  if (mobileNav) {
    mobileNav.addEventListener('click', (e) => {
      if (e.target === mobileNav) {
        closeNav();
      }
    });
  }
}

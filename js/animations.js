/**
 * animations.js
 * Scroll-triggered and load animations using GSAP + ScrollTrigger.
 *
 * GSAP and ScrollTrigger are loaded as globals via CDN in index.html.
 * Falls back to the CSS .fade-in / .is-visible system if GSAP is unavailable.
 * Respects prefers-reduced-motion via gsap.matchMedia().
 */

export function initAnimations() {
  // Fallback: CSS .fade-in / .is-visible system (IntersectionObserver)
  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    initCssFallback();
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  // Mark all .fade-in elements visible so CSS opacity doesn't conflict with GSAP
  document.querySelectorAll('.fade-in').forEach((el) => el.classList.add('is-visible'));

  const mm = gsap.matchMedia();

  mm.add(
    {
      reduceMotion: '(prefers-reduced-motion: reduce)',
      noReduceMotion: '(prefers-reduced-motion: no-preference)',
    },
    (context) => {
      const { reduceMotion } = context.conditions;

      if (reduceMotion) {
        // No motion — elements are already visible via is-visible above
        return;
      }

      // ----------------------------------------------------------------
      // HERO — timeline on page load (no ScrollTrigger)
      // ----------------------------------------------------------------
      const heroTl = gsap.timeline({
        defaults: { ease: 'power2.out', duration: 0.75 },
        delay: 0.1,
      });

      heroTl
        .from('.hero__heading', { y: 44, autoAlpha: 0 })
        .from(
          '.hero__pain-points li',
          { y: 24, autoAlpha: 0, stagger: 0.16 },
          '-=0.4'
        )
        .from(
          '.hero__ctas .btn',
          { y: 20, autoAlpha: 0, stagger: 0.12 },
          '-=0.3'
        )
        .from('.hero__trayectoria', { autoAlpha: 0, duration: 0.5 }, '-=0.15')
        .from(
          '.hero__scroll-indicator',
          { autoAlpha: 0, y: -8, duration: 0.4 },
          '-=0.1'
        );

      // ----------------------------------------------------------------
      // SECTION HEADERS — slide up on scroll
      // ----------------------------------------------------------------
      gsap.utils.toArray('.section-header').forEach((header) => {
        gsap.from(header, {
          y: 36,
          autoAlpha: 0,
          duration: 0.8,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: header,
            start: 'top 88%',
            once: true,
          },
        });
      });

      // ----------------------------------------------------------------
      // TRUST PILLARS (propuesta de valor)
      // ----------------------------------------------------------------
      gsap.from('.trust-pillar', {
        y: 32,
        autoAlpha: 0,
        duration: 0.65,
        stagger: 0.14,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.valor-section__grid',
          start: 'top 82%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // SERVICE CARDS — scale + fade, stagger
      // ----------------------------------------------------------------
      gsap.from('.service-card', {
        y: 40,
        autoAlpha: 0,
        scale: 0.97,
        duration: 0.65,
        stagger: 0.12,
        ease: 'power2.out',
        transformOrigin: 'center bottom',
        scrollTrigger: {
          trigger: '.servicios-section__grid',
          start: 'top 82%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // INNOVACIÓN ITEMS
      // ----------------------------------------------------------------
      gsap.from('.innovacion-item', {
        y: 28,
        autoAlpha: 0,
        duration: 0.65,
        stagger: 0.12,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.innovacion-section__grid',
          start: 'top 82%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // METHODOLOGY STEPS — slide from left, stagger
      // ----------------------------------------------------------------
      gsap.from('.methodology-step', {
        x: -36,
        autoAlpha: 0,
        duration: 0.65,
        stagger: 0.14,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.metodologia-section__steps',
          start: 'top 82%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // EXPERIENCIA — profile + editorial split
      // ----------------------------------------------------------------
      gsap.from('.experiencia-section__profile', {
        x: -48,
        autoAlpha: 0,
        duration: 0.85,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.experiencia-section__content',
          start: 'top 82%',
          once: true,
        },
      });

      gsap.from('.experiencia-section__editorial', {
        x: 48,
        autoAlpha: 0,
        duration: 0.85,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.experiencia-section__content',
          start: 'top 82%',
          once: true,
        },
      });

      // Stats count-up for numeric hito values (e.g. "+40")
      document.querySelectorAll('.experiencia-hito__value').forEach((el) => {
        const raw = el.textContent.trim();
        const match = raw.match(/^\+?(\d+)$/);
        if (!match) return;

        const target = parseInt(match[1], 10);
        const hasPlus = raw.startsWith('+');
        const proxy = { val: 0 };

        gsap.to(proxy, {
          val: target,
          duration: 1.6,
          ease: 'power1.out',
          snap: { val: 1 },
          onUpdate() {
            el.textContent = (hasPlus ? '+' : '') + Math.round(proxy.val);
          },
          scrollTrigger: {
            trigger: el,
            start: 'top 88%',
            once: true,
          },
        });
      });

      // Hito boxes stagger
      gsap.from('.experiencia-hito', {
        y: 20,
        autoAlpha: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.experiencia-section__hitos',
          start: 'top 86%',
          once: true,
        },
      });

      // Gallery items
      gsap.from('.experiencia-galeria__item', {
        y: 36,
        autoAlpha: 0,
        duration: 0.7,
        stagger: 0.14,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.experiencia-section__galeria',
          start: 'top 85%',
          once: true,
        },
      });

      // LinkedIn button
      gsap.from('.experiencia-section__linkedin', {
        y: 16,
        autoAlpha: 0,
        duration: 0.5,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.experiencia-section__linkedin',
          start: 'top 90%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // CTA FINAL — slide up
      // ----------------------------------------------------------------
      gsap.from('.cta-final-section__content', {
        y: 32,
        autoAlpha: 0,
        duration: 0.75,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.cta-final-section',
          start: 'top 85%',
          once: true,
        },
      });

      // ----------------------------------------------------------------
      // CONTACTO — form wrapper + info block
      // ----------------------------------------------------------------
      gsap.from('.contacto-section__form-wrapper', {
        x: -36,
        autoAlpha: 0,
        duration: 0.75,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.contacto-section__layout',
          start: 'top 82%',
          once: true,
        },
      });

      gsap.from('.contacto-section__info', {
        x: 36,
        autoAlpha: 0,
        duration: 0.75,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: '.contacto-section__layout',
          start: 'top 82%',
          once: true,
        },
      });
    }
  );
}

// ----------------------------------------------------------------
// CSS fallback — IntersectionObserver (no GSAP)
// ----------------------------------------------------------------
function initCssFallback() {
  if (!('IntersectionObserver' in window)) {
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
    { threshold: 0.15, rootMargin: '0px 0px -48px 0px' }
  );

  document.querySelectorAll('.fade-in').forEach((el) => observer.observe(el));
}

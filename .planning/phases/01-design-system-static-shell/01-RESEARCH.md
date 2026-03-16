# Phase 1: Design System + Static Shell - Research

**Researched:** 2026-03-16
**Domain:** Vanilla HTML/CSS/JS static shell with CSS design tokens — no build tool, no framework
**Confidence:** HIGH

---

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions

**Hero visual:**
- Fondo: Gradiente CSS de carbono (#15181C) a gris acero oscuro (#2A3038) — sin imagen real por ahora. Preparar estructura `<figure>` o CSS `background-image` para reemplazo con una sola línea CSS.
- Layout del texto: Centrado, con línea de acento dorada bajo el H1 (border-bottom en `::after` del heading o elemento separador explícito)
- Elementos: H1 (headline principal) + párrafo subheadline técnico-comercial + 2 CTAs en fila horizontal (primario dorado, secundario ghost/outline) + frase de trayectoria bajo los CTAs (ej. "+20 años de experiencia en minería de oro y cobre, Chile y Latinoamérica")
- Altura: 100vh en desktop; min-height adaptativo en mobile para que el contenido no quede cortado
- Scroll indicator: Flecha o chevron animado sutil en la parte inferior del hero invitando al scroll
- Sin stats/cifras en el hero — solo la frase de trayectoria breve

**Ritmo de color entre secciones:**
- Secciones oscuras (carbono #15181C o variante): Hero, Innovación/Sustentabilidad, Metodología, CTA Final
- Secciones claras alternando: Propuesta de Valor (#F5F5F2), Servicios (#E9ECEF), Experiencia (#F5F5F2), Insights (#E9ECEF), Contacto (#F5F5F2)
- Dorado mineral (#B88A3B): línea decorativa bajo H2, fondo botones CTA primarios (texto carbono), números de metodología, border-left de pilares de confianza

**Densidad y layout de servicios:**
- Grid 2×2 desktop, 2 columnas tablet, 1 columna mobile
- Contenido de card: icono SVG lineal + H3 + descripción 2-3 líneas + "Foco:" etiqueta con bullets
- Sin CTA individual en cada card
- Estilo: borde 1px #E9ECEF + box-shadow sutil + fondo blanco + padding generoso
- Hover: translateY(-2px) + sombra pronunciada + borde superior dorado en hover

**Header y navegación:**
- Scroll behavior: transparente sobre hero → sólido (carbono + sombra) al superar altura del hero. Detectado con IntersectionObserver o scroll event listener.
- Logo tipográfico CSS: "FN" (Cormorant Garamond semi-bold, dorado #B88A3B) + " Mining Advisor" (Inter light/regular, blanco)
- Nav desktop: Servicios, Metodología, Experiencia, Contacto + botón "Solicitar diagnóstico" (primario dorado) a la derecha
- Nav mobile: hamburger → overlay full-screen carbono, links grandes centrados (Cormorant Garamond 24px+), botón CTA, cierre (X). Animación fade-in.

**Stack constraints (PROJECT.md/STACK.md):**
- HTML semántico + CSS puro con custom properties + vanilla JS ES modules
- Sin build tool (no Vite/Webpack) — archivos servidos directamente
- Sin frameworks JS (no React/Vue/Angular)
- BEM para nomenclatura de componentes

**Paleta exacta:**
- Carbono: `#15181C`
- Gris acero oscuro (hero gradiente): `#2A3038`
- Gris acero: `#5E6873`
- Blanco cálido: `#F5F5F2`
- Dorado mineral: `#B88A3B`
- Dorado claro: `#D6B15A`
- Verde petróleo: `#1F4D4A` (reservado, no se usa en Fase 1)
- Gris claro: `#E9ECEF`

**Tipografías:**
- Headings: Cormorant Garamond (Google Fonts) — Regular 400, SemiBold 600
- Body/UI: Inter (Google Fonts) — Regular 400, Medium 500 (o SemiBold 600 según UI-SPEC)
- Carga: `font-display: swap` obligatorio

### Claude's Discretion

- Tipografías específicas: `font-size` exactos de la escala tipográfica — Claude elige dentro del sistema Cormorant + Inter (UI-SPEC ya los define)
- Iconos SVG de servicios — Claude elige iconos técnicos lineales apropiados (puede usar Heroicons, Phosphor Icons, o SVGs inline)
- Copy placeholder específico — Claude genera textos placeholder profesionales en español con terminología minera/metalúrgica real (flotación, conminución, NI 43-101, recuperación metalúrgica, etc.)
- Espaciado preciso entre secciones — Claude usa `padding-block` generoso (80-120px desktop, 60px mobile) de forma consistente
- Scroll indicator animation del hero — Claude elige implementación (CSS animation pura)
- Comportamiento exacto del footer — estructura y contenido

### Deferred Ideas (OUT OF SCOPE)

- Animación de número/cifras (counter animation en stats) — se defiere a Fase 4 cuando haya datos reales
- Video background en hero — se defiere hasta que el cliente provea asset de video
- Versión dark/light mode toggle — fuera de scope
- CTAs individuales por servicio en las cards — se incluyeron en REQUIREMENTS pero se decidió NO incluirlos en las cards de Fase 1
</user_constraints>

---

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|-----------------|
| DSYS-01 | CSS custom properties define paleta completa, tipografías, spacing, border-radius, sombras | CSS custom properties on `:root` pattern; exact tokens defined in UI-SPEC and CONTEXT.md |
| DSYS-02 | Tokens flexibles para cambio de nombre (FN → NMC) sin reescribir CSS de layout/componentes | Token architecture: `--color-gold-500`, `--font-display`, etc. — one file change propagates everywhere |
| DSYS-03 | Biblioteca de componentes base documentada: botones, cards, badges, inputs, sección-header, dividers | BEM components documented in UI-SPEC: `.btn`, `.service-card`, `.section-header`, `.methodology-step`, `.trust-pillar` |
| SHEL-01 | Estructura HTML semántica completa con 9 secciones en orden | Progressive enhancement pattern: all 9 section wrappers with static HTML content baked in |
| SHEL-02 | Cada sección con contenido estático HTML hardcodeado como fallback | All content present in HTML before JS runs — progressive enhancement baseline |
| SHEL-03 | Header sticky con logo, navegación anchor links, botón CTA | Sticky header via `position: sticky` + scroll behavior via IntersectionObserver; logo as CSS typographic treatment |
| SHEL-04 | Footer con datos de contacto, links de secciones, nota legal | Footer structure; links to section anchors; contact details placeholder |
| UX-01 | Animaciones fade-in al scroll vía Intersection Observer API — sin librerías externas | `IntersectionObserver` threshold 0.15; adds `.is-visible` class; CSS `opacity: 0→1` + `translateY(16px→0)` |
| UX-02 | Hover sutil en cards y botones (transform scale, color transition) — sin animaciones extravagantes | CSS `:hover` pseudo-class only; `transition: all 0.25s ease` on all interactive elements |
| UX-03 | Navegación anchor con scroll suave y offset para header sticky | `scroll-behavior: smooth` on `html`; `scroll-margin-top: 72px` on each section |
| SECT-01 | Sección Servicios con 4 cards: Valorización, Optimización, Clínica Metalúrgica, Capacitación | `.service-card` BEM component; 2×2 grid desktop → 1 col mobile; no individual CTAs on cards |
| SECT-02 | Bloque Propuesta de Valor con 4 pilares visuales | `.trust-pillar` BEM component with `border-left: 3px solid --color-gold-500` |
| SECT-03 | Bloque Innovación y Sustentabilidad con 4 subpuntos técnicos | Dark section (#15181C bg); 4 technical points; no green clichés |
| SECT-04 | Sección Metodología con 5 pasos secuenciales | `.methodology-step` with large gold numerals (01–05, Cormorant 56px); NDA first |
| SECT-05 | Sección Experiencia Profesional — editorial elegante, sin cifras aún | Light section (#F5F5F2); editorial block; placeholder for future stats |
| SECT-06 | Sección Insights preparada para artículos futuros | Static placeholder cards + "Próximamente" empty state; structure ready for Phase 4 hydration |
| SECT-07 | CTA Final con mensaje de conversión, CTA formulario + CTA WhatsApp | Dark section (#15181C); "Solicitar diagnóstico inicial" + WhatsApp link |
| CONT-02 | Nota de confidencialidad visible junto al formulario | Static HTML text: "Sus datos y consulta son tratados con estricta confidencialidad" |
| CONT-03 | Botón/enlace de WhatsApp en sección CTA Final y contacto | `<a href="https://wa.me/56XXXXXXXXX">` link; styled as secondary CTA |
| CONT-04 | Email de contacto directo visible en la sección de contacto | Static `<a href="mailto:...">` in contact section |
| CONT-05 | Enlace a perfil LinkedIn del consultor en footer y/o experiencia | Static `<a href="https://linkedin.com/in/...">` link |
| RESP-01 | Layout responsive funcional en mobile (320px+), tablet (768px+), desktop (1024px+) | Mobile-first CSS with `min-width` breakpoints: 768px, 1024px; `--container-max: 1200px` |
| RESP-02 | Menú de navegación mobile con hamburger menu — accesible, sin JS externo | Vanilla JS class toggle; full-screen overlay; `aria-label` toggle on hamburger |
| RESP-03 | Cards de servicios: grid multi-columna → columna única en mobile | CSS Grid with responsive `grid-template-columns`: 1 col → 2 col (768px+) |
| RESP-04 | Formulario de contacto 100% usable en mobile | Full-width inputs; `min-height: 44px` on inputs; proper `type` attributes |
| SCAL-01 | Estructura de directorios preparada: `/pages/blog/`, `/pages/casos-de-exito/`, `/pages/capacitaciones/` | Directory scaffolding with index.html placeholders in each |
| SCAL-02 | HTML usa `<article>` y `<section>` con IDs semánticos como anchor links | Section IDs: `#hero`, `#valor`, `#servicios`, `#innovacion`, `#metodologia`, `#experiencia`, `#insights`, `#contacto` |
| SCAL-03 | Logo con variable CSS `--logo-src` y versiones previstas; espacio reservado en header | `.site-logo` class on logo element; CSS `var(--logo-text)` and `var(--logo-accent)` for typographic treatment |
</phase_requirements>

---

## Summary

Phase 1 is a pure frontend construction phase with no API or CMS dependencies. The goal is a complete, navigable, visually polished landing page where every section is readable with JavaScript disabled. The technical domain is well-established: CSS custom properties for design tokens, BEM for component naming, semantic HTML5 structure, and vanilla JS for scroll animations and mobile navigation — all without a build tool.

The project has comprehensive prior research in `.planning/research/` covering the full stack, architecture, and pitfalls. The SUMMARY.md notes Phase 1 uses "standard patterns" (CSS custom properties, BEM, IntersectionObserver) that are thoroughly documented. This phase research consolidates those findings into a precise, actionable reference specifically scoped to what the Phase 1 planner needs: design tokens, component contracts, file structure, and implementation patterns for the 9 sections with no API layer.

The critical constraints for this phase are: (1) design tokens MUST be locked in `css/tokens.css` before any section HTML is written — drifting from the graphite/gold palette is the highest-cost recovery; (2) every section MUST include real static copy in the HTML as the progressive enhancement baseline; (3) the JS layer (scroll animations, header behavior, mobile nav) MUST use only native browser APIs — no external libraries. The UI-SPEC file at `.planning/phases/01-design-system-static-shell/01-UI-SPEC.md` is the canonical visual contract and must be read by the planner before assigning any implementation tasks.

**Primary recommendation:** Build in this order — `tokens.css` first, then `base.css` + `layout.css`, then the index.html shell with all 9 sections and real static copy, then section-specific CSS files, then the JS modules (header, animations). This ordering prevents visual drift and ensures the progressive enhancement baseline is always present.

---

## Standard Stack

### Core

| Library / Technology | Version | Purpose | Why Standard |
|----------------------|---------|---------|--------------|
| HTML5 semantic elements | Native | Shell structure — `<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>` | Browser-native; SEO-correct; progressive enhancement baseline |
| CSS Custom Properties | Native (all modern browsers) | Design tokens — colors, typography scale, spacing, shadows | Zero dependency; enables brand rename (FN → NMC) via one file; no build step needed |
| CSS Grid + Flexbox | Native | Layout — services grid, section containers, nav bar | Modern, well-supported; no framework needed for this scale |
| Vanilla JS ES Modules | ES2022, `type="module"` | Header scroll behavior, mobile nav, IntersectionObserver | Natively supported since Chrome 61+, Firefox 60+, Safari 10.1+; no bundler needed |
| IntersectionObserver API | Native | Scroll-triggered fade-in animations | Built into all modern browsers since 2018; zero external libraries |
| Google Fonts | Latest | Cormorant Garamond + Inter | Established CDN; `font-display: swap` required on `<link>` tag |

### Supporting

| Technology | Purpose | When to Use |
|------------|---------|-------------|
| CSS `clamp()` | Fluid typography — `clamp(40px, 5vw, 64px)` for H1 | All heading sizes and section padding — removes breakpoint boilerplate |
| CSS `scroll-behavior: smooth` | Anchor link smooth scrolling | On `html` element; combined with `scroll-margin-top` on sections |
| `scroll-margin-top` | Offset anchor scroll for sticky header | On every `<section>` element; value = sticky header height (72px) |
| `position: sticky` | Sticky header | On `<header>` element; no JS required for sticking behavior |
| CSS `@keyframes` | Hero scroll indicator bounce animation | Pure CSS; no JS required for the chevron animation |
| Python `http.server` or `npx serve` | Local development server | ES modules require HTTP server (not `file://`); zero-install options |

### Alternatives Considered

| Instead of | Could Use | Tradeoff |
|------------|-----------|----------|
| CSS Custom Properties | Sass variables | Sass requires a build step; CSS variables are runtime-accessible from JS; no benefit for this project |
| Inline/embedded SVG icons | Icon font (Font Awesome) | Icon fonts add network payload, flash of invisible text, and styling complexity; inline SVG is zero-dependency |
| Vanilla JS ES modules | TypeScript | TypeScript requires a build step and adds type definitions; no benefit for a <500 LOC JS layer |
| `IntersectionObserver` | Scroll event listener | Scroll events fire on every pixel; IntersectionObserver is callback-based and performant |
| Google Fonts CDN | Self-hosted fonts | Self-hosting improves privacy and eliminates external dependency; trade-off is more setup; Google Fonts acceptable for v1 |

**Installation:** No npm install required. Local dev:
```bash
python3 -m http.server 8080
# OR
npx serve .
```

---

## Architecture Patterns

### Recommended Project Structure

```
/                              (project root)
├── index.html                 (shell — all 9 sections with static copy)
├── css/
│   ├── tokens.css             (CSS custom properties — FIRST file to build)
│   ├── base.css               (reset + typography base + font-face declarations)
│   ├── layout.css             (header, footer, container, section grid)
│   └── sections/
│       ├── hero.css
│       ├── valor.css
│       ├── servicios.css
│       ├── innovacion.css
│       ├── metodologia.css
│       ├── experiencia.css
│       ├── insights.css
│       ├── cta-final.css
│       └── contacto.css
├── js/
│   ├── main.js                (entry point — type="module"; imports all modules)
│   ├── header.js              (scroll behavior: transparent → solid; mobile nav)
│   └── animations.js         (IntersectionObserver fade-in)
├── assets/
│   ├── icons/                 (SVG service icons — inline or referenced)
│   └── images/               (placeholder logo; future hero image)
└── pages/
    ├── blog/
    │   └── index.html         (placeholder scaffold)
    ├── casos-de-exito/
    │   └── index.html         (placeholder scaffold)
    └── capacitaciones/
        └── index.html         (placeholder scaffold)
```

### Section ID Map (anchor targets)

| Section | HTML ID | Background | Phase 4 Hydration Target |
|---------|---------|------------|--------------------------|
| Hero | `#hero` | `linear-gradient(135deg, #15181C 0%, #2A3038 100%)` | Yes — headline, subheadline, CTAs |
| Propuesta de Valor | `#valor` | `#F5F5F2` | Yes — 4 pilares |
| Servicios | `#servicios` | `#E9ECEF` | Yes — 4 service cards |
| Innovación/Sustentabilidad | `#innovacion` | `#15181C` | Yes — 4 points |
| Metodología | `#metodologia` | `#15181C` | Yes — 5 steps |
| Experiencia Profesional | `#experiencia` | `#F5F5F2` | Yes — editorial text |
| Insights/Contenido | `#insights` | `#E9ECEF` | Yes — CPT articles |
| CTA Final | `#cta-final` | `#15181C` | Yes — CTA text |
| Contacto | `#contacto` | `#F5F5F2` | No (form is Phase 4) |

### Pattern 1: CSS Token Architecture

**What:** All brand values defined once in `tokens.css` as CSS custom properties on `:root`. All other CSS files reference tokens, never hardcoded values.

**When to use:** Always — must be the first CSS file built. No section CSS is written before tokens are complete.

**Example:**
```css
/* css/tokens.css — Source: UI-SPEC.md + CONTEXT.md canonical refs */
:root {
  /* Dark surfaces */
  --color-carbon:        #15181C;
  --color-steel-dark:    #2A3038;
  --color-steel-mid:     #5E6873;

  /* Light surfaces */
  --color-warm-white:    #F5F5F2;
  --color-light-gray:    #E9ECEF;

  /* Accent */
  --color-gold-500:      #B88A3B;
  --color-gold-300:      #D6B15A;

  /* Semantic */
  --color-petroleum:     #1F4D4A;
  --color-white:         #FFFFFF;

  /* Typography */
  --font-display:        'Cormorant Garamond', Georgia, serif;
  --font-body:           'Inter', system-ui, sans-serif;

  /* Type scale */
  --text-hero:           clamp(2.5rem, 5vw, 4rem);    /* 40px–64px */
  --text-heading:        clamp(1.75rem, 3vw, 2.5rem); /* 28px–40px */
  --text-body:           1rem;                         /* 16px */
  --text-label:          0.875rem;                     /* 14px */

  /* Spacing */
  --space-xs:            0.25rem;   /* 4px */
  --space-sm:            0.5rem;    /* 8px */
  --space-md:            1rem;      /* 16px */
  --space-lg:            1.5rem;    /* 24px */
  --space-xl:            2rem;      /* 32px */
  --space-2xl:           3rem;      /* 48px */
  --space-3xl:           4rem;      /* 64px */
  --space-section-mobile: 4rem;     /* 64px padding-block on sections <768px */
  --space-section-desktop: 6rem;   /* 96px padding-block on sections >=1024px */

  /* Layout */
  --container-max:       75rem;     /* 1200px */
  --container-padding:   clamp(1rem, 4vw, 2rem);
  --header-height:       4.5rem;    /* 72px — used for scroll-margin-top */

  /* Effects */
  --shadow-card:         0 2px 8px rgba(0, 0, 0, 0.06);
  --shadow-card-hover:   0 6px 20px rgba(0, 0, 0, 0.10);
  --shadow-header:       0 2px 12px rgba(0, 0, 0, 0.40);
  --radius-sm:           2px;
  --radius-md:           4px;
  --transition-default:  all 0.25s ease;
  --transition-header:   background 0.3s ease, box-shadow 0.3s ease;

  /* Brand naming (DSYS-02 — change FN → NMC here only) */
  --logo-accent:         var(--color-gold-500);
  --logo-text:           var(--color-white);
  --brand-initials:      'FN';
}
```

### Pattern 2: Progressive Enhancement Shell

**What:** `index.html` ships with all section content as static HTML (real Spanish placeholder copy, not "Lorem ipsum"). JS enhances or replaces content from WP in Phase 4. If JS is disabled, the page is fully readable.

**When to use:** Every section. Non-negotiable for this project.

**Example:**
```html
<!-- index.html — static fallback always present -->
<section id="hero" class="hero" aria-label="Hero">
  <div class="hero__inner container">
    <h1 class="hero__headline">Criterio técnico senior para decisiones mineras críticas</h1>
    <p class="hero__sub">Consultoría especializada en valorización de propiedades, optimización metalúrgica y gestión de proyectos mineros en Chile y Latinoamérica.</p>
    <div class="hero__ctas">
      <a href="#contacto" class="btn btn--primary">Solicitar diagnóstico</a>
      <a href="#servicios" class="btn btn--ghost">Ver servicios</a>
    </div>
    <p class="hero__tagline">+20 años de experiencia en minería de oro y cobre, Chile y Latinoamérica</p>
  </div>
  <div class="hero__scroll-indicator" aria-hidden="true">
    <span class="hero__chevron"></span>
  </div>
</section>
```

### Pattern 3: IntersectionObserver Fade-in

**What:** A single `animations.js` module adds `.is-visible` class to any element with `data-animate` attribute when it enters the viewport. CSS handles the transition.

**When to use:** All sections, cards, and pillar elements.

**Example:**
```javascript
// js/animations.js
export function initScrollAnimations() {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target); // animate once only
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
}
```

```css
/* In base.css or animations section */
[data-animate] {
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.5s ease, transform 0.5s ease;
}
[data-animate].is-visible {
  opacity: 1;
  transform: translateY(0);
}
```

### Pattern 4: Header Scroll Behavior

**What:** `header.js` uses `IntersectionObserver` on the hero section to detect when the user scrolls past it. On exit, adds `.header--solid` class to the header. CSS handles the visual transition.

**When to use:** The sticky header.

**Example:**
```javascript
// js/header.js
export function initHeader() {
  const header = document.querySelector('.site-header');
  const hero = document.querySelector('#hero');

  // Scroll solidify behavior
  const heroObserver = new IntersectionObserver(([entry]) => {
    header.classList.toggle('header--solid', !entry.isIntersecting);
  }, { threshold: 0 });
  heroObserver.observe(hero);

  // Mobile nav toggle
  const hamburger = document.querySelector('.nav__hamburger');
  const overlay = document.querySelector('.nav__overlay');

  hamburger.addEventListener('click', () => {
    const isOpen = overlay.classList.toggle('nav--open');
    hamburger.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
    hamburger.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
  });

  // Close overlay on link click
  overlay.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      overlay.classList.remove('nav--open');
      hamburger.setAttribute('aria-label', 'Abrir menú');
      hamburger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    });
  });
}
```

```css
/* css/layout.css */
.site-header {
  position: sticky;
  top: 0;
  z-index: 100;
  background: transparent;
  transition: var(--transition-header);
}
.site-header.header--solid {
  background: var(--color-carbon);
  box-shadow: var(--shadow-header);
}
```

### Pattern 5: BEM Component Structure

**What:** CSS classes follow Block__Element--Modifier convention. JS adds/removes modifier classes only — never touches inline styles except for dynamic values (image URLs).

**When to use:** All component CSS.

**Example — Service Card:**
```html
<article class="service-card" data-animate>
  <div class="service-card__icon" aria-hidden="true">
    <!-- SVG icon inline -->
  </div>
  <h3 class="service-card__title">Valorización y Desarrollo de Propiedades Mineras</h3>
  <p class="service-card__description">Evaluación técnica integral para proyectos greenfield y brownfield, aplicando estándares NI 43-101 y JORC para informes de recursos y reservas.</p>
  <p class="service-card__focus"><span class="service-card__focus-label">Foco:</span> Evaluación técnica · Diagnóstico de pertenencias · Valorización</p>
</article>
```

```css
/* css/sections/servicios.css */
.service-card {
  background: var(--color-white);
  border: 1px solid var(--color-light-gray);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-card);
  padding: var(--space-xl);
  transition: var(--transition-default);
}
.service-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-card-hover);
  border-top: 2px solid var(--color-gold-500);
}
```

### Anti-Patterns to Avoid

- **Hardcoded color values in section CSS:** `color: #B88A3B` instead of `color: var(--color-gold-500)`. Breaks DSYS-02 (brand rename).
- **Sections with no static HTML content:** Any section whose only content comes from JS/API leaves the page blank with JS disabled — violates SHEL-02.
- **Using scroll event listener for header:** Fires on every pixel of scroll; IntersectionObserver is the performant alternative for this pattern.
- **External animation libraries:** Any `animate.css`, AOS, GSAP, or similar — violates UX-01 constraint.
- **Global `overflow: hidden` on body without cleanup:** Set when mobile nav opens; must be cleared when nav closes, otherwise page scrolling breaks.
- **Anchor scroll without `scroll-margin-top`:** Sticky header occludes the section heading. Always set `scroll-margin-top: var(--header-height)` on sections.
- **Implementing JavaScript before CSS tokens are finalized:** Any JS-toggled class names that depend on CSS variables must have those variables defined first.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Fluid typography | Manual breakpoint overrides for each font size | CSS `clamp()` | `clamp(min, preferred, max)` is one line, no media queries needed |
| Section scroll offset for sticky header | JS scroll position calculation | CSS `scroll-margin-top` on sections | Declarative, updates automatically if header height changes |
| Body scroll lock (mobile nav) | Complex scroll position save/restore | `document.body.style.overflow = 'hidden'` + cleanup | Standard minimal approach; no library needed for this use case |
| Viewport height for hero on mobile | `100vh` (clips on mobile browsers with address bar) | `min-height: 100svh` (small viewport height) with fallback `min-height: 100vh` | `svh` accounts for mobile browser chrome; widely supported in 2025+ |
| Font loading performance | No control | `font-display: swap` in `<link rel="preload">` or Google Fonts URL param `&display=swap` | Prevents invisible text flash; required by REQUIREMENTS.md SEO-04 |
| CSS reset | Full custom reset | Modern reset targeting box-sizing, margin, padding, lists | A minimal 20-line reset is correct here; do not use Normalize.css (adds external dependency) |

**Key insight:** Modern CSS (custom properties, `clamp()`, Grid, `svh`) handles all layout and typography challenges for a 9-section landing page without any library. The only JS needed is IntersectionObserver and class toggles — both native.

---

## Common Pitfalls

### Pitfall 1: Generic Visual Identity Drift

**What goes wrong:** Under deadline pressure, the graphite/gold palette or Cormorant+Inter typography gets replaced with defaults — Montserrat, blue brand color, white background throughout. The page looks like any other consulting template.

**Why it happens:** Developers start with "we'll style it later" and never lock the tokens. Section CSS files start using hardcoded fallback colors.

**How to avoid:** `tokens.css` must be the FIRST file created and reviewed. No section CSS file is written until tokens are complete. The `tokens.css` file is the "gate" — if it doesn't exist, no other CSS gets written.

**Warning signs:** Any `#1a73e8` (default link blue), any `font-family: sans-serif` without the custom font variable, any `color: #333` without a token reference.

### Pitfall 2: Static Sections Without Real Copy

**What goes wrong:** Section wrappers are created with "Título de sección" and "Lorem ipsum" placeholder text. The progressive enhancement baseline is technically present but useless — a client or stakeholder opening `index.html` with JS disabled sees non-Spanish boilerplate.

**Why it happens:** Developers treat content as a later concern.

**How to avoid:** All 9 sections must ship with real Spanish placeholder copy using mining/metallurgical terminology. The UI-SPEC copywriting contract provides approved placeholder text for the hero, CTAs, taglines, and empty states. Remaining section copy (methodology steps, service descriptions, pillar text) must be written with mining terminology (NI 43-101, flotación, conminución, recuperación metalúrgica) — not generic corporate language.

**Warning signs:** Any section using "Lorem ipsum", "Título aquí", or English placeholder text.

### Pitfall 3: Anchor Scroll Occluded by Sticky Header

**What goes wrong:** Clicking "Servicios" in the nav scrolls the page so the `#servicios` section heading lands behind the sticky header — the user sees nothing for 72px.

**Why it happens:** `scroll-behavior: smooth` and `<a href="#servicios">` work without the offset; the offset requires an additional CSS property.

**How to avoid:** Add to each section: `scroll-margin-top: var(--header-height)` (72px). This is a CSS-only fix, no JS needed.

**Warning signs:** Clicking any nav link and seeing the section heading hidden under the header.

### Pitfall 4: Mobile Nav Without Body Scroll Lock

**What goes wrong:** Opening the mobile nav overlay lets the user scroll the page behind it — the overlay appears to "scroll away" or content bleeds through.

**Why it happens:** The overlay uses `position: fixed` or `position: absolute` but the body remains scrollable.

**How to avoid:** When the nav opens: `document.body.style.overflow = 'hidden'`. When the nav closes (hamburger click, link click, escape key): `document.body.style.overflow = ''`. Must clean up on every close path.

**Warning signs:** Opening mobile nav and scrolling — if the background page moves, the lock is missing.

### Pitfall 5: Hero Height Clipping on Mobile Browsers

**What goes wrong:** `height: 100vh` on the hero clips content on iOS Safari and Chrome for Android because the browser's address bar is counted in `vh` calculation, then shrinks on scroll — causing a visual jump.

**Why it happens:** `100vh` is defined against the initial viewport height including the browser chrome, then the chrome hides on scroll, making the hero appear to "grow."

**How to avoid:** Use `min-height: 100svh` (small viewport height = viewport with browser chrome visible). Fallback for older browsers: `min-height: 100vh`. The `svh` unit is supported in Safari 15.4+, Chrome 108+, Firefox 101+.

```css
.hero {
  min-height: 100vh; /* fallback */
  min-height: 100svh; /* modern — accounts for mobile browser chrome */
}
```

**Warning signs:** Test on an iPhone in Safari; if the hero bottom CTA is hidden by the address bar, the fix is needed.

### Pitfall 6: Service Card Hover Border Causes Layout Shift

**What goes wrong:** Adding `border-top: 2px solid --color-gold-500` on hover causes the card to shift 2px because the non-hover state has no `border-top` (or 1px border-top from the base border).

**Why it happens:** Adding/removing a border changes the box model, shifting sibling elements.

**How to avoid:** The base state must always have a `border-top` that matches width. Use `border-top: 2px solid transparent` in the base state, then change to `2px solid var(--color-gold-500)` on hover. Alternatively, combine with the `transform: translateY(-2px)` so the card lifts rather than the content shifting.

```css
.service-card {
  border: 1px solid var(--color-light-gray);
  border-top: 2px solid transparent; /* reserves space to prevent shift */
}
.service-card:hover {
  border-top-color: var(--color-gold-500);
  transform: translateY(-2px);
}
```

---

## Code Examples

Verified patterns for this phase:

### Google Fonts Loading with font-display: swap

```html
<!-- index.html <head> — font-display:swap via URL param -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
```

### Container Utility Class

```css
/* css/layout.css */
.container {
  width: 100%;
  max-width: var(--container-max);
  margin-inline: auto;
  padding-inline: var(--container-padding);
}
```

### Section Base Styles (applies to all 9 sections)

```css
/* css/layout.css */
section {
  scroll-margin-top: var(--header-height); /* UX-03: anchor offset */
}

.section--dark {
  background-color: var(--color-carbon);
  color: var(--color-white);
}

.section--light-warm {
  background-color: var(--color-warm-white);
  color: var(--color-carbon);
}

.section--light-gray {
  background-color: var(--color-light-gray);
  color: var(--color-carbon);
}

.section__inner {
  padding-block: var(--space-section-mobile);
}

@media (min-width: 1024px) {
  .section__inner {
    padding-block: var(--space-section-desktop);
  }
}
```

### Section Header with Gold Accent Line

```css
/* css/base.css or utilities */
.section-header__title {
  font-family: var(--font-display);
  font-size: var(--text-heading);
  font-weight: 600;
  line-height: 1.2;
}
.section-header__title::after {
  content: '';
  display: block;
  width: 48px;
  height: 3px;
  background-color: var(--color-gold-500);
  margin-top: 12px;
}
```

### Services Grid — Responsive

```css
/* css/sections/servicios.css */
.services__grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: var(--space-lg);
}
@media (min-width: 768px) {
  .services__grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
```

### Main JS Entry Point

```javascript
// js/main.js — type="module"
import { initHeader } from './header.js';
import { initScrollAnimations } from './animations.js';

document.addEventListener('DOMContentLoaded', () => {
  initHeader();
  initScrollAnimations();
});
```

### Hero Scroll Indicator (Pure CSS)

```css
/* css/sections/hero.css */
.hero__chevron {
  display: block;
  width: 24px;
  height: 24px;
  border-right: 2px solid var(--color-gold-500);
  border-bottom: 2px solid var(--color-gold-500);
  transform: rotate(45deg);
  animation: bounce 1.5s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% { transform: rotate(45deg) translateY(0); }
  50%       { transform: rotate(45deg) translateY(6px); }
}
```

### Methodology Step Structure

```html
<!-- Numbered step — methodology section -->
<div class="methodology-step" data-animate>
  <span class="methodology-step__number" aria-hidden="true">01</span>
  <div class="methodology-step__content">
    <h3 class="methodology-step__title">Confidencialidad desde el primer contacto</h3>
    <p class="methodology-step__body">Firmamos un NDA antes de recibir cualquier antecedente técnico o comercial del proyecto. Su información está protegida desde la primera conversación.</p>
  </div>
</div>
```

```css
/* css/sections/metodologia.css */
.methodology-step__number {
  font-family: var(--font-display);
  font-size: 3.5rem; /* 56px — presentational override */
  font-weight: 400;
  color: var(--color-gold-500);
  line-height: 1;
}
```

### Placeholder Page Scaffold (SCAL-01)

```html
<!-- pages/blog/index.html -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog — FN Mining Advisor</title>
  <link rel="stylesheet" href="../../css/tokens.css">
  <link rel="stylesheet" href="../../css/base.css">
  <link rel="stylesheet" href="../../css/layout.css">
</head>
<body>
  <!-- Phase 1: placeholder scaffold. Dynamic content in v2. -->
  <main>
    <h1>Artículos técnicos — próximamente</h1>
    <p><a href="../../index.html">← Volver al inicio</a></p>
  </main>
</body>
</html>
```

---

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| Sass/Less variables for design tokens | CSS custom properties on `:root` | CSS spec mainstream ~2020 | No build step; runtime-accessible from JS; works with CSS `calc()` |
| `vh` units for full-height sections | `svh` (small viewport height) with `vh` fallback | Safari 15.4 (Mar 2022), Chrome 108 (Oct 2022) | Correct hero height on mobile without address bar clipping |
| Scroll event listeners for intersection | `IntersectionObserver` API | Chrome 51 (2016), baseline ~2018 | Callback-based, performant; no per-pixel event firing |
| `@import` in CSS | Native CSS `@import` at top of stylesheet or `<link>` tags in HTML | N/A | For no-build-tool setup, `<link>` tags in HTML head are preferred — `@import` blocks rendering |
| Pixel font sizes with breakpoints | `clamp(min, preferred, max)` | CSS Clamp mainstream ~2020 | Fluid type without media query boilerplate |
| Normalize.css | Minimal custom reset (box-sizing + margin/padding) | ~2020 community shift | Normalize maintained old behavior; modern reset starts clean |

**Deprecated/outdated:**
- `height: 100vh` on full-bleed hero: replaced by `min-height: 100svh` for mobile correctness
- jQuery for class toggle and scroll: not needed; native `classList` and `IntersectionObserver` cover all requirements
- CSS `@import` for linking stylesheets (render-blocking): use `<link>` tags in HTML head instead

---

## Open Questions

1. **Icon source for service cards**
   - What we know: CONTEXT.md says "Heroicons o Phosphor Icons en variante outline/regular"; Claude's Discretion to choose
   - What's unclear: Inline SVG vs. SVG sprite vs. SVG `<use>` reference — each has tradeoffs for maintainability
   - Recommendation: Inline SVG for Phase 1 (zero setup, no external request); 4 icons total (one per service). If a sprite pattern is wanted for scaling, defer to Phase 4.

2. **Footer exact content**
   - What we know: SHEL-04 requires contact data, section links, and legal note; CONT-04 requires email; CONT-05 requires LinkedIn
   - What's unclear: Specific legal note text (copyright year, company legal name)
   - Recommendation: Placeholder legal note "© 2026 FN Mining Advisor. Todos los derechos reservados." — replace with client's legal name before launch.

3. **Google Fonts vs. self-hosted**
   - What we know: Google Fonts CDN is acceptable for v1; self-hosting improves privacy
   - What's unclear: Whether the project has a privacy policy that requires avoiding Google CDN
   - Recommendation: Use Google Fonts CDN for Phase 1 (`&display=swap` in URL). Self-hosting can be added in Phase 5 if needed.

---

## Validation Architecture

`nyquist_validation` is enabled in `.planning/config.json`.

### Test Framework

| Property | Value |
|----------|-------|
| Framework | None — this is a static HTML/CSS/JS project with no test runner configured |
| Config file | none — see Wave 0 gaps |
| Quick run command | Manual browser check: open `index.html` in browser with JS disabled |
| Full suite command | Manual checklist: JS disabled test + mobile 320px test + DevTools network throttle test |

**Note:** This project has no package.json and no installed test framework. Automated testing for a static HTML/CSS/JS site with no build tool typically uses manual browser-based verification or a lightweight tool like Playwright for end-to-end checks. For Phase 1, the primary validation is visual/manual. Playwright could be added in Phase 5 (SEO/Performance) as a pre-launch gate.

### Phase Requirements → Test Map

| Req ID | Behavior | Test Type | Automated Command | File Exists? |
|--------|----------|-----------|-------------------|-------------|
| DSYS-01 | CSS custom properties define full palette/type/spacing | manual | Open `css/tokens.css`; verify all tokens present | ❌ Wave 0 |
| DSYS-02 | Changing `--logo-accent` updates all gold usage | manual | Change `--color-gold-500` to red; verify visual update | ❌ Wave 0 |
| SHEL-01 | 9 sections exist with correct IDs | manual | Inspect DOM; count `<section>` elements with IDs | ❌ Wave 0 |
| SHEL-02 | Page renders with JS disabled | manual | Chrome DevTools → disable JS → reload; all sections have content | ❌ Wave 0 |
| SHEL-03 | Sticky header visible with anchor nav and CTA | manual | Scroll page; header stays at top with nav and button | ❌ Wave 0 |
| UX-01 | Fade-in animations trigger on scroll | manual | Scroll page; sections animate in; no external libraries | ❌ Wave 0 |
| UX-03 | Anchor links scroll with offset | manual | Click nav link; section H2 visible (not behind header) | ❌ Wave 0 |
| RESP-01 | No horizontal overflow at 320px/768px/1024px | manual | Chrome DevTools → 320px viewport; no horizontal scrollbar | ❌ Wave 0 |
| RESP-02 | Mobile hamburger nav works without JS library | manual | Resize to 375px; tap hamburger; overlay appears | ❌ Wave 0 |
| RESP-03 | Services grid: 1 col mobile, 2 col tablet | manual | 375px: 1 column; 768px: 2 columns | ❌ Wave 0 |
| SCAL-01 | `/pages/blog/`, `/pages/casos-de-exito/`, `/pages/capacitaciones/` exist | file check | `ls pages/` | ❌ Wave 0 |

### Sampling Rate

- **Per task commit:** Open `index.html` in browser; visually verify the section built in that task
- **Per wave merge:** Full manual checklist: JS disabled, 320px viewport, all 9 sections present and styled
- **Phase gate:** All items in manual checklist pass before `/gsd:verify-work`

### Wave 0 Gaps

- [ ] `css/tokens.css` — all brand tokens defined; no section CSS written without this
- [ ] `index.html` — shell with all 9 section IDs; minimal content structure
- [ ] Manual test script (informal checklist) — JS disabled test, 320px test, scroll animation test
- [ ] Local development server verified: `python3 -m http.server 8080` works from project root (ES modules require HTTP server)
- [ ] `pages/blog/index.html`, `pages/casos-de-exito/index.html`, `pages/capacitaciones/index.html` — scaffold files

---

## Sources

### Primary (HIGH confidence)

- `.planning/research/STACK.md` — Stack decisions: no build tool, ES modules, CSS custom properties, BEM, `font-display: swap` requirement
- `.planning/research/ARCHITECTURE.md` — Project file structure, CSS token architecture, progressive enhancement pattern, anti-patterns
- `.planning/research/PITFALLS.md` — Visual identity drift (Pitfall 6), flash of empty content (Pitfall 4), CTA hierarchy (Pitfall 5), sticky nav offset
- `.planning/research/SUMMARY.md` — Phase 1 rationale, build order, "standard patterns" confirmation
- `.planning/phases/01-design-system-static-shell/01-CONTEXT.md` — All locked decisions, exact color/typography values, section structure decisions
- `.planning/phases/01-design-system-static-shell/01-UI-SPEC.md` — Complete visual contract: spacing scale, type scale, color palette, component specs (btn, service-card, section-header, methodology-step, trust-pillar, header states), animation specs, responsive breakpoints, copywriting contract
- `.planning/REQUIREMENTS.md` — Authoritative requirement definitions for all Phase 1 IDs
- MDN Web Docs — `IntersectionObserver`, CSS `clamp()`, `scroll-margin-top`, `svh` viewport units, ES modules (HIGH confidence — official docs)

### Secondary (MEDIUM confidence)

- `.planning/research/STACK.md` — CSS BEM naming convention recommendation (sourced from Smashing Magazine Jun 2025, CSS-Tricks)
- `.planning/research/PITFALLS.md` — Service card hover border layout shift pattern (training data + community pattern)

### Tertiary (LOW confidence)

- Training data — CSS `border-top: 2px solid transparent` trick to prevent hover layout shift; widely used community pattern but not cited against a specific authoritative source

---

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH — CSS custom properties, BEM, ES modules, IntersectionObserver are native browser technologies with MDN documentation
- Architecture: HIGH — file structure and patterns confirmed in `.planning/research/ARCHITECTURE.md` (sourced from official WP/MDN docs)
- Component specs: HIGH — all values sourced from `01-UI-SPEC.md` and `01-CONTEXT.md` (locked user decisions)
- Pitfalls: HIGH (technical) / MEDIUM (hover border layout shift) — most pitfalls cited in PITFALLS.md with official sources
- Copy: MEDIUM — placeholder copy patterns use mining terminology per CONTEXT.md guidance; exact wording is Claude's Discretion

**Research date:** 2026-03-16
**Valid until:** 2026-06-16 (90 days — CSS native APIs are stable; no framework version churn)

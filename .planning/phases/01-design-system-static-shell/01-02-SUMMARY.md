---
phase: 01-design-system-static-shell
plan: 02
subsystem: ui
tags: [html, css, vanilla-css, bem, hero, header, mobile-nav, servicios, valor, phosphor-icons, svg-icons]

# Dependency graph
requires:
  - phase: 01-design-system-static-shell/01-01
    provides: css/tokens.css with all custom properties; css/base.css, css/layout.css, css/utilities.css foundation files
provides:
  - index.html — complete HTML document with sticky header, hero, propuesta de valor, and servicios sections
  - css/header.css — sticky header styles (transparent/scrolled states), logo, desktop nav, mobile hamburger, full-screen overlay
  - css/sections/hero.css — 100vh gradient hero, @keyframes bounce scroll indicator, gold H1 accent line
  - css/sections/valor.css — warm-white trust pillars section with 3px gold left-border
  - css/sections/servicios.css — light-gray service cards grid (1→2col responsive) with hover lift and gold top-border
affects:
  - 01-03-PLAN (remaining sections: innovacion, metodologia, experiencia, insights, cta-final, contacto, footer — inserting at SECTIONS-CONTINUE comment)
  - 01-04-PLAN (JavaScript: header.js scroll behavior, animations.js IntersectionObserver for .fade-in)
  - Phase 4 (WordPress integration: replaces placeholder copy with WP REST API data)

# Tech tracking
tech-stack:
  added:
    - Inline SVG icons from Phosphor Icons library (outline variant, currentColor fill)
  patterns:
    - BEM CSS for all new components (.site-header, .site-logo, .site-nav, .mobile-nav, .hero, .trust-pillar, .service-card)
    - All section CSS uses var(--...) exclusively — zero hardcoded hex values
    - CSS-only animation: @keyframes bounce on .hero__scroll-indicator (no JS required)
    - Progressive enhancement: page fully readable with JS disabled (no JS-dependent content)
    - SECTIONS-CONTINUE comment as named insertion point for Plan 03

key-files:
  created:
    - index.html
    - css/header.css
    - css/sections/hero.css
    - css/sections/valor.css
    - css/sections/servicios.css
  modified: []

key-decisions:
  - "Header CSS link tags for all 9 sections included in index.html head now — Plan 03 only needs to add HTML, not modify head"
  - "hero.css uses both height: 100vh (desktop) and min-height: 100svh (fallback) to support modern mobile browsers without content clipping"
  - "Service card border-top: 2px solid transparent reserves space so hover gold top-border appears without layout shift"
  - "Logo uses rebrand-safe tokens --logo-accent-color and --logo-text-color (not --color-gold-500 directly) per Plan 01 decision"

patterns-established:
  - "Section CSS files only style their own section class (no cross-section selectors) — enables clean insertion in Plan 03"
  - "Mobile hamburger sized 44px × 44px for touch target compliance (RESP-04)"
  - "Mobile nav overlay uses opacity + visibility (not display:none) to enable CSS transition for fade-in"
  - "All var() references verified against tokens.css — no undefined custom properties"

requirements-completed: [SHEL-01, SHEL-02, SHEL-03, SECT-01, SECT-02, RESP-01, RESP-02, RESP-03, UX-03]

# Metrics
duration: 3min
completed: 2026-03-17
---

# Phase 1 Plan 02: HTML Shell with Header, Hero, Valor, and Servicios Summary

**Semantic HTML document with sticky dark header, full-viewport hero gradient, 4 trust pillars with gold left-border, and 4 service cards in a responsive 2×2 grid — all content readable without JavaScript**

## Performance

- **Duration:** 3 min
- **Started:** 2026-03-17T00:09:42Z
- **Completed:** 2026-03-17T00:13:00Z
- **Tasks:** 2
- **Files created:** 5

## Accomplishments

- Built complete index.html with semantic structure: sticky header (typographic logo + desktop nav + mobile hamburger + full-screen overlay), hero section (100vh, dark gradient, H1, dual CTAs, trayectoria tagline, CSS bounce scroll indicator), Propuesta de Valor with 4 trust-pillar articles, Servicios with 4 service-card articles — all content 100% readable without JavaScript
- Created four CSS files (header.css, hero.css, valor.css, servicios.css) with zero hardcoded hex values — all colors via var() tokens, enabling single-file rebrand
- Established SECTIONS-CONTINUE insertion point in index.html and pre-linked all 9 section CSS files in head so Plan 03 only adds HTML content

## Task Commits

Each task was committed atomically:

1. **Task 1: Build index.html shell with header, Hero, Propuesta de Valor, and Servicios sections** - `9660a8d` (feat)
2. **Task 2: Create Hero, Valor, and Servicios section CSS files** - `5572da5` (feat)

## Files Created/Modified

- `index.html` — 238-line HTML document: DOCTYPE, head with 13 stylesheet links (tokens first), sticky header, mobile nav overlay, hero section (id=hero), propuesta de valor section (id=valor, 4 trust pillars), servicios section (id=servicios, 4 service cards), footer placeholder, SECTIONS-CONTINUE comment
- `css/header.css` — Fixed header with transparent/scrolled states, logo rebrand-safe tokens, desktop nav with 44px touch targets, mobile hamburger, full-screen mobile-nav overlay with opacity/visibility fade-in
- `css/sections/hero.css` — 100vh/min-height:100svh gradient hero, H1 with 48px×3px gold ::after line, subheadline, CTAs, trayectoria tagline with gold separator, @keyframes bounce scroll indicator
- `css/sections/valor.css` — Warm-white section, .trust-pillar with 3px gold left-border, Cormorant heading presentational override (20px, weight 400)
- `css/sections/servicios.css` — Light-gray section, 1→2col responsive grid at 768px, .service-card with hover lift (translateY -2px), shadow amplification, and gold top-border on hover

## Decisions Made

- Included `<link>` tags for all 9 section CSS files (including those created by Plan 03) in the head now — this means Plan 03 only needs to insert HTML between the SECTIONS-CONTINUE comment and the footer, without touching the head
- Used `height: var(--header-height)` (44px) on `.site-nav__hamburger` for touch compliance, sized the button element itself rather than just adding padding
- Used `border-top: 2px solid transparent` on `.service-card` (base state) to reserve space so the gold hover border does not cause layout shift on hover

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered

None.

## User Setup Required

None - all files are static HTML/CSS, no external services required.

## Next Phase Readiness

- Plan 03 can insert remaining sections (#innovacion, #metodologia, #experiencia, #insights, #cta-final, #contacto) before the `<!-- SECTIONS-CONTINUE -->` comment, and complete the footer
- Plan 04 can add JS files at the end of body: header.js (scroll behavior, .header--scrolled, mobile nav toggle), animations.js (IntersectionObserver for .fade-in)
- All section CSS files pre-linked in head — Plan 03 only creates the CSS files and adds HTML content, no head modification needed
- No blockers

## Self-Check: PASSED

All 5 files confirmed present on disk. Commits 9660a8d and 5572da5 confirmed in git log.

---
*Phase: 01-design-system-static-shell*
*Completed: 2026-03-17*

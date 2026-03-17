---
phase: 01-design-system-static-shell
plan: 04
subsystem: ui
tags: [vanilla-js, es-modules, intersection-observer, progressive-enhancement, mobile-nav, scroll-animation]

# Dependency graph
requires:
  - phase: 01-design-system-static-shell plan 03
    provides: index.html with all 9 sections and .fade-in elements; css/header.css with .header--scrolled and .nav--open; css/utilities.css with .fade-in/.is-visible animation classes
provides:
  - js/header.js — header scroll solidification via IntersectionObserver + mobile nav overlay with full accessibility
  - js/animations.js — IntersectionObserver fade-in scroll animations for all .fade-in elements
  - js/main.js — ES module entry point wiring all JS behaviors
  - index.html with active <script type="module"> tag loading main.js
affects: [phase-02-wordpress, phase-04-wp-integration, future JS sections]

# Tech tracking
tech-stack:
  added: []
  patterns:
    - ES modules (type="module") — no build step, native browser module loading
    - IntersectionObserver for scroll detection (performant over scroll events)
    - Progressive enhancement — page fully readable without JS; JS adds behavior on top
    - Null-guard pattern on all DOM queries before operating on elements
    - Scroll event fallback for browsers lacking IntersectionObserver

key-files:
  created:
    - js/header.js
    - js/animations.js
    - js/main.js
  modified:
    - index.html

key-decisions:
  - "IntersectionObserver on hero section used for header solidification — more performant than scroll event; scroll event retained as fallback"
  - "unobserve() called after each fade-in element becomes visible — one-time animation, no reverse on scroll-back"
  - "document.body.style.overflow = hidden on mobile nav open — prevents background scroll while overlay is active"
  - "Escape key and backdrop-click both close mobile nav — compliant with WCAG overlay pattern"
  - "footer-year populated dynamically via JS — static fallback 2025 in HTML for no-JS case"

patterns-established:
  - "ES module pattern: each behavior in its own file, imported by main.js — ready for future section JS modules"
  - "initX() export function pattern: each module exports a single init function called by main.js"
  - "IntersectionObserver guard: always check 'IntersectionObserver' in window before instantiating"
  - "Null-check pattern: if (!element) return; at top of every init function"

requirements-completed: [UX-01, UX-02, UX-03, RESP-02, SCAL-02]

# Metrics
duration: 1min
completed: 2026-03-17
---

# Phase 01 Plan 04: JavaScript Interactive Layer Summary

**Vanilla JS ES modules adding header scroll solidification, mobile nav overlay with ARIA, and IntersectionObserver fade-in animations — zero external dependencies, full progressive enhancement**

## Performance

- **Duration:** ~1 min
- **Started:** 2026-03-17T00:19:38Z
- **Completed:** 2026-03-17T00:20:53Z
- **Tasks:** 2
- **Files modified:** 4

## Accomplishments

- Three ES module JS files created with no external dependencies
- Header solidification via IntersectionObserver on hero element — transparent to solid carbon on scroll past hero, with scroll event fallback for older browsers
- Mobile nav overlay with full accessibility: aria-expanded toggle, aria-label toggle (Abrir/Cerrar menú), focus management (focus moves to close button on open, returns to hamburger on close), Escape key + backdrop-click close
- Scroll-triggered fade-in via IntersectionObserver at 0.15 threshold — elements animate once (unobserve after visible), with fallback to immediate visible state without IntersectionObserver
- index.html script placeholder comment replaced with active `<script type="module" src="js/main.js">` tag

## Task Commits

Each task was committed atomically:

1. **Task 1: Create JS modules for header behavior and scroll animations** - `572f6ad` (feat)
2. **Task 2: Wire JS entry point into index.html** - `12557eb` (feat)

**Plan metadata:** (docs commit — in progress)

## Files Created/Modified

- `js/header.js` — exports `initHeader()`: IntersectionObserver on `#hero` for `header--scrolled` toggle; mobile nav open/close with nav--open, ARIA attrs, body overflow, focus management, Escape key, backdrop click
- `js/animations.js` — exports `initAnimations()`: IntersectionObserver (threshold 0.15, rootMargin -48px) on all `.fade-in` elements; adds `.is-visible` and unobserves; fallback for no-IO browsers
- `js/main.js` — ES module entry: imports initHeader + initAnimations, calls initHeader immediately, initAnimations after DOMContentLoaded; updates `#footer-year` dynamically
- `index.html` — replaced `<!-- <script type="module"> -->` comment with active script tag at bottom of body

## Decisions Made

- IntersectionObserver on hero element chosen over scroll event for header solidification — browser-optimized, fires only on threshold crossing rather than every scroll tick
- `unobserve()` called after each element becomes visible — fade-in is one-time; prevents redundant observer callbacks on previously-visible elements
- `document.body.style.overflow = 'hidden'` on mobile nav open — traps scroll to overlay context, standard overlay accessibility pattern
- Escape key and backdrop click both dismiss mobile nav — matches WCAG 2.1 success criterion 1.4.13 (Content on Hover or Focus) overlay pattern
- `rootMargin: -48px 0px 0px` on fadeObserver — starts animation 48px before element reaches viewport bottom, avoids elements popping in at the very last moment

## JS Behaviors Implemented

| Behavior | Implementation | Trigger |
|----------|----------------|---------|
| Header solidification | IntersectionObserver on `#hero`, toggles `.header--scrolled` | Hero exits viewport |
| Header fallback | `window.addEventListener('scroll')` | `scrollY > 50` |
| Mobile nav open | `.nav--open`, `aria-hidden` removal, `aria-expanded: true`, `body.overflow: hidden` | Hamburger click |
| Mobile nav close | Remove `.nav--open`, restore ARIA, restore `body.overflow` | Close btn, Escape, backdrop click, nav link click |
| Fade-in animation | IntersectionObserver at 0.15 threshold, adds `.is-visible` | Element 15% visible |
| Fade-in fallback | Direct `.is-visible` class addition | No IntersectionObserver |
| Footer year | `new Date().getFullYear()` into `#footer-year` | On module load |

## Accessibility Attributes Toggled by JS

- `aria-expanded="false/true"` on `#nav-toggle` — hamburger button state
- `aria-label="Abrir menú" / "Cerrar menú"` on `#nav-toggle` — descriptive state
- `aria-hidden="true/false"` on `#mobile-nav` — overlay visibility for screen readers
- `document.body.style.overflow = 'hidden/''` — background scroll prevention
- Focus management: `navClose.focus()` on open, `navToggle.focus()` on close

## Progressive Enhancement Confirmation

The page is fully readable and navigable without JavaScript. Confirmed by architecture:
- All HTML content in index.html rendered server-side (no JS-gated content)
- CSS-only scroll-behavior: smooth for anchor navigation (base.css)
- scroll-margin-top: 72px on section[id] in base.css — correct header offset without JS
- .fade-in elements have no `display: none` — CSS initial state is opacity 0 + translateY 16px (visible in terms of layout, just faded); confirmed from utilities.css (Plan 01)
- Header transparent state is CSS default — no JS needed for initial render

## Requirements Addressed

| Requirement | Status | How |
|-------------|--------|-----|
| UX-01 (scroll animations) | Complete | IntersectionObserver fade-in on all .fade-in elements, 0.5s CSS transition |
| UX-02 (mobile nav overlay) | Complete | Full-screen nav--open overlay with fade-in 0.2s ease |
| UX-03 (header scroll behavior) | Complete | header--scrolled class via IntersectionObserver on hero |
| RESP-02 (mobile interaction) | Complete | Hamburger → overlay on mobile; aria-expanded; Escape close |
| SCAL-02 (modular JS) | Complete | ES modules pattern: header.js, animations.js, main.js — extensible by future sections |

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered

None.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness

- Phase 1 (Design System + Static Shell) is now complete — all 4 plans executed
- Static shell ready for browser testing: open index.html via local server to verify header solidification, mobile nav, and fade-in behaviors
- Phase 2 (WordPress CMS) can proceed independently — frontend shell is decoupled from WP
- Phase 4 (WP Integration) will wire the contact form (data-cf7-form-id on #contact-form) and insights API (data-api-target on .insights-section__empty) — both data attributes already in place

---
*Phase: 01-design-system-static-shell*
*Completed: 2026-03-17*

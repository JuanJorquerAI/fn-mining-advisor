---
phase: 01-design-system-static-shell
plan: 03
subsystem: frontend-shell
tags: [html, css, sections, footer, contact-form, methodology, responsive]
dependency_graph:
  requires: [01-02]
  provides: [complete-9-section-shell, contact-form-hook, footer]
  affects: [phase-04-js-integration]
tech_stack:
  added: []
  patterns:
    - CSS custom properties via var() tokens — zero hardcoded hex values
    - CSS Grid for methodology steps (numeral + content columns)
    - data-api-target hooks for Phase 4 JS integration
    - 44px touch target minimum on all form inputs (RESP-04)
key_files:
  created:
    - css/sections/innovacion.css
    - css/sections/metodologia.css
    - css/sections/experiencia.css
    - css/sections/insights.css
    - css/sections/cta-final.css
    - css/sections/contacto.css
    - css/footer.css
  modified:
    - index.html
decisions:
  - Methodology connector line uses ::before pseudo-element on the ol — avoids extra DOM nodes while providing the vertical visual thread between steps
  - footer.css uses rgba(94, 104, 115, 0.3) for legal border — necessary for opacity variant; no CSS opacity token exists for this use case
metrics:
  duration: 2 min
  completed_date: "2026-03-17"
  tasks_completed: 2
  files_changed: 8
---

# Phase 1 Plan 3: Complete 9-Section Shell with Footer Summary

Complete HTML landing page with 6 remaining sections (Innovacion through Contacto) and site footer, plus 7 CSS files implementing the dark/light section rhythm and contact form with 44px touch targets.

## What Was Built

### All 9 Section IDs and Background Colors

| Section | ID | Background | Class |
|---|---|---|---|
| 1 | `#hero` | Dark carbon (#15181C) | `section--dark` |
| 2 | `#valor` | Light warm-white (#F5F5F2) | — |
| 3 | `#servicios` | Light gray (#E9ECEF) | — |
| 4 | `#innovacion` | Dark carbon (#15181C) | `section--dark` |
| 5 | `#metodologia` | Dark carbon (#15181C) | `section--dark` |
| 6 | `#experiencia` | Light warm-white (#F5F5F2) | — |
| 7 | `#insights` | Light gray (#E9ECEF) | — |
| 8 | `#cta-final` | Dark carbon (#15181C) | `section--dark` |
| 9 | `#contacto` | Light warm-white (#F5F5F2) | — |

Rhythm: 4 dark sections (hero, innovacion, metodologia, cta-final), 5 light sections.

### Requirements Satisfied

**SECT-03 (Innovacion):** 4-article grid with h3 headings and body text, dark carbon bg.

**SECT-04 (Metodologia):** `<ol>` with 5 `.methodology-step` items, gold 3.5rem Cormorant numerals (01-05), CSS connector line via `::before` pseudo-element.

**SECT-05 (Experiencia):** Editorial copy block with 4-column hitos grid (gold left border), LinkedIn CTA button.

**SECT-06 (Insights):** Light gray bg, centered placeholder state with `data-api-target="insights-grid"` hook for Phase 4 post injection.

**SECT-07 (CTA Final):** Dark carbon, centered max-width content, primary diagnosis CTA + WhatsApp button.

**SHEL-04 (Complete shell):** Full 9-section HTML document with footer — navigable and readable without JavaScript.

### Contact Requirements (CONT-02 through CONT-05)

**CONT-02:** Verbatim confidentiality text present: "Sus datos y consulta son tratados con estricta confidencialidad" — styled as `.contact-form__confidentiality` (italic, steel-mid).

**CONT-03:** WhatsApp `href="https://wa.me/56900000000"` present in both `#cta-final` and `#contacto` sections.

**CONT-04:** Direct email `href="mailto:contacto@fnminingadvisor.com"` present in `#contacto` aside.

**CONT-05:** LinkedIn `href="https://linkedin.com"` present in both `#experiencia` (primary CTA) and `#contacto` aside.

### RESP-04 Compliance

- `.contact-form__input` and `.contact-form__textarea` have `min-height: 44px` — meets WCAG 2.5.5 touch target minimum
- Footer nav and contact links also have `min-height: 44px` with `display: flex; align-items: center`
- Form uses `-webkit-appearance: none; appearance: none` to reset iOS default input styling

### Phase 4 Integration Hooks

| Hook | Element | Target |
|---|---|---|
| `data-api-target="insights-grid"` | `.insights-section__empty` div | Phase 4 JS replaces with CPT posts |
| `data-api-target="experience-stats"` | `.experiencia-section__hitos` div | Phase 4 WP ACF stats injection |
| `id="contact-form"` + `data-cf7-form-id=""` | `<form>` | Phase 4 CF7 REST API wiring |
| `id="form-status"` + `aria-live="polite"` | Status div | Phase 4 JS success/error feedback |
| `<!-- <script type="module" src="js/main.js"></script> -->` | End of body | Plan 04 uncomments and adds JS |

## Commits

| Task | Commit | Description |
|---|---|---|
| Task 1 | affd41e | feat(01-03): add remaining 6 sections and complete footer in index.html |
| Task 2 | cb22dbe | feat(01-03): create CSS for remaining 6 sections and footer |

## Deviations from Plan

None — plan executed exactly as written.

The only notable decision: `css/footer.css` uses `rgba(94, 104, 115, 0.3)` for the legal strip border because the design system has no opacity variant token for `--color-steel-mid`. This is a single-use opacity expression that cannot be replaced with a `var()` token without adding a new token (which would be premature). The value is derived directly from the steel-mid hex (#5E6873 = rgb(94, 104, 115)).

## Self-Check: PASSED

All 8 files confirmed present on disk. Both task commits (affd41e, cb22dbe) confirmed in git log.

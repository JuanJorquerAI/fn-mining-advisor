---
phase: 1
slug: design-system-static-shell
status: draft
nyquist_compliant: false
wave_0_complete: false
created: 2026-03-16
---

# Phase 1 — Validation Strategy

> Per-phase validation contract for feedback sampling during execution.

---

## Test Infrastructure

| Property | Value |
|----------|-------|
| **Framework** | Manual browser-based (no automated test runner — vanilla HTML/CSS/JS) |
| **Config file** | none |
| **Quick run command** | `open index.html` (browser check) |
| **Full suite command** | Browser open at 320px, 768px, 1024px + JS disabled check |
| **Estimated runtime** | ~2 minutes manual |

---

## Sampling Rate

- **After every task commit:** Open `index.html` in browser, check relevant section
- **After every plan wave:** Full cross-browser check at all 3 viewport widths
- **Before `/gsd:verify-work`:** Full suite must be green (all 5 success criteria pass)
- **Max feedback latency:** ~120 seconds

---

## Per-Task Verification Map

| Task ID | Plan | Wave | Requirement | Test Type | Automated Command | File Exists | Status |
|---------|------|------|-------------|-----------|-------------------|-------------|--------|
| 1-01-01 | 01 | 0 | DSYS-01 | file-exists | `test -f assets/css/tokens.css` | ❌ W0 | ⬜ pending |
| 1-01-02 | 01 | 0 | SHEL-01 | file-exists | `test -f index.html` | ❌ W0 | ⬜ pending |
| 1-01-03 | 01 | 0 | SCAL-01 | dir-exists | `test -d pages/blog && test -d pages/casos-de-exito && test -d pages/capacitaciones` | ❌ W0 | ⬜ pending |
| 1-02-01 | 02 | 1 | DSYS-02 | manual | Open browser, inspect CSS vars in DevTools | ✅ | ⬜ pending |
| 1-02-02 | 02 | 1 | DSYS-03 | manual | Verify Cormorant Garamond + Inter render in browser | ✅ | ⬜ pending |
| 1-03-01 | 03 | 1 | SHEL-02 | manual | Scroll page, verify sticky header stays visible | ✅ | ⬜ pending |
| 1-03-02 | 03 | 1 | UX-01 | manual | Resize to 320px, verify no horizontal overflow | ✅ | ⬜ pending |
| 1-04-01 | 04 | 2 | SECT-01 | manual | Verify hero section Spanish copy, palette, typography | ✅ | ⬜ pending |
| 1-04-02 | 04 | 2 | SECT-02 | manual | Verify about/propuesta section present | ✅ | ⬜ pending |
| 1-04-03 | 04 | 2 | SECT-03 | manual | Verify services grid, single column at mobile | ✅ | ⬜ pending |
| 1-04-04 | 04 | 2 | SECT-04 | manual | Verify process/methodology section present | ✅ | ⬜ pending |
| 1-04-05 | 04 | 2 | SECT-05 | manual | Verify testimonials/clients section present | ✅ | ⬜ pending |
| 1-04-06 | 04 | 2 | SECT-06 | manual | Verify blog preview section present | ✅ | ⬜ pending |
| 1-04-07 | 04 | 2 | SECT-07 | manual | Verify CTA/contact section present | ✅ | ⬜ pending |
| 1-05-01 | 05 | 2 | UX-02 | manual | Hover cards/buttons, verify scale + color transitions | ✅ | ⬜ pending |
| 1-05-02 | 05 | 2 | UX-03 | manual | Scroll page, verify IntersectionObserver fade-in | ✅ | ⬜ pending |

*Status: ⬜ pending · ✅ green · ❌ red · ⚠️ flaky*

---

## Wave 0 Requirements

- [ ] `assets/css/tokens.css` — CSS custom properties for DSYS-01 (colors, typography, spacing)
- [ ] `index.html` — HTML shell with all 9 section IDs for SHEL-01
- [ ] `pages/blog/index.html` — scaffolding for SCAL-01
- [ ] `pages/casos-de-exito/index.html` — scaffolding for SCAL-02
- [ ] `pages/capacitaciones/index.html` — scaffolding for SCAL-03

---

## Manual-Only Verifications

| Behavior | Requirement | Why Manual | Test Instructions |
|----------|-------------|------------|-------------------|
| Correct graphite/gold palette rendered | DSYS-01 | No automated color comparison for static HTML | Open browser, use DevTools color picker on primary elements |
| Cormorant Garamond + Inter loaded | DSYS-02, DSYS-03 | Font rendering requires browser | Open index.html, inspect font-family in DevTools |
| Sticky header on scroll | SHEL-02 | Requires scroll interaction | Open browser, scroll down, header should remain visible |
| No horizontal overflow at 320px | RESP-01 | Requires viewport resize | Open DevTools, set viewport to 320px, check no overflow |
| Services grid single column at mobile | RESP-02 | Requires viewport resize | Same as above, check services section |
| JS disabled still shows all 9 sections | SHEL-03 | Requires browser setting | In Chrome: Settings > Site Settings > JavaScript > Block, open page |
| Hover transitions work | UX-02 | Requires mouse interaction | Hover over cards and buttons in browser |
| IntersectionObserver fade-in | UX-03 | Requires scroll interaction | Scroll page, observe fade-in animations |
| All anchor links work | SHEL-04 | Requires click interaction | Click each nav link, verify smooth scroll to section |

---

## Validation Sign-Off

- [ ] All tasks have `<automated>` verify or Wave 0 dependencies
- [ ] Sampling continuity: no 3 consecutive tasks without automated verify
- [ ] Wave 0 covers all MISSING references
- [ ] No watch-mode flags
- [ ] Feedback latency < 120s
- [ ] `nyquist_compliant: true` set in frontmatter

**Approval:** pending

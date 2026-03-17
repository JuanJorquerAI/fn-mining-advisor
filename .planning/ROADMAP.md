# Roadmap: FN Mining Advisor

## Overview

Build a decoupled corporate landing page for a senior mining/metallurgical consultancy. Phase 1 (frontend shell) and Phase 2 (WordPress backend) proceed in parallel to halve calendar time. Phase 3 merges both into a tested API layer. Phase 4 wires each section to the live API with graceful fallback. Phase 5 locks SEO, schema, and Core Web Vitals. Phase 6 runs full pre-launch verification against every known failure mode before the site goes public.

## Phases

**Phase Numbering:**
- Integer phases (1, 2, 3): Planned milestone work
- Decimal phases (2.1, 2.2): Urgent insertions (marked with INSERTED)

Decimal phases appear between their surrounding integers in numeric order.

- [ ] **Phase 1: Design System + Static Shell** - Lock the design tokens and build the complete 9-section HTML shell with real static content and full responsive layout
- [ ] **Phase 2: WordPress Backend Setup** - Install, configure, and harden WordPress with ACF field groups, CPTs, CF7, and security hardening (parallel with Phase 1)
- [ ] **Phase 3: API Integration Layer** - Build the centralized fetch client, endpoint constants, and transform functions against live WordPress endpoints
- [ ] **Phase 4: Section Integration** - Wire each frontend section to the WordPress REST API with progressive enhancement and contact form submission
- [ ] **Phase 5: SEO, Schema and Performance** - Implement semantic hierarchy, JSON-LD schema, Open Graph, and Core Web Vitals optimizations
- [ ] **Phase 6: Pre-Launch Hardening** - Verify every known failure mode end-to-end: CORS from production, form delivery, API fallback, security, and mobile QA

## Phase Details

### Phase 1: Design System + Static Shell
**Goal**: The landing page is fully navigable, readable, and visually complete in a browser without any JavaScript or API dependency
**Depends on**: Nothing (first phase)
**Requirements**: DSYS-01, DSYS-02, DSYS-03, SHEL-01, SHEL-02, SHEL-03, SHEL-04, UX-01, UX-02, UX-03, SECT-01, SECT-02, SECT-03, SECT-04, SECT-05, SECT-06, SECT-07, CONT-02, CONT-03, CONT-04, CONT-05, RESP-01, RESP-02, RESP-03, RESP-04, SCAL-01, SCAL-02, SCAL-03
**Success Criteria** (what must be TRUE):
  1. A visitor opening `index.html` with JavaScript disabled sees all 9 sections with real Spanish copy, correct graphite/gold palette, and Cormorant Garamond + Inter typography
  2. The sticky header shows the logo placeholder, anchor navigation links, and a primary CTA button that remain functional on scroll on both mobile and desktop
  3. The page renders without horizontal overflow at 320px, 768px, and 1024px viewport widths; the services grid collapses to a single column on mobile
  4. Cards and buttons respond to hover with the defined scale/color transitions; sections fade in on scroll via Intersection Observer with no external libraries
  5. The directory structure includes `/pages/blog/`, `/pages/casos-de-exito/`, and `/pages/capacitaciones/` scaffolding; all section IDs serve as working anchor links
**Plans**: 5 plans

Plans:
- [ ] 01-01-PLAN.md — CSS design tokens, base styles, layout helpers, directory scaffold
- [ ] 01-02-PLAN.md — index.html skeleton with header, Hero, Propuesta de Valor, Servicios sections + CSS
- [ ] 01-03-PLAN.md — Remaining 6 sections (Innovación–Contacto) + footer HTML and CSS
- [ ] 01-04-PLAN.md — JavaScript modules: header scroll behavior, mobile nav, scroll animations
- [ ] 01-05-PLAN.md — Human verification checkpoint: all 5 Phase 1 success criteria

### Phase 2: WordPress Backend Setup
**Goal**: A secured WordPress installation is live with all ACF field groups, custom post types, contact form, and plugins configured — ready to serve real API responses
**Depends on**: Nothing (parallel with Phase 1)
**Requirements**: WP-01, WP-02, WP-03, WP-04, WP-05, WP-06, WP-07, WP-08, WP-09
**Success Criteria** (what must be TRUE):
  1. Visiting `/wp-json/wp/v2/pages?slug=home` returns a JSON response with an `acf` key containing hero, services, methodology, trust pillars, experience, and CTA final field data
  2. Visiting `/wp-json/wp/v2/users` returns a 403 or empty response; XML-RPC returns 403; the WP admin URL is not `/wp-admin/`
  3. Submitting the Contact Form 7 form via its REST endpoint returns a success response and delivers an email to the configured inbox
  4. The CPT `insights` endpoint returns posts when seeded; Rank Math shows the Organization schema active in the admin
**Plans**: TBD

### Phase 3: API Integration Layer
**Goal**: A tested, centralized JavaScript API layer exists that fetches from live WordPress endpoints, normalizes responses, and handles all error conditions without breaking the page
**Depends on**: Phase 1, Phase 2
**Requirements**: API-01, API-02
**Success Criteria** (what must be TRUE):
  1. Calling `fetchEndpoint()` with an unreachable URL returns `null` and logs an error — it does not throw or break adjacent page functionality
  2. Calling any transform function with `acf: false` in the response returns a safe empty object — no TypeError is thrown
  3. CORS headers are confirmed working: a `fetch()` call from the frontend origin to the WordPress REST API returns a 200 without a CORS error in the browser console
**Plans**: TBD

### Phase 4: Section Integration
**Goal**: Every section on the page hydrates from the WordPress REST API when available, falls back silently to static HTML when the API is unavailable, and the contact form submits successfully via CF7
**Depends on**: Phase 3
**Requirements**: API-03, API-04, API-05, API-06, CONT-01
**Success Criteria** (what must be TRUE):
  1. With WordPress live, the hero headline, services cards, methodology steps, and trust pillars all display content from WordPress ACF fields — not the hardcoded static HTML
  2. With WordPress unreachable (simulated), all sections display the static HTML fallback content — no empty sections, no console errors that break the page
  3. The Insights section shows "proximamente" placeholder cards when the CPT has no posts; it renders live cards when seeded posts exist
  4. Submitting the contact form shows a success confirmation message in the UI; a test email arrives in the configured inbox within 2 minutes
**Plans**: TBD

### Phase 5: SEO, Schema and Performance
**Goal**: The page passes Core Web Vitals on mobile, all metadata is correctly configured, and search engines and social platforms can correctly parse the site identity
**Depends on**: Phase 4
**Requirements**: SEO-01, SEO-02, SEO-03, SEO-04, SEO-05
**Success Criteria** (what must be TRUE):
  1. The document has exactly one H1 in the hero section; every content section has an H2; cards and sub-sections use H3 — validated by browser outline or accessibility tool
  2. Pasting the page URL into the Schema Markup Validator (validator.schema.org) returns a valid Organization entity with name, url, logo, contactPoint, and areaServed
  3. Pasting the page URL into the Facebook Sharing Debugger returns the correct og:title, og:description, and og:image (1200x630) with no missing tag warnings
  4. Running Lighthouse mobile audit returns a Performance score of 90 or higher; no CLS issues from images; fonts load with font-display:swap
**Plans**: TBD

### Phase 6: Pre-Launch Hardening
**Goal**: Every integration point works correctly from the production domain under production-like conditions — no failures that were passing in development
**Depends on**: Phase 5
**Requirements**: (no new requirements — verification of all prior phases against production conditions)
**Success Criteria** (what must be TRUE):
  1. A `fetch()` call from the production frontend domain to the WordPress REST API returns data with no CORS error in the browser console
  2. Submitting the contact form from the production URL delivers an email to the real client inbox (not spam) within 2 minutes
  3. The WP admin login URL is the customized path; WordPress user enumeration via `/wp-json/wp/v2/users` is blocked; Wordfence and UpdraftPlus are active and confirmed in the admin
  4. The page loads without horizontal scroll on a real mobile device (iPhone or Android); all anchor nav links scroll to the correct section with the sticky header offset applied
**Plans**: TBD

## Progress

**Execution Order:**
Phase 1 and Phase 2 run in parallel. Phase 3 starts after both complete. Phases 4 → 5 → 6 are sequential.

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. Design System + Static Shell | 2/5 | In Progress|  |
| 2. WordPress Backend Setup | 0/TBD | Not started | - |
| 3. API Integration Layer | 0/TBD | Not started | - |
| 4. Section Integration | 0/TBD | Not started | - |
| 5. SEO, Schema and Performance | 0/TBD | Not started | - |
| 6. Pre-Launch Hardening | 0/TBD | Not started | - |

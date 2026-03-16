# Project Research Summary

**Project:** FN Mining Advisor (Nuñez Mining Consulting)
**Domain:** B2B Senior Mining/Metallurgical Consultancy — Headless WordPress + Vanilla JS Corporate Landing Page
**Researched:** 2026-03-16
**Confidence:** HIGH (stack and architecture), MEDIUM (features, B2B mining specifics)

## Executive Summary

FN Mining Advisor is a single-page B2B corporate landing page for a senior mining/metallurgical consultant targeting Chilean and Latin American mining companies. The recommended build approach is a semi-decoupled WordPress backend (REST API + ACF for structured content) paired with a static vanilla HTML/CSS/JS frontend — no build tool, no framework. This is a deliberate, well-matched architecture for the project: it keeps frontend performance high, respects the no-framework constraint, eliminates toolchain complexity, and positions WordPress as a headless CMS that the client can self-manage. The primary technical risk is the WordPress-to-frontend integration layer (CORS, ACF REST visibility, error handling), which must be designed intentionally from the start rather than bolted on.

The core conversion driver for this product is trust, not volume. The target audience is technical B2B decision-makers (mine owners, project managers, metallurgical engineers) who evaluate credibility within seconds based on credentials, specificity, and design quality. This means the most valuable features are the consultant's named profile, explicit service descriptions with technical language, the methodology section (especially the NDA-first step), and a clear "Request Diagnosis" CTA — not animations, chat widgets, or testimonial carousels. The graphite/gold custom palette and Cormorant+Inter typography are already correctly differentiated from generic consulting templates; the principal risk is abandoning these under deadline pressure.

The top mitigation priorities are: (1) lock the design system and CSS tokens before building any section, (2) implement the progressive enhancement pattern for all above-the-fold content (static HTML as default, REST API as enhancement), and (3) harden the WordPress backend before any content is published. These three decisions, made early, prevent the highest-cost recovery scenarios identified in the pitfalls research.

---

## Key Findings

### Recommended Stack

The stack is WordPress 6.9 as a headless CMS served via its built-in REST API, with ACF Free 6.x providing structured field groups exposed to the REST API via the "Show in REST API" toggle (no extra plugin required). The frontend is plain HTML, CSS with custom properties, and vanilla JavaScript ES modules — no transpilation, no bundler, no build step. Contact Form 7 handles form submission via its native REST endpoint. WP Mail SMTP ensures email deliverability. Wordfence provides a free endpoint-based WAF.

This stack is fully aligned with the project constraint (vanilla JS) and the content type (infrequently updated corporate landing page). The critical version note is PHP 8.2+ for WordPress 6.9 — verify the hosting environment before setup. ES modules are native in all modern browsers; no IE11 concern for a LatAm B2B mining audience in 2026.

**Core technologies:**
- WordPress 6.9 + REST API: headless CMS backend — client-familiar, REST API is stable and built-in since WP 4.7
- ACF Free 6.x: structured field groups for all content sections — free tier covers all phase 1 needs; REST exposure is built-in
- Vanilla HTML/CSS/JS (ES2022+): frontend rendering — no build complexity, fetch + ES modules is sufficient for a 9-section landing page
- Contact Form 7: REST endpoint form submission — only free WP form plugin with a native REST endpoint for headless use
- WP Mail SMTP: email deliverability — WordPress PHP mail fails silently on most shared hosts without this
- Wordfence Free: security WAF + malware scanner — endpoint-based WAF active from installation, no cloud dependency

### Expected Features

The primary conversion action is first contact (call or email inquiry). Every feature decision should be evaluated against whether it builds trust or creates friction for a senior mining professional evaluating a consultant for a high-stakes engagement.

**Must have (table stakes):**
- Named consultant profile with professional photo and credentials — anonymity destroys trust in B2B professional services; non-negotiable
- Hero section with specific value proposition — visitors decide in 5 seconds; must name what, for whom, and where
- 4 service descriptions with technical specificity — generic "mining consulting" copy is invisible to the target audience
- Methodology section (4 steps, NDA first) — reduces perceived risk; the NDA-first step is a strong differentiator
- Contact form + direct contact details (phone/email) — dual conversion paths; real phone number with +56 prefix is a trust signal in LatAm B2B
- WhatsApp link — expected in LatAm B2B; very high impact for very low effort
- Mobile-responsive design — 40-60% of initial B2B research is on mobile in LatAm
- Spanish primary language — required; English-only signals misalignment with target market
- Basic SEO: meta title, description, H1/H2 hierarchy, Organization schema

**Should have (competitive differentiators):**
- Confidentiality emphasis callout ("NDA desde el primer contacto") — rare to see stated upfront; strong trust signal in mining M&A contexts
- Insights section placeholder (2-3 static cards, WP REST ready) — signals thought leadership even before dynamic content is live
- Technical specialization terminology in copy (comminution, flotation, SX-EW, NI 43-101) — specificity signals expertise; generic language signals junior
- "Diagnóstico inicial" CTA instead of generic "contact us" — specific offer reduces friction; aligns with methodology
- Credential/institutional logos (if assets available) — instant credibility at a glance for university and certification affiliations
- Person + Organization schema markup — 30-minute implementation with meaningful SEO and branded search benefit

**Defer to v2+:**
- WordPress REST API dynamic integration (fully live) — the Insights section can launch with static placeholder cards; dynamic content is v1.x once the consultant has articles to publish
- Case studies / project portfolio — requires confidentiality agreements and documented examples
- Full English version — lower priority unless foreign-invested project inquiries materialize
- CRM integration — relevant only once inquiry volume creates pipeline management need

### Architecture Approach

The architecture is a clean two-layer system: a static frontend (HTML shell + CSS modules + vanilla JS section modules) that fetches from a headless WordPress REST API backend. All `fetch()` calls are centralized in `src/api/client.js` with an in-memory cache. A `transforms.js` layer normalizes raw WordPress REST responses (which include noise, nested ACF keys, and inconsistent shapes) into clean plain objects before they reach section render functions. Every section is independently initialized via `Promise.allSettled()` — one failed API call does not block others. All above-the-fold sections use progressive enhancement: static HTML content is the default state, the REST API overwrites with live content when available.

**Major components:**
1. `index.html` (shell) — static structural skeleton with 9 section wrappers; all critical copy present as default HTML; JS enhances, not replaces
2. `src/api/` (client + endpoints + transforms) — isolated network layer; single source of truth for WP URL, headers, caching, and response normalization
3. `src/sections/` (hero, services, insights, contact) — one module per section; each independently fetchable, independently fallback-capable
4. `css/tokens.css` (design tokens) — all brand variables as CSS custom properties; enables FN-to-NMC rebrand by changing one file
5. WordPress backend (WP + ACF + CF7 + plugins) — headless CMS; frontend-agnostic; replaceable without touching frontend architecture
6. `wp-setup/` (ACF JSON exports + CPT plugin) — WordPress configuration in version control; reproducible setup

### Critical Pitfalls

1. **WordPress user endpoint exposes admin credentials by default** — disable `/wp/v2/users` and `/wp/v2/users/{id}` endpoints explicitly in `functions.php` before any content is published; also disable XML-RPC which has no use on this site
2. **CORS misconfiguration silently blocks all API requests on staging/production** — decide the origin architecture (same-domain vs. subdomain) before writing any fetch calls; add explicit `Access-Control-Allow-Origin` in `functions.php` for the frontend domain; test in staging with production-like origins
3. **ACF "Show in REST API" exposes internal fields indiscriminately** — create separate ACF field groups for public (REST-enabled) and internal/admin (REST-disabled) fields; audit the `acf` key in API responses with `curl | jq .acf` before launch
4. **Flash of empty content when API is slow or fails** — hero and all above-the-fold sections must have real content in static HTML; use the progressive enhancement pattern (static default + API enhancement); never build a section whose only content source is the API
5. **Generic visual identity drift under deadline pressure** — CSS design tokens (graphite/gold, Cormorant/Inter) must be locked and signed off before any section HTML is built; a late visual redesign is the highest-cost recovery scenario in the pitfalls research

---

## Implications for Roadmap

Based on cross-research analysis, the build has 6 clear phases with hard dependencies between them. Phases 1 and 2 can proceed in parallel; Phase 3 is the merge point; Phases 4-6 are sequential from there.

### Phase 1: Design System and Static Shell

**Rationale:** All pitfalls research points to CSS tokens and the progressive enhancement HTML shell as foundational decisions. Building any section before these are locked creates rework. The design identity (graphite/gold palette, Cormorant+Inter typography) is already decided in PROJECT.md — the risk is implementation drift, which is prevented by making tokens the first artifact.
**Delivers:** `css/tokens.css` with full brand token set; `css/reset.css`, `css/layout.css`; `index.html` shell with all 9 section wrappers and real static copy baked in; sticky nav with primary CTA; mobile-responsive layout foundation
**Addresses:** Hero (static), about, services layout (static), methodology (static), contact section structure
**Avoids:** Generic visual identity drift (Pitfall 6); flash of empty content (Pitfall 4); CTA hierarchy confusion (Pitfall 5)
**Research flag:** Standard patterns — skip phase research. CSS custom properties and BEM are well-documented.

### Phase 2: WordPress Backend Setup

**Rationale:** Can run in parallel with Phase 1. WordPress must be installed, configured, and seeded with real content before Phase 3 (API integration) can be tested. Security hardening must happen before any public-facing URL exists. ACF field group architecture (public REST-enabled vs. internal REST-disabled) must be designed now — retrofitting it later is the third-highest-cost recovery.
**Delivers:** WordPress 6.9 installed; ACF Free configured with field groups for hero, services, methodology, insights; Custom Post Types `servicio` and `insight` registered; 4 services + 3 insights seeded; `wp-json/wp/v2/` endpoints verified; security hardening complete (users endpoint disabled, XML-RPC off, SMTP configured, Wordfence active)
**Addresses:** Content management, form backend, SEO plugin (Rank Math), email deliverability
**Avoids:** User endpoint exposure (Pitfall 1); ACF over-exposure (Pitfall 3); contact form email delivery failure; CORS origin decision (document here)
**Research flag:** Needs attention during planning — specifically the CORS strategy decision (same-domain vs. subdomain) and the ACF field group schema for each section.

### Phase 3: API Integration Layer

**Rationale:** This is the merge point between Phase 1 (frontend shell) and Phase 2 (WordPress backend). Cannot start until both Phase 1 (DOM targets exist) and Phase 2 (live endpoints with real data exist). The transforms layer must be built against real WP responses, not assumed shapes.
**Delivers:** `src/api/client.js` (base fetch, in-memory cache, error handling); `src/api/endpoints.js` (named constants, no magic strings); `src/api/transforms.js` (WP response → clean UI objects, tested against live WP); CORS headers confirmed working from staging origin
**Avoids:** Hardcoded WP URL strings (anti-pattern 3); WP response shape leaking into UI code (anti-pattern 2); CORS misconfiguration (Pitfall 2)
**Research flag:** Standard patterns — well-documented. The transform shapes are defined in ARCHITECTURE.md.

### Phase 4: Section Integration

**Rationale:** Sections can be integrated in any order once Phase 3 is complete. Each section module is independently testable. The `Promise.allSettled()` concurrent initialization pattern means no single section blocks others.
**Delivers:** `hero.js`, `services.js`, `insights.js` — each fetching from WP REST API, running transforms, updating DOM while static fallback remains intact; `contact.js` — CF7 REST endpoint integration with success/error states; all sections verified against offline WP (static fallback test)
**Avoids:** Fetch waterfall (anti-pattern 1); silent error failures (Pitfall 7); no loading state on fetch (Pitfall 4)
**Research flag:** Standard patterns for hero, services, contact. Insights section is lowest priority — can defer to v1.x if the consultant has no articles ready at launch.

### Phase 5: SEO, Schema, and Performance

**Rationale:** Should happen after sections are integrated (correct H1/H2 structure is confirmed) but before launch. Schema markup and Open Graph are easy to implement and have outsized value for a branded-search use case (consultant's name + domain association). Performance optimization targets Core Web Vitals pass — LCP and CLS are the primary risks.
**Delivers:** Rank Math configured (Organization schema, meta title/description per page, XML sitemap); Person + Organization JSON-LD schema; Open Graph tags (1200x630 OG image for WhatsApp preview); hero image optimized (WebP, <150KB, `fetchpriority="high"`); all `<img>` elements have explicit width/height; `scroll-padding-top` set for sticky nav offset; Lighthouse mobile ≥90
**Avoids:** Layout shift from images (performance trap); hero LCP failure (performance trap); missing OG image for WhatsApp link preview
**Research flag:** Standard patterns — skip phase research.

### Phase 6: Pre-Launch Hardening and QA

**Rationale:** The "looks done but isn't" checklist from PITFALLS.md defines this phase. Multiple integration points that appear correct in development fail in production-like conditions.
**Delivers:** Full PITFALLS.md verification checklist completed; CORS tested from production domain; ACF response audited for internal field exposure; contact form end-to-end tested with real SMTP to real inbox; mobile nav verified (sticky header + anchor scroll); WP login hardened (URL changed, 2FA enabled); schema validated at validator.schema.org; WhatsApp link preview confirmed
**Avoids:** All "looks done but isn't" failures from PITFALLS.md
**Research flag:** No research needed — this is verification against the research already done.

### Phase Ordering Rationale

- Phases 1 and 2 are parallel because frontend shell has no API dependency and WordPress setup has no frontend dependency. Starting both immediately halves calendar time.
- Phase 3 cannot start until both Phase 1 (DOM targets) and Phase 2 (real API data) exist — building transforms against assumed shapes leads to rework.
- Phase 4 (section integration) follows Phase 3 because it depends on the API client and transforms being tested and correct.
- Phase 5 (SEO/performance) follows Phase 4 because correct heading hierarchy and dynamic images must be in place before auditing.
- Phase 6 (QA) is last by definition — it verifies everything.

### Research Flags

Phases likely needing deeper research during planning:
- **Phase 2 (WordPress Setup):** The CORS origin architecture decision (same-domain vs. subdomain) has deployment and hosting cost implications that depend on the client's hosting provider. Also, ACF field group schema design for the repeater-equivalent patterns (methodology steps, value props) needs concrete decisions since ACF Free lacks Repeater fields — this requires designing around the limitation with indexed ACF sub-fields or a custom post type approach.

Phases with standard patterns (skip research-phase):
- **Phase 1 (Design System):** CSS custom properties and BEM are thoroughly documented; token architecture is already specified in STACK.md.
- **Phase 3 (API Layer):** WordPress REST API + `fetch()` + transforms are a well-established pattern; full implementation examples exist in ARCHITECTURE.md.
- **Phase 4 (Section Integration):** Each section follows the same pattern; ARCHITECTURE.md contains working code examples for all sections.
- **Phase 5 (SEO/Performance):** Rank Math configuration and Core Web Vitals optimization are well-documented standard procedures.
- **Phase 6 (QA):** Defined by the PITFALLS.md checklist — no new research needed.

---

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | WordPress REST API + ACF + CF7 + vanilla JS pattern is mature and well-documented. Plugin selections are verified against official sources. PHP 8.2+ requirement confirmed. |
| Features | MEDIUM-HIGH | Table stakes and anti-features are HIGH confidence (established B2B patterns). LatAm-specific norms (WhatsApp, Spanish primary) are HIGH confidence. Mining sector specifics (technical copy, relationship-driven culture) are MEDIUM (training data, not live audit). |
| Architecture | HIGH | Progressive enhancement shell, transforms layer, concurrent fetch pattern — all well-documented with official source backing. CORS configuration is confirmed pattern. |
| Pitfalls | HIGH (technical), MEDIUM (UX/design) | Security pitfalls sourced from official WP docs and verified security advisories. Performance traps from official WP and web.dev guidance. UX/design pitfalls from B2B consulting research — MEDIUM confidence, but internally consistent. |

**Overall confidence:** HIGH for technical execution. MEDIUM for LatAm B2B mining market specifics (verified against training data, not live competitor audit).

### Gaps to Address

- **CORS strategy must be decided before Phase 2 begins:** Same-domain deployment (frontend served by WP) vs. subdomain separation has hosting and deployment implications. Document this decision in the Phase 2 plan before writing any fetch calls. If the client's host supports subdomain configuration easily, separate the domains for clean architecture. If not, same-domain is simpler and eliminates CORS entirely.
- **ACF Free repeater limitation:** ACF Free lacks the Repeater field type. The methodology steps (4 steps with number, title, description) and value props (icon, title, text arrays) need a workaround: either indexed grouped fields (e.g., `step_1_title`, `step_1_description`, `step_2_title`...) or a Custom Post Type per step. The indexed fields approach is simpler and sufficient for a fixed 4-step methodology. Confirm this pattern during Phase 2 planning.
- **Consultant asset availability:** Credential/institutional logos and a professional headshot photo are required for the profile and credentials sections. These must be sourced from the consultant before Phase 1 section content is finalized. Placeholder layout is fine for development; the assets are needed before launch.
- **Chilean data protection law (Ley 19.628):** FEATURES.md notes LOW confidence on whether GDPR-style cookie consent is required. Recommendation: launch without analytics cookies (no consent banner needed); verify with a Chilean lawyer before adding Google Analytics.
- **Hosting environment:** PHP 8.2+ is required. Verify the client's host supports this before WordPress installation. Shared hosting without object cache (Redis/Memcached) will produce slow REST API responses (400-800ms); plan to address with WP REST Cache plugin or transients if WP Rocket is not in budget.

---

## Sources

### Primary (HIGH confidence)
- WordPress REST API Handbook (developer.wordpress.org/rest-api/) — endpoint structure, CORS, global parameters (`_fields`)
- ACF Documentation (advancedcustomfields.com/resources/wp-rest-api-integration/, March 2025) — REST API integration, `show_in_rest`, `acf_format=standard`
- ACF Practical Guide to REST API Resource Modeling (advancedcustomfields.com/blog/rest-api-resource/, August 2025) — field group design
- Contact Form 7 REST endpoint — confirmed in CF7 official documentation and multiple implementation tutorials (Nov 2024 – Sep 2024)
- WordPress Security — Acunetix user enumeration advisory; SolidWP XML-RPC guidance (Jan 2025); official WP developer docs

### Secondary (MEDIUM confidence)
- Rank Math vs. Yoast SEO comparisons (2025) — multiple review sites confirming Rank Math free tier advantages
- Wordfence vs. Sucuri comparisons — kinsta.com, elegantthemes.com (2025)
- B2B landing page best practices — Directive Consulting (Nov 2025), GetUplift CTA psychology (Oct 2025)
- B2B consulting website patterns — Consulting Success (Oct 2025), Advertai Marketing (Mar 2026)
- WordPress REST API performance pitfalls — webhosting.de (Jan 2026, Mar 2026), MOSS (Dec 2025)
- CORS for WordPress REST API — WordPress Stack Exchange (multiple verified answers)
- Web.dev — Core Web Vitals, progressive enhancement, LCP optimization

### Tertiary (LOW confidence)
- Chilean data protection law (Ley 19.628) — requires legal verification before implementation
- CSS BEM + custom properties for corporate sites — community consensus (Smashing Magazine Jun 2025, CSS-Tricks), training data
- LatAm B2B WhatsApp usage patterns — training data through August 2025; not live-verified

---

*Research completed: 2026-03-16*
*Ready for roadmap: yes*

# Pitfalls Research

**Domain:** Decoupled WordPress + Vanilla JS — B2B Mining/Engineering Consultancy Landing Page
**Researched:** 2026-03-16
**Confidence:** HIGH (technical pitfalls from official docs and verified community sources); MEDIUM (design/trust pitfalls from B2B pattern analysis)

---

## Critical Pitfalls

### Pitfall 1: WordPress REST API Exposes User Credentials by Default

**What goes wrong:**
The `/wp-json/wp/v2/users` endpoint is publicly accessible by default and returns all registered usernames, user IDs, and display names. For a site used as a headless CMS backend, this directly enables brute-force and credential-stuffing attacks. Attackers enumerate users via the API and then target `/wp-login.php` or XML-RPC.

**Why it happens:**
Developers focus on connecting the frontend to the API and never audit what the API publishes. The users endpoint is a legitimate feature for multi-author sites, but it is an attack surface when WordPress is a private backend.

**How to avoid:**
Disable the `/wp/v2/users` endpoint explicitly in `functions.php`:
```php
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});
```
Also disable XML-RPC entirely via plugin (Disable XML-RPC-API) since this site does not need remote publishing.

**Warning signs:**
Visiting `https://your-wp-domain.com/wp-json/wp/v2/users` returns a JSON array with admin user data.

**Phase to address:** WordPress Setup phase (before any content is published or the domain goes live).

---

### Pitfall 2: CORS Misconfiguration Blocks Frontend Requests

**What goes wrong:**
When the HTML frontend is served from one origin (e.g., `fnminingadvisor.cl`) and the WordPress REST API is on another (e.g., `cms.fnminingadvisor.cl` or a subdomain), the browser blocks `fetch()` calls with a CORS error. The frontend shows blank sections silently. Development works fine because both run on the same origin or localhost.

**Why it happens:**
WordPress sends permissive CORS headers by default (`Access-Control-Allow-Origin: *`) for its own domains, but this breaks down when origins differ or when a CDN, reverse proxy, or `.htaccess` rule strips or overrides headers. Also, some shared hosts block wildcard CORS headers at the server level.

**How to avoid:**
Define the origin relationship at the start. Options ranked by preference:
1. Serve both frontend and WP API from the same domain (frontend at root, WP at `/cms/` or a subdomain) — eliminates CORS entirely.
2. If cross-origin is unavoidable, add a `rest_api_init` hook to set explicit `Access-Control-Allow-Origin` to only the frontend domain (not `*`).
3. Never set `Access-Control-Allow-Origin: *` in production when the API returns content that could be sensitive.

Test CORS in a staging environment that mirrors the production origin configuration before launch.

**Warning signs:**
Browser DevTools shows `blocked by CORS policy: No 'Access-Control-Allow-Header'` on any `fetch` to `/wp-json/`. Sections load in localhost but not on staging.

**Phase to address:** WordPress Setup phase — document origin architecture decision before writing any fetch calls.

---

### Pitfall 3: ACF Fields Exposed Indiscriminately via REST API

**What goes wrong:**
When ACF field groups have "Show in REST API" enabled, every field in the group is included in API responses — including internal notes, draft fields, admin-only metadata, or fields intended only for backend workflows. If a field group is enabled for all post types, private fields appear in every public endpoint.

**Why it happens:**
ACF's "Show in REST API" toggle is per field group, not per field. Developers enable it for convenience and don't audit the resulting API response. ACF Pro (and the Secure Custom Fields fork maintained by WordPress.org since WP acquired it) allows more granular control, but defaults are broad.

**How to avoid:**
- Enable "Show in REST API" only on field groups that the frontend explicitly consumes.
- Create separate field groups for public content fields and internal/admin fields. Keep internal groups REST-disabled.
- Audit API responses with `curl https://your-wp-domain.com/wp-json/wp/v2/posts/1 | jq .acf` before launch.
- For the hero, services, and insights sections of this project, create dedicated REST-enabled field groups with only the required fields.

**Warning signs:**
The ACF object in API responses contains field keys you did not plan to use in the frontend. Internal notes or draft status fields appear in public JSON.

**Phase to address:** WordPress Setup phase — field group architecture must be designed with REST visibility in mind from the start.

---

### Pitfall 4: Flash of Empty Content (No Loading State in Vanilla JS Fetch)

**What goes wrong:**
The page loads HTML/CSS instantly, but sections that depend on WordPress REST API data (hero headline, service cards, insights) briefly render empty — either blank containers or placeholder text before JavaScript runs and populates them. On slow connections this lasts 1–3 seconds. For a B2B consultancy, this feels broken and erodes trust before the user reads anything.

**Why it happens:**
Vanilla JS `fetch()` is asynchronous. Without a deliberate loading strategy, the DOM renders empty containers until the API responds. React frameworks handle this with Suspense/skeletons, but in vanilla JS it requires explicit planning.

**How to avoid:**
Two approaches, in order of preference:
1. **Embed critical content as static HTML** — write the hero headline, value proposition, and services content directly in the HTML file as the default state. WordPress REST API then hydrates or replaces this content when loaded. If the API fails, the page still shows meaningful content.
2. **Skeleton placeholders** — use CSS animated grey blocks in the HTML that are replaced when API data arrives. Implement in JavaScript using a two-state pattern: render skeleton → fetch → swap in real content.

For this project (single landing, non-authenticated, public content), option 1 is strongly preferred. The content changes infrequently. Reserve REST API fetching for the Insights/Blog section which updates regularly.

**Warning signs:**
Throttle network to "Slow 3G" in DevTools — any section that shows empty boxes or no text for more than 300ms needs a loading strategy.

**Phase to address:** Frontend Architecture phase — decide the content delivery model (static embed vs. dynamic fetch) per section before writing JS.

---

### Pitfall 5: Multiple Competing CTAs Diffuse Conversion Intent

**What goes wrong:**
The landing page includes a primary CTA ("Request Diagnosis"), a secondary CTA per service card, a contact form, and social links — all presented with equal visual weight. B2B visitors with high purchase intent are deflected by choice overload. Conversion rates drop because the page fails to guide the visitor toward one clear action.

**Why it happens:**
Designers try to accommodate "different visitor types" and add multiple paths. On a consultancy landing page serving a narrow B2B audience (mining project managers, mine owners), visitors have a predictable intent: evaluate credibility, then contact. Multiple CTAs serve the designer's anxiety, not the visitor's need.

**How to avoid:**
- Define one primary conversion action for the entire page: the contact/diagnosis CTA.
- Service cards can link to anchored sections within the same page, not to separate CTAs.
- Secondary actions (LinkedIn, downloadable brochure) must be visually subordinate — text links, not buttons.
- The sticky header CTA and the footer CTA must use identical copy and destination to reinforce one action.
- Forms with fewer than 5 fields convert 35–45% better (B2B benchmark data, 2025). For this project: name, company, email, phone, message — exactly 5 fields. Do not add more.

**Warning signs:**
If a client review session raises "we should add a CTA for X here" for every section, the primary conversion path is unclear. Count the number of distinct button/CTA elements — more than 3 distinct destinations on a single page is a red flag.

**Phase to address:** Design System / UX phase — define CTA hierarchy in the design system before building sections.

---

### Pitfall 6: Generic Corporate Aesthetic That Signals "Agencia, No Consultora Senior"

**What goes wrong:**
The site uses stock photography of miners or hard hats, generic icons (gears, graphs, handshakes), Montserrat/Open Sans on a white background, blue brand color — and looks identical to 10,000 other consulting websites. The B2B buyer for a senior metallurgical consultant evaluates expertise at a glance. Generic design signals "low bid contractor," not "senior technical authority."

**Why it happens:**
Templates and stock art are fast and cheap. The Freepik/Shutterstock standard for "mining" returns predictable clichés. Developers focus on building the site, not differentiating the brand.

**How to avoid:**
- Enforce the custom palette (grafito/dorado mineral) and typography (Cormorant Garamond + Inter) decisions already made in PROJECT.md. These choices are already correctly differentiated — the risk is abandoning them under deadline pressure.
- All stock photography must reference actual metallurgical/processing contexts (flotation cells, mill circuits, core samples), not generic "construction worker with helmet" images.
- Avoid decorative icons entirely for service cards — use precise technical language and typography weight/size to differentiate sections instead.
- The design system must be locked in CSS custom properties before any section is built, so the visual identity cannot drift per component.

**Warning signs:**
Client sees early mockups and says "looks professional but kind of generic." Any use of blue as a brand color, any Montserrat as the primary typeface, any hands-shaking or gear icon.

**Phase to address:** Design System phase — CSS variables and typography scale must be locked before any HTML content sections are built.

---

### Pitfall 7: No Error Handling for REST API Failures Means Silent Broken Sections

**What goes wrong:**
`fetch()` calls to WordPress fail silently — the promise rejects, the section remains empty, and no error is shown to the user. On a production site, this happens when: the WordPress host is slow, WP maintenance mode is on, a plugin breaks the REST API, or a deployment has a misconfigured `.htaccess`. The page looks partially built.

**Why it happens:**
Error handling is added "later" and then forgotten. Vanilla JS has no global error boundary. Each `fetch()` call needs explicit `.catch()` handling.

**How to avoid:**
Every fetch call must implement three states: loading state, success state, error state. For the error state on a public landing page, the fallback is to show the static embedded content (from Pitfall 4 prevention) rather than an error message. The API call should enhance the page, not be required for it to function.

Pattern to implement:
```js
// Fetch enhances static content; failure returns gracefully to static defaults
async function hydrateSectionFromAPI(endpoint, renderFn, fallbackEl) {
    try {
        const res = await fetch(endpoint);
        if (!res.ok) return; // fail silently, static content remains
        const data = await res.json();
        renderFn(data);
    } catch {
        return; // network error, static content remains
    }
}
```

**Warning signs:**
Any `fetch()` call in the codebase without a `.catch()` or try/catch. Any section that has no visible content in the HTML file itself (content comes only from the API).

**Phase to address:** Frontend Integration phase — error handling pattern must be defined before writing any API integration code.

---

## Technical Debt Patterns

| Shortcut | Immediate Benefit | Long-term Cost | When Acceptable |
|----------|-------------------|----------------|-----------------|
| Hardcode all content in HTML, skip REST API integration | Faster build, no backend dependency | Content updates require code deploys; client cannot self-edit | Never — defeats the purpose of WordPress as CMS |
| Use `Access-Control-Allow-Origin: *` for CORS | Fixes CORS instantly | Security exposure; any domain can read API data | Only in local development |
| Enable "Show in REST API" on all ACF field groups | No configuration needed | Exposes internal fields; oversized API payloads | Never |
| Skip loading/error states in fetch calls | Faster to build | Broken sections on slow networks or API failures | Never on production |
| Use stock photos as placeholders, plan to replace later | Saves time early | "Later" never comes; client approves with placeholders; site ships generic | Only in internal wireframes, never in client-facing reviews |
| Implement all sections as API-driven (no static fallback) | Single source of truth in WP | Page breaks if WP is down; poor Core Web Vitals (LCP delayed) | Never for above-the-fold content |
| Skip `_fields` parameter on REST API calls | Simpler fetch code | Oversized JSON payloads (posts return 40+ fields when you need 5) | Never — always filter fields in production |

---

## Integration Gotchas

| Integration | Common Mistake | Correct Approach |
|-------------|----------------|------------------|
| WordPress REST API + ACF | Call `/wp/v2/posts` and expect ACF fields to appear automatically | ACF fields only appear in REST API responses when "Show in REST API" is explicitly enabled per field group in the ACF UI |
| WordPress REST API + CORS | Rely on WordPress default CORS headers | Explicitly define and test origin headers in the environment where frontend and backend have different origins; test CORS in staging, not just localhost |
| Vanilla JS `fetch` + WP REST | Fetch full post objects and parse HTML content | Use `_fields` query parameter to request only needed fields: `/wp-json/wp/v2/posts?_fields=id,title,acf,featured_media` |
| Contact form + PHP/SMTP | Use WordPress default mail functions without SMTP plugin | WordPress `wp_mail()` relies on server PHP mail, which is blocked by most shared hosts; install WP Mail SMTP with a transactional service (Resend, Mailgun) from day one |
| Sticky nav + anchor links | Hard-code pixel offsets for scroll-to-anchor behavior | Use CSS `scroll-padding-top` on `:root` equal to the sticky nav height; updates automatically if nav height changes |
| CSS custom properties + IE | Use CSS variables assuming broad browser support | CSS custom properties have no IE11 support — not relevant for a 2026 B2B mining site in LATAM where IE is dead, but confirm client's user base if unsure |

---

## Performance Traps

| Trap | Symptoms | Prevention | When It Breaks |
|------|----------|------------|----------------|
| Multiple uncached REST API calls on page load | Visible content-loading delay (>500ms), high TTFB on WP | Batch related data into custom endpoints; use `?_fields=` to reduce payload; implement server-side caching (WP REST Cache plugin or transients) | From first visitor — no scale threshold needed |
| Hero section content loaded via API (above-the-fold) | LCP score fails Core Web Vitals; hero appears after JS executes | Hero content must be in static HTML; use API only for below-the-fold sections or non-critical content like Insights | Every page load |
| No image dimensions in HTML for API-sourced images | Layout shift (CLS) as images load and push content down | Always set `width` and `height` attributes on `<img>` elements, even when `src` is dynamically set | Every page load on slow connection |
| WordPress without object cache on shared hosting | REST API responses take 400–800ms even for cached content | Enable Redis or Memcached via hosting panel; if unavailable, use WP REST Cache plugin with transients | Day one — shared hosting without object cache is slow by default |
| Large hero image not optimized | LCP >2.5s, especially on mobile | Hero image must be WebP, <150KB, with `loading="eager"` and `fetchpriority="high"` attributes | Mobile on 4G |

---

## Security Mistakes

| Mistake | Risk | Prevention |
|---------|------|------------|
| WordPress admin at `/wp-admin` with default login URL | Brute-force attacks on login page; credential stuffing | Change admin URL with WPS Hide Login plugin; enforce strong password; enable 2FA for admin user |
| XML-RPC enabled when not needed | Amplification attacks, brute-force via multicall | Disable XML-RPC entirely with a plugin (Disable XML-RPC-API); this site has no remote publishing need |
| REST API user endpoint active | User enumeration; reveals admin username for brute-force | Disable `/wp/v2/users` endpoint (see Pitfall 1 code snippet) |
| WordPress version number visible in meta tags and REST API responses | Attackers know which CVEs apply | Add `remove_action('wp_head', 'wp_generator')` in `functions.php`; filter REST API to remove version field |
| Debug mode (`WP_DEBUG=true`) left on in production | PHP errors exposed in HTTP responses; information leakage | Set `WP_DEBUG=false` in `wp-config.php` for production; use a log file, not screen output |
| Contact form submissions without rate limiting | Spam and abuse; server load from bots | Use a honeypot field (not CAPTCHA — adds friction) plus server-side rate limiting; Contact Form 7 with Flamingo for logging |
| Frontend `.env` or API credentials in public JS | Credentials exposed in browser source | WordPress REST API for public content requires no authentication; never put WP application passwords in frontend JS |

---

## UX Pitfalls

| Pitfall | User Impact | Better Approach |
|---------|-------------|-----------------|
| Vague hero headline ("Soluciones integrales para la industria minera") | B2B visitor cannot determine in 3 seconds if this firm solves their specific problem | Lead with the concrete outcome for the target client: what changes for them after engaging FN Mining Advisor |
| No social proof above the fold | High-intent B2B visitors need evidence early; they will not scroll to find it | Include a compact proof element in or immediately below the hero — past project scale, client company logos, or a single specific result |
| Contact form as the only conversion path | Visitors who are not yet ready to contact have no lower-friction engagement option | Include one lower-friction alternative: a LinkedIn link to the consultant's profile or a downloadable capability statement (PDF) as a secondary micro-conversion |
| Service cards with identical structure and copy length | Cognitive sameness makes differentiation impossible; visitor cannot identify which service is relevant | Each service card must lead with the client's problem, not the consultant's process; vary emphasis by service seniority/priority |
| Mobile nav that hides all anchor links behind a hamburger menu | Organic scroll behavior on mobile is interrupted; visitors miss sections | Sticky nav on mobile should show at minimum the primary CTA button alongside the hamburger; the contact action must always be one tap away |
| Methodology section that describes process from consultant's POV | B2B buyer reads this as "how we work" not "what you get" | Reframe each step with the client benefit and deliverable, not the internal process description |

---

## "Looks Done But Isn't" Checklist

- [ ] **REST API connection:** Sections appear populated in development — verify they still populate when WordPress is on a different host/domain (CORS test in staging with production-like origins).
- [ ] **ACF field REST visibility:** API responses look correct — verify with `curl | jq .acf` that no internal admin fields are present in the public response.
- [ ] **Contact form delivery:** Form submits without error — verify an email actually arrives using a real SMTP transactional service, not PHP mail.
- [ ] **Mobile sticky nav:** Navigation looks correct at desktop — verify sticky header does not obscure anchor-linked section headings on mobile (test with `scroll-padding-top`).
- [ ] **Images with dimensions:** Images appear correctly in Chromium — test on Safari and Firefox with slow network; verify no layout shift (CLS > 0) from images without explicit dimensions.
- [ ] **Hero content without API:** Page renders correctly when API works — throttle network to offline in DevTools; verify hero section still shows meaningful content (not empty containers).
- [ ] **WordPress login hardened:** WP admin is accessible at default URL — confirm URL is changed, 2FA is enabled, XML-RPC is disabled, user endpoint is blocked.
- [ ] **Schema.org Organization markup:** HTML includes structured data — validate at https://validator.schema.org/ that Organization name, URL, and contact info are correct and parseable.
- [ ] **Open Graph tags:** Page shares correctly on WhatsApp — test with a WhatsApp link preview (OG image must be ≥1200×630px, hosted at a public URL).

---

## Recovery Strategies

| Pitfall | Recovery Cost | Recovery Steps |
|---------|---------------|----------------|
| CORS misconfiguration blocks frontend | LOW | Add `rest_api_init` CORS filter in `functions.php`; no data loss; fix takes <30 minutes |
| ACF fields over-exposed in REST API | LOW | Disable "Show in REST API" on specific field groups in WP admin; audit response with curl; no rebuild required |
| User endpoint exposure discovered post-launch | LOW | Add endpoint filter to `functions.php`; deploy; attack surface closed within hours |
| Content sections built without static fallbacks | MEDIUM | Requires refactoring each dynamic section to include static default HTML; estimated 2–4 hours per section |
| Contact form using PHP mail (no SMTP) | LOW | Install WP Mail SMTP; configure transactional provider; test; same day fix |
| Generic template aesthetic approved by client | HIGH | Visual redesign required; CSS token system in this project reduces scope, but significant revision of hero, typography, and imagery |
| Multiple CTA destinations dilute conversion | MEDIUM | Copy and design revision to establish single primary action; requires client alignment |

---

## Pitfall-to-Phase Mapping

| Pitfall | Prevention Phase | Verification |
|---------|------------------|--------------|
| WordPress user endpoint exposure | WordPress Setup | `curl /wp-json/wp/v2/users` returns 401 or 404 |
| XML-RPC attack surface | WordPress Setup | `curl -d '' https://domain.com/xmlrpc.php` returns 403 |
| ACF fields over-exposed | WordPress Setup — field group design | `curl /wp-json/wp/v2/posts/1 \| jq .acf` returns only expected fields |
| CORS misconfiguration | WordPress Setup + Frontend Architecture | Frontend fetch calls succeed from staging domain; no CORS errors in browser console |
| Flash of empty content (no loading state) | Frontend Architecture — content delivery model decision | Sections have visible HTML content before JavaScript executes (disable JS in browser, verify page is still meaningful) |
| No error handling on fetch calls | Frontend Integration | Kill WP server; verify landing page still renders with static content, no broken/empty sections |
| Generic visual identity drift | Design System | Design token file reviewed and locked; client signs off on font + palette before any section HTML is built |
| Multiple competing CTAs | Design System / UX | Page has exactly one primary button destination; all other links are text or visually subordinate |
| Contact form email delivery failure | WordPress Setup | End-to-end test email sent from form to real inbox using production SMTP config |
| Hero image performance (LCP) | Frontend Build | Lighthouse mobile score ≥90; LCP <2.5s on simulated 4G |

---

## Sources

- WordPress REST API User Enumeration — Acunetix (HIGH confidence, security advisory): https://www.acunetix.com/vulnerabilities/web/wordpress-rest-api-user-enumeration/
- Securing the WP REST API — Internet Dzyns, January 2025 (MEDIUM confidence): https://idzyns.com/how-to-secure-your-wordpress-rest-api-and-prevent-user-id-exposure/
- WordPress REST API Security: Data Leaks — Medium/Steve Jacob, May 2025 (MEDIUM confidence): https://medium.com/@stevejacob45678/wordpress-rest-api-security-protect-your-site-from-data-leaks-83156d2aee7d
- ACF REST API Integration — Official ACF docs, March 2025 (HIGH confidence): https://www.advancedcustomfields.com/resources/wp-rest-api-integration/
- ACF Practical Guide to REST API Resource Modeling — Official ACF blog, August 2025 (HIGH confidence): https://www.advancedcustomfields.com/blog/rest-api-resource/
- WordPress REST API Global Parameters (`_fields`) — Official WP developer docs (HIGH confidence): https://developer.wordpress.org/rest-api/using-the-rest-api/global-parameters/
- WordPress REST API Performance Pitfalls — webhosting.de, January 2026 (MEDIUM confidence): https://webhosting.de/en/wordpress-rest-api-performance-optimization-perfboost/
- WordPress REST Calls Frontend Performance — webhosting.de, March 2026 (MEDIUM confidence): https://webhosting.de/en/wordpress-rest-calls-frontend-performance-cacheboost/
- Server Optimization for WordPress REST API — MOSS, December 2025 (MEDIUM confidence): https://moss.sh/reviews/server-optimization-for-wordpress-rest-api/
- CORS for WordPress REST API — CORS issues discussion, WordPress Stack Exchange (HIGH confidence, multiple upvotes): https://wordpress.stackexchange.com/questions/385666/is-it-ok-to-restrict-access-control-allow-origin-for-wp-json-requests
- Disable XML-RPC — SolidWP, January 2025 (HIGH confidence): https://solidwp.com/blog/xmlrpc-php/
- Consulting Website Mistakes — Advertai Marketing, March 2026 (MEDIUM confidence): https://www.advertaimarketing.com/post/consulting-website-mistakes-that-cost-you-high-value-clients
- B2B Landing Page Best Practices — Directive Consulting, November 2025 (MEDIUM confidence): https://directiveconsulting.com/blog/blog-b2b-landing-page-best-practices-examples/
- B2B Sales Conversion Rate by Industry — SERP Sculpt, November 2025 (MEDIUM confidence): https://serpsculpt.com/reports/b2b-sales-conversion-rate-by-industry/
- CTA Psychology and Choice Overload — GetUplift, October 2025 (MEDIUM confidence): https://getuplift.co/the-psychology-of-a-cta-button/
- Building a Client-Generating Consulting Website — Consulting Success, October 2025 (MEDIUM confidence): https://www.consultingsuccess.com/consulting-website

---
*Pitfalls research for: Decoupled WordPress + Vanilla JS B2B Mining Consultancy Landing Page*
*Researched: 2026-03-16*

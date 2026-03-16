# Stack Research

**Domain:** Headless WordPress + Vanilla JS corporate landing page (mining/metallurgical consultancy)
**Researched:** 2026-03-16
**Confidence:** HIGH (WordPress/ACF core stack), MEDIUM (CSS architecture recommendations), HIGH (plugin recommendations)

---

## Recommended Stack

### Core Technologies

| Technology | Version | Purpose | Why Recommended |
|------------|---------|---------|-----------------|
| WordPress | 6.9 (Dec 2025) | CMS/backend — content management, REST API server, form handling | Client already knows WP; largest plugin ecosystem; REST API is mature and stable since WP 4.7; free to self-host. 6.9 is the current stable release. |
| WordPress REST API | Built-in (no plugin) | Content delivery to frontend via JSON endpoints | Ships with every WordPress install since 4.7. Endpoints like `/wp-json/wp/v2/pages`, `/wp-json/wp/v2/posts`, `/wp-json/wp/v2/{custom-type}` cover all read needs for this project. No extra plugin required for reads. |
| ACF (Advanced Custom Fields) Free | 6.x (latest on WP.org) | Structured content fields for hero, services, methodology, value props | The de facto standard for structured content in WordPress. Free version includes "Show in REST API" toggle per field group (available since ACF 5.11+). Exposes fields as `acf` key inside standard REST endpoints. No extra plugin needed for basic REST exposure. |
| Vanilla HTML/CSS/JS | ES2022+ (no transpilation) | Frontend — rendering, REST API consumption, interactivity | Matches project constraint. No build complexity, no dependency churn. `fetch()` + `async/await` + ES modules (`type="module"`) are fully supported in all modern browsers and provide everything needed for a corporate landing page. |
| PHP | 8.2+ | WordPress runtime | Required by WordPress. PHP 8.2 is minimum recommended for WP 6.9 with performance improvements. Host should provide this. |

### WordPress Plugins — Recommended Set

| Plugin | Version | Purpose | Why This One |
|--------|---------|---------|--------------|
| Advanced Custom Fields (ACF) | Free, 6.x | Structured field groups for all sections | Free version covers all needs: text, image, repeater-like groups with the free field types. REST API exposure is built-in. Only upgrade to Pro if Repeater or Flexible Content fields are needed (deferred to future phases). |
| Contact Form 7 (CF7) | 5.x (latest) | Contact form backend + REST API submission endpoint | CF7 exposes a native REST endpoint at `/wp-json/contact-form-7/v1/contact-forms/{id}/feedback` since version 4.7. Accepts `multipart/form-data` POST from vanilla JS `fetch()`. No API key required for form submission. Free. Better headless integration than WPForms Lite (which lacks a native REST endpoint in free tier). |
| Rank Math SEO | Free, latest | On-page SEO, schema Organization, meta tags, sitemap | Free tier includes: multiple focus keywords, schema markup (Organization, LocalBusiness), XML sitemap, meta title/description control, JSON-LD output. Consistently outperforms Yoast free in features-per-dollar. Relevant for this project: Organization schema for the consultancy. |
| Wordfence Security | Free, latest | Firewall, malware scanner, login protection | Free tier WAF (Web Application Firewall) is endpoint-based and active from installation — unlike Sucuri's free tier which lacks WAF. Covers brute force, malware scanning, REST API endpoint monitoring. 5M+ active installs, widely trusted. |
| WP Mail SMTP | Free (by WPForms), latest | Email deliverability for CF7 form notifications | WordPress uses `wp_mail()` which often fails without SMTP config. WP Mail SMTP fixes this with free tier supporting Gmail, Outlook, SendGrid, Mailgun. Critical for contact form notifications to actually arrive. Without this, CF7 emails go to spam or fail silently. |
| UpdraftPlus | Free, latest | Automated backups to cloud storage | Industry-standard free backup solution. Supports Google Drive, Dropbox, S3. Schedule daily/weekly automated backups. Essential before any content edits. |

### Frontend Architecture — Vanilla JS Module Structure

| Component | Purpose | Pattern |
|-----------|---------|---------|
| `js/api/wordpress.js` | WordPress REST API client — all `fetch()` calls | Named exports: `fetchPage(slug)`, `fetchServices()`, `fetchInsights(limit)`. Single source of truth for API base URL and error handling. |
| `js/modules/hero.js` | Hero section hydration | Imports from `wordpress.js`, updates DOM on load. |
| `js/modules/services.js` | Services cards render | Fetches custom post type, renders card list. |
| `js/modules/insights.js` | Insights/blog preview | Fetches posts, renders preview grid. |
| `js/modules/contact.js` | CF7 form submission via REST | POSTs `FormData` to CF7 endpoint, handles response states. |
| `js/main.js` | Entry point — imports all modules, initializes on `DOMContentLoaded` | Loaded as `<script type="module" src="js/main.js">`. |

**Key pattern — REST API client module:**
```javascript
// js/api/wordpress.js
const API_BASE = 'https://cms.yourdomain.com/wp-json';

export async function fetchPage(slug) {
  const res = await fetch(`${API_BASE}/wp/v2/pages?slug=${slug}&_fields=acf,title,content`);
  if (!res.ok) throw new Error(`WP API error: ${res.status}`);
  const data = await res.json();
  return data[0] ?? null;
}

export async function fetchCustomPostType(type, params = {}) {
  const query = new URLSearchParams({ per_page: 20, ...params });
  const res = await fetch(`${API_BASE}/wp/v2/${type}?${query}`);
  if (!res.ok) throw new Error(`WP API error: ${res.status}`);
  return res.json();
}
```

**Key pattern — CF7 form submission:**
```javascript
// js/modules/contact.js
export async function initContactForm(formEl, cf7FormId) {
  const WP_BASE = 'https://cms.yourdomain.com/wp-json';

  formEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(formEl);

    try {
      const res = await fetch(
        `${WP_BASE}/contact-form-7/v1/contact-forms/${cf7FormId}/feedback`,
        { method: 'POST', body: formData }
      );
      const result = await res.json();
      // result.status: 'mail_sent' | 'validation_failed' | 'mail_failed'
      handleFormResult(result, formEl);
    } catch (err) {
      handleFormError(err, formEl);
    }
  });
}
```

### CSS Architecture

| Decision | Approach | Why |
|----------|----------|-----|
| Naming convention | BEM for components (`.hero__headline`, `.service-card__cta`) | Predictable scope, scales without collisions when adding sections later. Pure utility classes (Tailwind-style) require a build step and lose design-token expressiveness. |
| Design tokens | CSS custom properties on `:root` | All brand colors, typography sizes, spacing units defined once as variables. Enables future brand name change (FN → NMC) by changing ~20 token values, not hunting through CSS. Matches project constraint. |
| File structure | Single `style.css` with `@import` sections OR one file with clear comment sections | No build tool means no SCSS compilation. Native CSS `@import` (at top of stylesheet) or a single well-organized `style.css` work equally well for a 9-section landing page. |
| Responsive approach | Mobile-first with `min-width` media queries | Aligns with project requirement. Define base styles for mobile, layer up for tablet/desktop. |
| No Sass/PostCSS | Deliberate omission | Modern CSS (custom properties, `clamp()`, `grid`, `container queries`) covers all needs for this project. Sass adds a build step and a dependency with zero benefit here. |

**Token architecture example:**
```css
/* tokens */
:root {
  /* brand */
  --color-graphite-900: #1a1a1a;
  --color-graphite-700: #2d2d2d;
  --color-gold-500: #b8962e;
  --color-gold-300: #d4af5a;
  --color-white: #ffffff;
  --color-surface: #f5f4f2;

  /* typography */
  --font-display: 'Cormorant Garamond', Georgia, serif;
  --font-body: 'Inter', system-ui, sans-serif;
  --text-hero: clamp(2.5rem, 5vw, 4rem);
  --text-heading: clamp(1.75rem, 3vw, 2.5rem);
  --text-body: 1rem;

  /* spacing */
  --space-section: clamp(4rem, 8vw, 8rem);
  --space-gap: 1.5rem;

  /* layout */
  --container-max: 1200px;
  --container-padding: clamp(1rem, 4vw, 2rem);
}
```

### Build Tooling

| Decision | Choice | Why |
|----------|--------|-----|
| Build tool | None — no build step | A 9-section landing page with vanilla JS modules does not need Webpack, Vite, or Rollup. Browsers support ES modules natively. No transpilation needed (target: modern browsers). Eliminates entire category of dependency management, security vulnerabilities, and toolchain complexity. |
| Local development server | Python `http.server` or `npx serve` (zero install) | ES modules require a server (file:// protocol blocks CORS). `python3 -m http.server 8080` or `npx serve .` works with no npm install. |
| Minification | Optional: `npx esbuild main.js --bundle --minify` | If performance optimization is needed pre-launch, esbuild is zero-config and fast. Not required for phase 1. |
| CSS minification | Optional: manual or `csso` via npx | Same rationale. Skip for phase 1. |

---

## Alternatives Considered

| Recommended | Alternative | When to Use Alternative |
|-------------|-------------|-------------------------|
| Contact Form 7 (CF7) | WPForms Lite | When you need a drag-and-drop form builder UI and don't need REST API submission. WPForms free tier lacks a native REST endpoint — form submission from a headless frontend requires the paid tier or a workaround. CF7 wins for headless. |
| ACF Free | ACF Pro | When Repeater fields, Flexible Content layouts, or Options Pages are needed for complex multi-entry data structures. Not needed for phase 1 of this project; defer this decision. |
| ACF Free | Pods, Meta Box | ACF has the most community documentation, the largest adoption, and the clearest REST API integration path. Alternatives work but require more setup for the same outcome. |
| Rank Math (free) | Yoast SEO (free) | Yoast if the client already has it installed and configured. Yoast's free tier lacks advanced schema options that Rank Math provides for free. No migration cost if starting fresh: use Rank Math. |
| Wordfence (free) | Sucuri | Sucuri if cloud-based WAF is a priority (Sucuri's WAF is premium only). Wordfence free WAF is endpoint-based (runs on server). For a low-traffic corporate landing page, Wordfence free is sufficient. |
| No build tool | Vite | If the project grows to include multiple pages, a component system, or TypeScript, Vite (with vanilla JS template) is the lowest-friction build tool to add. Start without it; add if complexity demands. |
| WP Mail SMTP | FluentSMTP | Both are free and excellent. FluentSMTP is fully free with no upsells; WP Mail SMTP has a freemium model. Either works. WP Mail SMTP is recommended for its larger install base and documentation. |

---

## What NOT to Use

| Avoid | Why | Use Instead |
|-------|-----|-------------|
| WPForms Lite (for headless form submission) | Free tier has no REST API endpoint for form submission from an external frontend. You'd need a paid WPForms license or a workaround plugin. | Contact Form 7 — native REST endpoint at no cost since CF7 v4.7. |
| Elementor / Beaver Builder / Divi (page builders) | Heavy JS/CSS payload injected into frontend, defeating performance goal. These builders generate markup for WordPress themes — irrelevant for a decoupled frontend, and they will bloat the WP backend. | None. ACF + custom endpoints provide all the data structure needed. |
| React / Vue / Angular | Violates project constraint. Introduces a build pipeline, bundle complexity, and framework overhead for a single-page marketing site. | Vanilla JS ES modules — sufficient for this use case. |
| GraphQL / WPGraphQL | Overkill for a single landing page reading from a handful of endpoints. REST API is simpler to debug, needs no extra plugin, and every WordPress developer knows it. | WordPress REST API (built-in). |
| JWT Authentication for WP REST API (plugin) | Not needed for this project. The frontend only reads public content (GET requests) and submits the CF7 form. Public GET requests require no auth. CF7 submission endpoint requires no auth either. JWT adds setup complexity without benefit here. | No authentication plugin needed. For GET requests: none. For CF7 POST: CF7 handles it natively. |
| Two separate domains (frontend + backend) on different providers | Creates CORS configuration complexity that must be managed manually in WordPress (custom headers via `functions.php` or plugin). | Host WordPress and serve static files from the same domain, or use a reverse proxy. If separate domains are unavoidable, configure CORS in `functions.php` to whitelist the frontend origin. |
| ACF acf-to-rest-api (third-party plugin) | Abandoned GitHub project. ACF 5.11+ has built-in REST API support via the "Show in REST API" toggle — the third-party plugin is obsolete. | ACF Free built-in "Show in REST API" toggle per field group. |

---

## Stack Patterns by Variant

**If WordPress and the HTML frontend share the same domain:**
- Serve `index.html` and JS/CSS as static files from the same web server (Apache/Nginx) that runs WordPress
- No CORS configuration needed — same-origin requests
- Simplest possible setup

**If WordPress is on a subdomain (e.g., `cms.domain.com`) and frontend on `domain.com`:**
- Add CORS headers in `functions.php`:
  ```php
  add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
      header('Access-Control-Allow-Origin: https://domain.com');
      header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
      header('Access-Control-Allow-Headers: Content-Type, X-WP-Nonce');
      return $value;
    });
  });
  ```
- This is the recommended architecture for this project (clean separation of concerns)

**If ACF Pro is purchased in a future phase:**
- Repeater fields enable: team member lists, methodology steps, testimonials as structured arrays
- Options Pages enable: sitewide settings (social links, phone, address) as a single API endpoint
- The REST API pattern remains identical — just richer data structures

**If insights/blog content grows beyond a teaser section:**
- Add `js/modules/blog.js` that fetches `/wp-json/wp/v2/posts` with pagination
- Consider adding a dedicated `/blog/` HTML page following the same module pattern
- No architectural change required — pattern is already extensible

---

## Version Compatibility

| Package | Compatible With | Notes |
|---------|-----------------|-------|
| WordPress 6.9 | PHP 8.0–8.4 | PHP 8.2 recommended. PHP 7.x is end-of-life and not supported. |
| ACF Free 6.x | WordPress 6.0+ | Full REST API support built-in. No compatibility issues with WP 6.9. |
| Contact Form 7 5.x | WordPress 5.5+ | REST endpoint `/wp-json/contact-form-7/v1/...` stable since CF7 4.7. |
| Rank Math Free | WordPress 5.0+ | No conflicts with ACF or CF7. Do not install alongside Yoast — duplicate JSON-LD output. |
| Wordfence Free | WordPress 4.7+ | May require allowlisting REST API routes used by CF7 submission if WAF blocks POST requests. Test after installation. |
| ES Modules (`type="module"`) | All browsers 2020+ (Chrome 61+, Firefox 60+, Safari 10.1+) | No transpilation needed for B2B corporate audience. IE11 is not a concern for mining consultancy clients. |

---

## Sources

- Brave Search: "WordPress REST API headless frontend best practices 2025" — ACF REST API resources from advancedcustomfields.com (Aug 2025, updated March 2025) — MEDIUM-HIGH confidence
- Brave Search: "ACF free version 6 REST API show_in_rest fields 2025" — advancedcustomfields.com/resources/wp-rest-api-integration/ (March 2025) — HIGH confidence (official docs)
- Brave Search: "WordPress 6.9 release December 2025" — multiple sources confirming Dec 2, 2025 release — HIGH confidence
- Brave Search: "Contact Form 7 REST API endpoint vanilla JS fetch POST headless 2025" — timber-dev.net tutorial (Nov 2024), css-tricks.com (Sep 2024), official CF7 REST endpoint confirmed — HIGH confidence
- Brave Search: "Rank Math vs Yoast SEO 2025" — multiple comparisons confirming Rank Math free > Yoast free for schema — MEDIUM confidence
- Brave Search: "Wordfence vs Sucuri 2025" — kinsta.com, elegantthemes.com comparisons — MEDIUM confidence
- Brave Search: "vanilla JS ES modules no build tool 2025" — community consensus on Reddit r/webdev (Sep 2025), gomakethings.com — MEDIUM confidence
- Brave Search: "CSS BEM custom properties 2025 corporate" — smashingmagazine.com (Jun 2025), css-tricks.com — MEDIUM confidence
- Training data: PHP version requirements, CORS headers pattern, CSS token structure — LOW-MEDIUM confidence (verify with WordPress docs before implementation)

---
*Stack research for: FN Mining Advisor — Headless WordPress + Vanilla JS Corporate Landing*
*Researched: 2026-03-16*

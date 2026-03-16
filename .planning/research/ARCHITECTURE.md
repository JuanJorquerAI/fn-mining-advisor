# Architecture Research

**Domain:** Semi-decoupled WordPress REST API + vanilla HTML/CSS/JS corporate landing page
**Researched:** 2026-03-16
**Confidence:** HIGH (well-established patterns, training data through Aug 2025, no breaking changes expected)

---

## Standard Architecture

### System Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                     FRONTEND (Static Hosting)                    │
├──────────────┬──────────────┬──────────────┬────────────────────┤
│  index.html  │  CSS Modules │  JS Modules  │   Static Assets    │
│  (shell)     │  (design     │  (per-       │  (fonts, images,   │
│              │   tokens,    │   section)   │   logo SVG)        │
│              │   layout,    │              │                    │
│              │   comps)     │              │                    │
└──────────────┴──────┬───────┴──────┬───────┴────────────────────┘
                      │              │
                      │   fetch()    │
                      ▼              ▼
┌─────────────────────────────────────────────────────────────────┐
│                  WORDPRESS (CMS / REST API Backend)              │
├──────────────────┬──────────────────┬───────────────────────────┤
│  WordPress Core  │  ACF Pro / Free  │  Custom Plugin (optional) │
│  REST API        │  (field groups   │  (register CPTs,          │
│  /wp-json/v2/    │   + REST expose) │   expose ACF to REST)     │
├──────────────────┴──────────────────┴───────────────────────────┤
│                     MySQL Database                               │
└─────────────────────────────────────────────────────────────────┘
```

### Component Responsibilities

| Component | Responsibility | Typical Implementation |
|-----------|----------------|------------------------|
| `index.html` | Shell / entry point. Static structural skeleton; section anchors pre-exist in HTML | Single file with 9 section `<section id="...">` wrappers |
| CSS design tokens | Brand variables (colors, typography, spacing). Swappable without touching layout | `:root` custom properties in `tokens.css` |
| Section CSS modules | Layout and visual per section. No runtime dependencies | One `.css` per section or feature group |
| API client module | Single source of truth for all `fetch()` calls to WP REST API | `src/api/client.js` — base URL, headers, error handling |
| Section JS modules | Fetch section data, render into DOM, handle fallbacks | `src/sections/hero.js`, `src/sections/services.js`, etc. |
| WordPress REST API | Exposes content as JSON. Built into WP core since 4.7 | `/wp-json/wp/v2/` namespace + custom namespaces |
| ACF field groups | Attaches structured fields to pages/CPTs. REST-exposed via ACF setting | ACF UI or JSON field group definitions |
| Custom Post Types | `servicio`, `insight` — structured content beyond pages | Registered via `functions.php` or a small plugin |
| WordPress page | The "Home" page carries hero and value-prop ACF fields | Page ID used as endpoint: `/wp-json/wp/v2/pages/{id}` |

---

## Recommended Project Structure

```
fn-mining-advisor/           # Frontend project root (separate from WP)
├── index.html               # Shell — all 9 sections as empty containers
├── src/
│   ├── api/
│   │   ├── client.js        # Base fetch wrapper: baseURL, headers, cache, error
│   │   ├── endpoints.js     # Named endpoint constants (no magic strings)
│   │   └── transforms.js    # Raw WP response → clean data shape for UI
│   ├── sections/
│   │   ├── hero.js          # Fetch + render hero section
│   │   ├── services.js      # Fetch + render services cards
│   │   ├── insights.js      # Fetch + render insights/blog preview
│   │   └── contact.js       # Contact form submit handler
│   ├── components/
│   │   ├── card.js          # Reusable service card renderer
│   │   └── nav.js           # Sticky nav + smooth scroll
│   ├── utils/
│   │   ├── dom.js           # querySelector helpers, safe DOM ops
│   │   ├── cache.js         # sessionStorage/memory cache wrapper
│   │   └── fallback.js      # Render static fallback if API fails
│   └── main.js              # Entry: import + init all section modules
├── css/
│   ├── tokens.css           # CSS custom properties: colors, type scale, spacing
│   ├── reset.css            # Modern CSS reset
│   ├── layout.css           # Grid, container, section spacing
│   ├── nav.css              # Sticky header styles
│   ├── hero.css
│   ├── services.css
│   ├── insights.css
│   ├── contact.css
│   └── utilities.css        # Text helpers, visibility, sr-only
├── assets/
│   ├── logo.svg             # Client logo
│   ├── images/              # Hero background, section imagery
│   └── fonts/               # Self-hosted Cormorant + Inter (optional)
└── wp-setup/                # WordPress configuration docs/files
    ├── README.md            # WP install + plugin guide
    ├── acf-field-groups/    # ACF JSON export files (version-controlled)
    │   ├── home-hero.json
    │   ├── home-services.json
    │   └── insights.json
    └── plugin/              # Optional: tiny mu-plugin for CPT registration
        └── fn-mining-cpt.php
```

### Structure Rationale

- **`src/api/`:** Isolates all network concerns. When WP URL changes or auth is added, only this layer changes. `transforms.js` decouples WP's response shape from UI code.
- **`src/sections/`:** One module per page section. Each is independently fetchable and renderable. Failed section does not break others.
- **`src/components/`:** Reusable render functions (not UI components in a framework sense — plain JS functions that return HTML strings or DOM nodes).
- **`css/tokens.css`:** CSS custom properties as the single source for brand. Changing `--color-gold` updates the entire site. Enables FN → NMC rebrand without touching other files.
- **`wp-setup/`:** WordPress config lives adjacent to frontend but is clearly scoped. ACF JSON files in version control enable reproducible WP setup.

---

## Architectural Patterns

### Pattern 1: Progressive Enhancement Shell

**What:** `index.html` ships with complete static copy (placeholder text) baked in. JS fetches live WP content and overwrites placeholders on load. If JS fails or API is slow, the page still shows readable content.

**When to use:** Always — for a corporate landing page where first impression is critical and client's WP hosting may be slow.

**Trade-offs:** Requires maintaining two copies of copy (static placeholder + WP content). Worth it: zero blank-page flash, works without JS, passes Core Web Vitals more easily.

**Example:**
```html
<!-- index.html — static fallback always present -->
<section id="hero" class="hero">
  <h1 class="hero__headline">Asesoría Técnica Senior en Minería y Metalurgia</h1>
  <p class="hero__sub">Valorización de propiedades, optimización de procesos...</p>
</section>
```

```javascript
// src/sections/hero.js — overwrites with live WP content
import { getPage } from '../api/client.js';
import { transformHero } from '../api/transforms.js';

export async function initHero() {
  try {
    const raw = await getPage('home');
    const data = transformHero(raw);
    document.querySelector('.hero__headline').textContent = data.headline;
    document.querySelector('.hero__sub').textContent = data.subheadline;
  } catch (e) {
    // Static fallback stays — do nothing, log silently
    console.warn('Hero: using static fallback', e.message);
  }
}
```

### Pattern 2: API Client with In-Memory Cache

**What:** A single `client.js` module wraps all `fetch()` calls. Results are cached in a `Map` keyed by URL for the session. Prevents redundant requests if multiple sections need overlapping data.

**When to use:** Any page with 3+ API calls on load. Prevents waterfall on the same endpoint.

**Trade-offs:** Memory cache disappears on page refresh (acceptable for a landing page). `sessionStorage` is the alternative for tab-persistent cache.

**Example:**
```javascript
// src/api/client.js
const BASE = import.meta.env?.VITE_WP_API_URL ?? 'https://cms.fnminingadvisor.com/wp-json';
const cache = new Map();

export async function wpFetch(path) {
  if (cache.has(path)) return cache.get(path);
  const res = await fetch(`${BASE}${path}`, {
    headers: { Accept: 'application/json' }
  });
  if (!res.ok) throw new Error(`WP API ${res.status}: ${path}`);
  const data = await res.json();
  cache.set(path, data);
  return data;
}
```

### Pattern 3: Transform Layer (WP Shape → UI Shape)

**What:** Raw WP REST responses include noise (`_links`, `guid`, rendered/raw duplication, ACF nested under `acf` key). A `transforms.js` layer normalizes these into clean, predictable objects before they reach section modules.

**When to use:** Always — insulates UI code from WP API response structure changes.

**Trade-offs:** Extra indirection. Small cost; high value when WP field names change.

**Example:**
```javascript
// src/api/transforms.js
export function transformHero(page) {
  const acf = page.acf ?? {};
  return {
    headline: acf.hero_headline ?? page.title?.rendered ?? '',
    subheadline: acf.hero_subheadline ?? '',
    ctaPrimary: { label: acf.hero_cta_primary_label, href: acf.hero_cta_primary_url },
    ctaSecondary: { label: acf.hero_cta_secondary_label, href: acf.hero_cta_secondary_url },
    backgroundImage: acf.hero_background_image?.url ?? null,
  };
}

export function transformService(post) {
  const acf = post.acf ?? {};
  return {
    id: post.id,
    title: post.title?.rendered ?? '',
    description: acf.service_description ?? '',
    icon: acf.service_icon?.url ?? null,
    ctaLabel: acf.service_cta_label ?? 'Ver más',
    ctaHref: acf.service_cta_url ?? '#contacto',
  };
}
```

---

## Data Flow

### Request Flow (Page Load)

```
Browser loads index.html (static shell + CSS)
    |
    v
main.js imports section modules (ES6 static imports)
    |
    v
All section init() called concurrently (Promise.allSettled)
    |
    +---> hero.js: GET /wp-json/wp/v2/pages?slug=home&acf_format=standard
    |         |
    |         v
    |     transforms.transformHero(raw)
    |         |
    |         v
    |     DOM: overwrite .hero__headline, .hero__sub, background img
    |
    +---> services.js: GET /wp-json/wp/v2/servicio?per_page=4&orderby=menu_order
    |         |
    |         v
    |     raw[].map(transforms.transformService)
    |         |
    |         v
    |     DOM: render service cards into #services .cards-grid
    |
    +---> insights.js: GET /wp-json/wp/v2/posts?per_page=3&_embed
              |
              v
          raw[].map(transforms.transformInsight)
              |
              v
          DOM: render article cards into #insights .insights-grid
```

### Contact Form Flow

```
User fills form → submit event
    |
    v
contact.js validates fields (client-side)
    |
    v
POST to /wp-json/contact-form-7/v1/contact-forms/{id}/feedback
    OR
POST to custom WP endpoint or third-party (Formspree / WP Mail SMTP)
    |
    v
Show success/error state in DOM (no page reload)
```

### ACF Field → REST → Frontend Mapping

| Section | WP Endpoint | ACF Field Group | Key Fields | Transform Output |
|---------|-------------|-----------------|------------|-----------------|
| Hero | `/wp-json/wp/v2/pages?slug=home` | `Home - Hero` | `hero_headline`, `hero_subheadline`, `hero_background_image`, `hero_cta_primary_*`, `hero_cta_secondary_*` | `{ headline, subheadline, ctaPrimary, ctaSecondary, backgroundImage }` |
| Value Props | `/wp-json/wp/v2/pages?slug=home` | `Home - Value Props` | `value_props` (repeater: `icon`, `title`, `text`) | `Array<{ icon, title, text }>` |
| Services | `/wp-json/wp/v2/servicio?per_page=4` | `Servicio Fields` | `service_description`, `service_icon`, `service_cta_label`, `service_cta_url` | `Array<{ id, title, description, icon, ctaLabel, ctaHref }>` |
| Innovation | `/wp-json/wp/v2/pages?slug=home` | `Home - Innovation` | `innovation_headline`, `innovation_body`, `innovation_badges` (repeater) | `{ headline, body, badges[] }` |
| Methodology | `/wp-json/wp/v2/pages?slug=home` | `Home - Methodology` | `methodology_steps` (repeater: `step_number`, `title`, `description`) | `Array<{ step, title, description }>` |
| Experience | `/wp-json/wp/v2/pages?slug=home` | `Home - Experience` | `experience_headline`, `experience_body`, `experience_stats` (repeater) | `{ headline, body, stats[] }` |
| Insights | `/wp-json/wp/v2/posts?per_page=3&_embed` | Post Meta / ACF | Standard post fields + `post_excerpt`, featured image via `_embedded` | `Array<{ id, title, excerpt, date, thumbnail, href }>` |

### State Management

This project uses no framework state. Data flows one-way: fetch → transform → DOM render. No shared state store needed at this scale.

```
API response (immutable)
    |
    v
Transform (pure function → plain JS object)
    |
    v
Render function (object → HTML string or DOM nodes)
    |
    v
DOM (final state)
```

Re-renders only occur on user interaction (contact form). No reactive updates needed for a static landing page.

---

## CORS Considerations

```
Frontend host: https://fnminingadvisor.com  (or Netlify/Vercel subdomain)
WP API host:   https://cms.fnminingadvisor.com  (separate subdomain recommended)

Cross-origin requests require WP to send:
  Access-Control-Allow-Origin: https://fnminingadvisor.com
```

**Configuration approach (HIGH confidence):**

WordPress does not send CORS headers by default for custom frontends. Add to the WP site's `functions.php` or a mu-plugin:

```php
// wp-setup/plugin/fn-mining-cpt.php (or functions.php)
add_action('rest_api_init', function () {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function ($value) {
        $allowed = ['https://fnminingadvisor.com', 'https://www.fnminingadvisor.com'];
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origin, $allowed, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Credentials: true');
        }
        return $value;
    });
});
```

**If frontend and WP are on the same domain** (e.g., WP at `/`, frontend served as WP theme or from WP's document root): No CORS issue. Simpler deployment but harder to separate.

**Recommended for this project:** Single-domain setup during development (WP serves frontend via a simple "headless" child theme that just outputs `index.html`), then separate on production if hosting budget allows. Eliminates CORS complexity for MVP.

---

## Caching Strategy

| Layer | Mechanism | Duration | Scope |
|-------|-----------|----------|-------|
| Browser | `Cache-Control` headers from WP/server | 1-5 min (API), 1 day (assets) | Per user |
| JS in-memory | `Map` in `client.js` | Session (tab lifetime) | Per tab |
| WP server | WP Super Cache / W3 Total Cache (REST responses) | 5-60 min | All users |
| CDN (future) | Cloudflare in front of WP | 1-24h configurable | All users |

**For MVP:** In-memory JS cache in `client.js` is sufficient. No WP caching plugin required at launch. Add WP Super Cache when traffic justifies it.

**ACF REST endpoint quirk:** ACF fields only appear in REST responses when "Show in REST API" is enabled per field group in the ACF settings (UI toggle or `'show_in_rest' => true` in PHP). Verify this during WP setup or data will appear as `acf: false` in responses.

---

## Scaling Considerations

| Scale | Architecture Adjustments |
|-------|--------------------------|
| Single landing (now) | Vanilla JS modules, in-memory cache, one WP site, no CDN required |
| + Blog section active | Add WP post pagination, lazy-load insights section, consider ISR if moved to SSG |
| + Multiple landings | Extract shared component library from `src/components/`, parameterize API client by site |
| + High traffic | Cloudflare in front of WP, WP caching plugin (WP Rocket), consider static export via WP2Static |

### Scaling Priorities

1. **First bottleneck:** WP server response time on API calls. Fix with WP caching plugin (W3TC or WP Rocket) + object caching (Redis). REST API calls hit PHP on every request without caching.
2. **Second bottleneck:** Image delivery. Fix with Cloudflare Images or WP Smush + WebP conversion. ACF image fields return full-size URLs by default.

---

## Build Order (Component Dependencies)

The suggested build sequence respects hard dependencies between layers:

```
Phase 1: Foundation (no API dependency)
    tokens.css → reset.css → layout.css
    index.html shell (static copy, all 9 sections)
    nav.js (pure DOM — no API)
    hero (static version — markup + CSS only)

Phase 2: WordPress Backend
    WP install + permalink structure (/wp-json/ must work)
    ACF installation + field group definitions
    Custom Post Types: servicio, insight
    Seed data: 4 services, 3 insights, home page ACF values
    Verify REST endpoints return expected shape

Phase 3: API Integration Layer
    src/api/client.js (base fetch, cache, error)
    src/api/endpoints.js (named constants)
    src/api/transforms.js (WP → UI shapes)
    Test transforms against live WP responses

Phase 4: Section Integration (can be parallelized after Phase 3)
    hero.js → services.js → insights.js
    (Each section independently integrable)

Phase 5: Contact Form
    contact.js (depends on: form markup from Phase 1, WP plugin or third-party)
    Choose: CF7, WPForms, or Formspree (avoids WP email config complexity)

Phase 6: Polish + Production
    Fallback states (loading skeletons or static copy persistence)
    Error boundaries per section
    Performance: image lazy-load, font display swap, preconnect to WP API host
    CORS headers on WP if on separate domain
```

**Critical dependency:** Sections cannot be integrated (Phase 4) until WP has real data (Phase 2) and transforms are defined (Phase 3). Build phases 1 and 2 in parallel, merge at Phase 3.

---

## Anti-Patterns

### Anti-Pattern 1: Fetching in DOMContentLoaded Waterfall

**What people do:** Chain API calls sequentially inside one `DOMContentLoaded` handler — hero loads, then services, then insights.

**Why it's wrong:** Total load time = sum of all API calls. With 3 calls at 200ms each = 600ms waterfall. On a slow host, 2-3 seconds of blank sections.

**Do this instead:** Fire all section `init()` calls concurrently with `Promise.allSettled([initHero(), initServices(), initInsights()])`. Each section resolves independently. One slow endpoint doesn't block others.

### Anti-Pattern 2: Leaking WP Response Shape into UI Code

**What people do:** Access `section.acf.hero_headline` directly inside render functions scattered across modules.

**Why it's wrong:** When the ACF field is renamed (`hero_headline` → `headline`), every file referencing it must be updated. Also, WP returns `acf: false` (not `acf: {}`) when fields are not REST-exposed — causes runtime TypeError.

**Do this instead:** All WP response access goes through `transforms.js`. UI modules receive clean plain objects. One-line fix when WP field names change.

### Anti-Pattern 3: Hardcoded WP URL Strings

**What people do:** `fetch('https://cms.fnminingadvisor.com/wp-json/wp/v2/...')` scattered in every section file.

**Why it's wrong:** Changing the WP host (common during staging → production migration) requires grep-replacing every file.

**Do this instead:** One `BASE_URL` constant in `src/api/client.js`. One change propagates everywhere.

### Anti-Pattern 4: No Fallback for Failed API Calls

**What people do:** `const data = await getPage(); renderHero(data);` — no try/catch. If WP is down or slow, sections throw uncaught errors and leave the page broken.

**Why it's wrong:** WordPress shared hosting goes down. WP REST API can return 503 during plugin conflicts. A corporate landing page must always show something.

**Do this instead:** Wrap each section init in try/catch. On catch, log silently and leave static HTML placeholder in place. Progressive enhancement shell (Pattern 1) ensures fallback is already visible.

### Anti-Pattern 5: All ACF Fields on One Endpoint

**What people do:** Dump all 40+ page ACF fields into a single "Home" page and fetch them all in one call. One transform handles everything.

**Why it's wrong:** The response object grows unwieldy. Harder to debug. ACF repeater fields serialized into the response inflate payload size. Single point of failure.

**Do this instead:** Group ACF fields by section (separate ACF field groups per section). Consider separate REST routes for complex sections (ACF REST API allows `acf/v3/` namespace). Keeps responses focused and debuggable.

---

## Integration Points

### External Services

| Service | Integration Pattern | Notes |
|---------|---------------------|-------|
| WordPress REST API | `fetch()` from frontend JS | GET only for public content. No auth needed for public CPTs. |
| ACF (Advanced Custom Fields) | Extends WP REST response with `acf` key | Must enable "Show in REST API" per field group |
| Contact Form 7 (optional) | POST to `/wp-json/contact-form-7/v1/contact-forms/{id}/feedback` | Requires CF7 plugin on WP. Returns JSON success/error. |
| Formspree (alternative) | POST to `https://formspree.io/f/{id}` | No WP plugin needed. Simpler but external dependency. |
| Google Fonts / self-hosted | `@font-face` in CSS or `<link>` in HTML | Self-host Cormorant + Inter for performance + privacy |

### Internal Boundaries

| Boundary | Communication | Notes |
|----------|---------------|-------|
| `main.js` ↔ section modules | ES6 module import + exported `init()` function | `main.js` orchestrates; sections own their DOM area |
| Section modules ↔ API client | Imported functions (`getPage`, `getPosts`) | Sections never call `fetch()` directly |
| API client ↔ transforms | Transforms called by section modules after fetch | Client returns raw WP JSON; transforms are pure functions |
| CSS ↔ JS | JS adds/removes CSS classes only | JS does not set inline styles except for dynamic values (image URLs) |
| WordPress ↔ Frontend | HTTP only — no shared code, no PHP in frontend | Hard boundary: WP is replaceable; frontend is WP-agnostic |

---

## Sources

- WordPress REST API Handbook (developer.wordpress.org/rest-api/) — core endpoint structure, authentication, CORS (HIGH confidence)
- ACF Documentation — REST API integration, `show_in_rest`, `acf_format=standard` parameter (HIGH confidence — training data confirmed against ACF docs structure)
- MDN Web Docs — `Promise.allSettled`, ES6 modules, `fetch()` API (HIGH confidence)
- Web.dev — Core Web Vitals for landing pages, progressive enhancement patterns (HIGH confidence)
- Community pattern (MEDIUM confidence, WebSearch unavailable): Single-domain same-host deployment to avoid CORS — widely documented in WP headless communities

---

*Architecture research for: Semi-decoupled WordPress REST API + Vanilla JS corporate landing page (FN Mining Advisor)*
*Researched: 2026-03-16*

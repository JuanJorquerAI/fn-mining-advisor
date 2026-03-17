# Phase 2: WordPress Backend Setup - Research

**Researched:** 2026-03-17
**Domain:** WordPress headless CMS — ACF Free, CPT, CF7, WP Mail SMTP + Resend, security hardening, Rank Math, Wordfence, UpdraftPlus
**Confidence:** HIGH

---

<user_constraints>
## User Constraints (from CONTEXT.md)

### Locked Decisions

**Hosting & CORS:**
- WordPress installed in `/wp` subdirectory of the same domain — `example.com/wp`. Frontend serves from `example.com/`.
- API base URL: `example.com/wp/wp-json/wp/v2/` — default path, no rewrites. The `js/api/client.js` module (Phase 3) uses this base.
- CORS: No CORS headers required — same origin. Do NOT install a CORS plugin.
- Developer configures WordPress completely; client edits content via WP admin without touching code.
- Real domain: placeholder `example.com` in the plan — replace with real domain at installation time.

**ACF Free — workaround without Repeater:**
- ACF Pro will NOT be used — ACF Free is sufficient for v1.
- Indexed field structure for multi-item sections:
  - `home_trust_pillars`: `pillar_1_title`, `pillar_1_text`, `pillar_1_icon`, `pillar_2_title` ... `pillar_4_icon` (4 fixed pillars)
  - `home_methodology`: `step_1_title`, `step_1_text`, `step_2_title`, `step_2_text` ... `step_5_title`, `step_5_text` (5 fixed steps)
  - `home_services`: `service_1_title`, `service_1_description`, `service_1_focus`, `service_1_icon_url` ... `service_4_icon_url` (4 fixed services)
- Inflexibility is acceptable: these sections have fixed items in v1; the client does not need to add/remove steps or pillars.
- Insights CPT: uses normal ACF fields (no repeater) — `insight_category`, `insight_excerpt`, `insight_featured_image` per post.

**Email delivery:**
- Service: Resend — free tier (3,000 emails/month), native support in WP Mail SMTP.
- Plugin: WP Mail SMTP configured with Resend driver + API key.
- Destination inbox: `contacto@example.com` (placeholder — replace on deploy with real client email).
- CF7: Form configured with `To: contacto@example.com`, subject `[FN Mining Advisor] Consulta de {nombre}`.

**Admin URL:**
- Custom slug: `/gestion` — replaces `/wp-admin/`.
- Plugin: WPS Hide Login (lightweight, no conflicts with Wordfence).
- Login URL: `example.com/wp/gestion`

**Security hardening (WP-02 minimums):**
- Endpoint `/wp-json/wp/v2/users` blocked (returns 403 or empty array via REST filter)
- XML-RPC disabled (`add_filter('xmlrpc_enabled', '__return_false')` in mu-plugin)
- Admin URL renamed to `/gestion` (WPS Hide Login)
- Security headers: `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `X-XSS-Protection: 1; mode=block`, `Referrer-Policy: strict-origin-when-cross-origin` — via `.htaccess` or mu-plugin

**Additional hardening decided:**
- `DISALLOW_FILE_EDIT = true` in `wp-config.php` — disables file editing from admin
- Login brute-force: covered by Wordfence (already in WP-09) — no additional plugin
- REST API writes blocked for unauthenticated users: mu-plugin returns 403 on POST/PUT/DELETE if user is not authenticated
- REST API reads: fully public (no origin restriction) — content is public and the frontend needs access without authentication

### Claude's Discretion

- Exact plugin installation order (which goes first)
- Internal configuration of Wordfence and UpdraftPlus (backup schedule, destination)
- Exact ACF field group names in the admin (UI labels, not field names which are already decided)
- Seed content for ACF fields on the Home page (professional Spanish placeholder)
- Structure of the security mu-plugin (can be one file or multiple)

### Deferred Ideas (OUT OF SCOPE)

- None — no scope creep ideas arose during discussion.

</user_constraints>

---

<phase_requirements>
## Phase Requirements

| ID | Description | Research Support |
|----|-------------|-----------------|
| WP-01 | WordPress 6.9 installed with PHP 8.2+, HTTPS forced, debug disabled in production | Standard WP installation checklist; `WP_DEBUG = false` in wp-config.php; HTTPS via hosting config or `.htaccess` redirect |
| WP-02 | Security hardening: /users endpoint blocked, XML-RPC disabled, custom admin URL, security headers | mu-plugin pattern with `rest_authentication_errors` / `rest_endpoints` filter; `xmlrpc_enabled` filter; WPS Hide Login plugin; headers via `.htaccess` |
| WP-03 | ACF Free installed with field groups: home_hero, home_trust_pillars, home_services, home_methodology, home_experience, home_cta_final — with indexed fields (no Repeater) | ACF Free supports REST API via "Show in REST API" toggle (since ACF 5.11); field groups registered via UI or `acf_add_local_field_group()` PHP |
| WP-04 | All ACF field groups have "Show in REST API" enabled with explicit field names | ACF Free supports `show_in_rest` toggle per field group; fields appear under `acf` key in REST response |
| WP-05 | Contact Form 7 installed with contact form configured (name, company, email, phone, message) and REST endpoint active | CF7 uses REST API natively since v4.8; submit endpoint: `POST /wp-json/contact-form-7/v1/contact-forms/{id}/feedback` |
| WP-06 | WP Mail SMTP installed and configured with Resend transactional service — form emails delivered reliably | Resend available in WP Mail SMTP free tier; requires verified domain in Resend + API key configuration |
| WP-07 | Custom Post Type "Insights" (slug: `insights`) registered with REST API support, ACF fields: insight_category, insight_excerpt, insight_featured_image | `register_post_type()` with `show_in_rest => true` and `rest_base => 'insights'`; ACF fields attached to this CPT |
| WP-08 | Rank Math SEO installed with Organization schema configured (name, logo, country, sector) | Rank Math free supports Organization schema via Local SEO module; fields: name, logo, URL, email, address, business type |
| WP-09 | Wordfence and UpdraftPlus installed and configured (security + automatic backups) | Both free versions cover v1 requirements; Wordfence handles brute-force; UpdraftPlus handles scheduled backups |

</phase_requirements>

---

## Summary

Phase 2 installs and configures WordPress as a headless CMS in a `/wp` subdirectory of the main domain. All WordPress-native UI is internal-only; the frontend (Phase 1 HTML shell) is served from the root and consumes JSON from `example.com/wp/wp-json/wp/v2/`. No custom WP theme is required beyond a blank/minimal theme — the only output that matters is the REST API response.

The core configuration work falls into five domains: (1) ACF Free field groups covering all six home page sections using indexed fields instead of repeaters, with REST API exposure enabled; (2) the Insights CPT registered with `show_in_rest => true`; (3) Contact Form 7 with WP Mail SMTP + Resend for reliable email delivery; (4) a security mu-plugin handling XML-RPC, users endpoint, and REST write blocking; and (5) plugin configuration for Rank Math Organization schema, Wordfence, and UpdraftPlus.

The most critical constraint is ACF field name discipline: the field names registered in this phase (e.g., `hero_title`, `pillar_1_text`, `step_3_title`) must exactly match what Phase 3's `js/api/transforms.js` will read. The canonical mapping from `data-api-target` HTML attributes to ACF field paths must be documented and locked in this phase.

**Primary recommendation:** Register all ACF field groups via PHP in a mu-plugin (using the ACF Export-to-PHP feature) rather than only via the UI. This makes field configuration versionable and repeatable across environments. Use the ACF "Export to PHP" feature in the admin to generate the code after UI configuration, then move it to a mu-plugin.

---

## Standard Stack

### Core

| Plugin/Tool | Version | Purpose | Why Standard |
|-------------|---------|---------|--------------|
| WordPress | 6.9 | CMS/headless backend | LTS release; REST API built-in; the locked choice |
| ACF Free (Advanced Custom Fields) | Latest (6.x) | Custom field groups for home page sections | Free tier supports REST API since v5.11; no Pro needed for flat fields |
| Contact Form 7 | Latest (6.x) | Contact form + REST API submit endpoint | 5M+ installs; built-in REST submit since v4.8; locked choice |
| WP Mail SMTP (free) | Latest (4.x) | Reliable transactional email delivery | Resend driver available in free tier; most reliable email fix for WP |
| Resend | Free tier | Transactional email service | 3,000 emails/month free; native WP Mail SMTP driver |
| WPS Hide Login | Latest | Rename `/wp-admin/` to `/gestion` | Lightweight, no conflicts with Wordfence; subfolder-compatible |
| Rank Math SEO (free) | Latest | Organization schema + SEO baseline | Free tier includes Organization schema via Local SEO module |
| Wordfence (free) | Latest | Firewall + brute-force protection | Industry standard free security plugin |
| UpdraftPlus (free) | Latest | Automated backups | Industry standard free backup plugin |

### Supporting

| Tool | Purpose | When to Use |
|------|---------|-------------|
| mu-plugin (`wp/wp-content/mu-plugins/`) | Security hardening (XML-RPC disable, users endpoint block, REST write block) | Always active, cannot be deactivated by accident — correct location for security code |
| ACF Export-to-PHP | Generate PHP code from UI-configured field groups | After configuring fields in UI, export to PHP for versionable config |
| Blank/minimal WP theme | Prevent 500 errors when no theme is active | WordPress requires an active theme; use a minimal one or TwentyTwentyFive |

### Alternatives Considered

| Instead of | Could Use | Tradeoff |
|------------|-----------|----------|
| ACF Free | ACF Pro | Pro has Repeater field (cleaner API for multi-items) — locked out: not needed for v1 with fixed item counts |
| Resend | Mailgun | Both available in WP Mail SMTP free; Resend chosen — simpler API, generous free tier |
| WPS Hide Login | Wordfence login URL change | Wordfence can also rename login; WPS Hide Login chosen for lighter footprint |
| mu-plugin for security | functions.php in theme | Theme functions can be accidentally lost on theme switch; mu-plugin always runs |

**Installation:** All plugins installed via WP admin Plugins > Add New. Resend account created at resend.com with domain verification before WP Mail SMTP configuration.

---

## Architecture Patterns

### WordPress Subdirectory Setup

```
example.com/            (frontend — Phase 1 HTML/CSS/JS, NOT served by WP)
example.com/wp/         (WordPress installation root)
example.com/wp/wp-admin/      → redirects to /wp/gestion/ (WPS Hide Login)
example.com/wp/wp-json/       (REST API root)
example.com/wp/wp-content/
  ├── mu-plugins/
  │   └── fn-security.php     (XML-RPC, users endpoint, REST writes, headers)
  ├── plugins/
  │   ├── advanced-custom-fields/
  │   ├── contact-form-7/
  │   ├── wp-mail-smtp/
  │   ├── wps-hide-login/
  │   ├── seo-by-rank-math/
  │   ├── wordfence/
  │   └── updraftplus/
  └── themes/
      └── twentytwentyfive/   (active theme — minimal, never rendered in production)
```

### Pattern 1: ACF Field Group Registration via PHP (Export-to-PHP)

**What:** ACF field groups configured in the UI, then exported to PHP and placed in a mu-plugin or theme `functions.php`. This makes field configuration version-controlled and reproducible.

**When to use:** Always — UI configuration alone is lost if the database is wiped. PHP registration persists.

**Example:**
```php
// Source: https://www.advancedcustomfields.com/resources/register-fields-via-php/
// Generated by ACF > Tools > Export > Generate PHP

add_action('acf/init', function() {
    if ( function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group(array(
            'key'      => 'group_home_hero',
            'title'    => 'Home — Hero',
            'show_in_rest' => 1,   // WP-04: enables acf key in REST response
            'fields'   => array(
                array(
                    'key'   => 'field_hero_title',
                    'label' => 'Título del héroe',
                    'name'  => 'hero_title',
                    'type'  => 'text',
                    'instructions' => 'Headline principal del hero. Ej: "Consultoría técnica en minería"',
                ),
                array(
                    'key'   => 'field_hero_subtitle',
                    'label' => 'Subtítulo del héroe',
                    'name'  => 'hero_subtitle',
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'instructions' => 'Texto descriptivo bajo el título. 2-3 líneas técnico-comerciales.',
                ),
                array(
                    'key'   => 'field_hero_cta_primary',
                    'label' => 'CTA primario',
                    'name'  => 'hero_cta_primary',
                    'type'  => 'text',
                    'instructions' => 'Texto del botón dorado. Ej: "Solicitar diagnóstico"',
                ),
                array(
                    'key'   => 'field_hero_cta_secondary',
                    'label' => 'CTA secundario',
                    'name'  => 'hero_cta_secondary',
                    'type'  => 'text',
                    'instructions' => 'Texto del botón secundario. Ej: "Ver servicios"',
                ),
                array(
                    'key'   => 'field_hero_background',
                    'label' => 'Imagen de fondo del hero',
                    'name'  => 'hero_background',
                    'type'  => 'image',
                    'return_format' => 'url',
                    'instructions' => 'Imagen profesional de minería. Mín 1920×1080px.',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'page',
                        'operator' => '==',
                        'value'    => 'home',   // slug of the home page
                    ),
                ),
            ),
        ));

    }
});
```

### Pattern 2: ACF Indexed Fields for Multi-Item Sections (No Repeater)

**What:** Instead of a Repeater field (ACF Pro), use individually named fields with numeric suffixes for fixed-count item sets.

**When to use:** All multi-item sections in this project — trust pillars (4), methodology steps (5), services (4).

**Example (trust pillars, abbreviated):**
```php
// Fields for home_trust_pillars group
array('key' => 'field_pillar_1_title', 'name' => 'pillar_1_title', 'label' => 'Pilar 1 — Título', 'type' => 'text'),
array('key' => 'field_pillar_1_text',  'name' => 'pillar_1_text',  'label' => 'Pilar 1 — Texto',  'type' => 'textarea', 'rows' => 3),
array('key' => 'field_pillar_1_icon',  'name' => 'pillar_1_icon',  'label' => 'Pilar 1 — Icono SVG (código)', 'type' => 'textarea', 'rows' => 5),
// ... repeated for pillar_2, pillar_3, pillar_4
```

**REST API output structure (how Phase 3 reads it):**
```json
{
  "acf": {
    "pillar_1_title": "Criterio técnico senior",
    "pillar_1_text": "Más de 20 años en...",
    "pillar_1_icon": "<svg>...</svg>",
    "pillar_2_title": "...",
    ...
  }
}
```

### Pattern 3: Security mu-plugin

**What:** A single `fn-security.php` file in `wp-content/mu-plugins/`. Must-use plugins load automatically before regular plugins and cannot be disabled via admin.

**When to use:** All security hooks that must always be active.

```php
<?php
// Source: WordPress Codex + verified patterns
// File: wp-content/mu-plugins/fn-security.php

// 1. Disable XML-RPC completely
add_filter('xmlrpc_enabled', '__return_false');

// 2. Block /wp-json/wp/v2/users endpoint (user enumeration)
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

// 3. Block REST API writes for unauthenticated users
//    Reads (GET) remain public for the frontend to consume content
add_filter('rest_authentication_errors', function($result) {
    if (!empty($result)) {
        return $result;
    }
    if (!is_user_logged_in()) {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            // Whitelist: CF7 submit endpoint must remain open
            $route = $GLOBALS['wp']->query_vars['rest_route'] ?? '';
            if (strpos($route, '/contact-form-7/') === false) {
                return new WP_Error(
                    'rest_not_authenticated',
                    'REST API write operations require authentication.',
                    array('status' => 403)
                );
            }
        }
    }
    return $result;
});

// 4. Security headers
add_action('send_headers', function() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
});
```

### Pattern 4: CPT Registration for Insights

**What:** Register the Insights custom post type with REST API support enabled.

```php
// In mu-plugin or theme functions.php
add_action('init', function() {
    register_post_type('insights', array(
        'label'         => 'Insights',
        'labels'        => array(
            'name'          => 'Insights',
            'singular_name' => 'Insight',
            'add_new_item'  => 'Agregar nuevo Insight',
            'edit_item'     => 'Editar Insight',
        ),
        'public'        => true,
        'has_archive'   => true,
        'show_in_rest'  => true,        // WP-07: required for REST API access
        'rest_base'     => 'insights',  // endpoint: /wp-json/wp/v2/insights
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'insights'),
        'menu_icon'     => 'dashicons-lightbulb',
    ));
});
```

**REST endpoint after registration:** `GET example.com/wp/wp-json/wp/v2/insights`

### Pattern 5: Contact Form 7 REST Submit

**What:** CF7 exposes a REST endpoint for form submission since v4.8. No additional plugin needed.

**Endpoint URL:**
```
POST /wp-json/contact-form-7/v1/contact-forms/{form_id}/feedback
Content-Type: multipart/form-data
```

**Required fields (matching CF7 form field names):**
```
your-name: "Juan Pérez"
your-company: "Minera Escondida"
your-email: "juan@example.com"
your-phone: "+56912345678"
your-message: "Consulta sobre valorización..."
_wpcf7: {form_id}
_wpcf7_version: "5.x"
_wpcf7_locale: "es_ES"
_wpcf7_unit_tag: "wpcf7-f{form_id}-p{page_id}-o1"
```

**Success response:**
```json
{ "status": "mail_sent", "message": "Gracias por su mensaje..." }
```

**Error response:**
```json
{ "status": "validation_failed", "invalid_fields": [...] }
```

The `_wpcf7_unit_tag` and `_wpcf7_version` fields are required by CF7's nonce validation. Phase 4's `js/api/client.js` must include them in the FormData object.

### Anti-Patterns to Avoid

- **Registering ACF fields only via UI (no PHP export):** Field configuration lives only in the database. Environment migration or DB reset loses all field structure. Always export to PHP.
- **Using `rest_authentication_errors` to block ALL unauthenticated REST access:** This breaks the CF7 submit endpoint. Always whitelist `/contact-form-7/` namespace when blocking writes.
- **Setting `DISALLOW_FILE_EDIT` without also setting `DISALLOW_FILE_MODS`:** File edit is disabled but theme/plugin updates still work. In this project, `DISALLOW_FILE_EDIT` is sufficient (updates via WP admin are fine); `DISALLOW_FILE_MODS` would be too restrictive.
- **Not flushing rewrite rules after CPT registration:** After `register_post_type()`, visit Settings > Permalinks and save once to flush rewrite rules. Without this, the CPT endpoint returns 404.
- **Skipping Resend domain verification before email testing:** WP Mail SMTP will fail silently or throw errors if the sending domain is not verified in Resend. Complete domain verification first.

---

## Full ACF Field Name Specification

This is the canonical field name map. Phase 3 transforms must align exactly to these names.

### Field Group: `home_hero` (location: home page)
| Field Name | Type | Label (ES) | Notes |
|------------|------|-----------|-------|
| `hero_title` | text | Título del héroe | H1 content |
| `hero_subtitle` | textarea | Subtítulo del héroe | Subheadline |
| `hero_cta_primary` | text | CTA primario | Gold button text |
| `hero_cta_secondary` | text | CTA secundario | Ghost button text |
| `hero_background` | image (URL) | Imagen de fondo | `return_format: 'url'` |

### Field Group: `home_trust_pillars` (location: home page)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `pillar_1_title` | text | Pilar 1 — Título |
| `pillar_1_text` | textarea | Pilar 1 — Texto |
| `pillar_1_icon` | textarea | Pilar 1 — Icono SVG |
| `pillar_2_title` | text | Pilar 2 — Título |
| `pillar_2_text` | textarea | Pilar 2 — Texto |
| `pillar_2_icon` | textarea | Pilar 2 — Icono SVG |
| `pillar_3_title` | text | Pilar 3 — Título |
| `pillar_3_text` | textarea | Pilar 3 — Texto |
| `pillar_3_icon` | textarea | Pilar 3 — Icono SVG |
| `pillar_4_title` | text | Pilar 4 — Título |
| `pillar_4_text` | textarea | Pilar 4 — Texto |
| `pillar_4_icon` | textarea | Pilar 4 — Icono SVG |

### Field Group: `home_methodology` (location: home page)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `step_1_title` | text | Paso 1 — Título |
| `step_1_text` | textarea | Paso 1 — Descripción |
| `step_2_title` | text | Paso 2 — Título |
| `step_2_text` | textarea | Paso 2 — Descripción |
| `step_3_title` | text | Paso 3 — Título |
| `step_3_text` | textarea | Paso 3 — Descripción |
| `step_4_title` | text | Paso 4 — Título |
| `step_4_text` | textarea | Paso 4 — Descripción |
| `step_5_title` | text | Paso 5 — Título |
| `step_5_text` | textarea | Paso 5 — Descripción |

### Field Group: `home_services` (location: home page)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `service_1_title` | text | Servicio 1 — Título |
| `service_1_description` | textarea | Servicio 1 — Descripción |
| `service_1_focus` | text | Servicio 1 — Foco |
| `service_1_icon_url` | text | Servicio 1 — URL del icono |
| `service_2_title` | text | Servicio 2 — Título |
| `service_2_description` | textarea | Servicio 2 — Descripción |
| `service_2_focus` | text | Servicio 2 — Foco |
| `service_2_icon_url` | text | Servicio 2 — URL del icono |
| `service_3_title` | text | Servicio 3 — Título |
| `service_3_description` | textarea | Servicio 3 — Descripción |
| `service_3_focus` | text | Servicio 3 — Foco |
| `service_3_icon_url` | text | Servicio 3 — URL del icono |
| `service_4_title` | text | Servicio 4 — Título |
| `service_4_description` | textarea | Servicio 4 — Descripción |
| `service_4_focus` | text | Servicio 4 — Foco |
| `service_4_icon_url` | text | Servicio 4 — URL del icono |

### Field Group: `home_experience` (location: home page)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `experience_text` | wysiwyg | Texto de experiencia |
| `experience_highlights` | textarea | Hitos destacados (uno por línea) |

### Field Group: `home_cta_final` (location: home page)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `cta_title` | text | Título del CTA final |
| `cta_text` | textarea | Texto del CTA final |
| `cta_primary` | text | Texto del botón primario |
| `cta_secondary` | text | Texto del botón secundario |

### Field Group: `insights` (location: CPT `insights`)
| Field Name | Type | Label (ES) |
|------------|------|-----------|
| `insight_category` | text | Categoría del insight |
| `insight_excerpt` | textarea | Extracto del insight |
| `insight_featured_image` | image (URL) | Imagen destacada |

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Reliable email delivery from WP | Custom `wp_mail()` + raw SMTP config | WP Mail SMTP + Resend | PHP `mail()` is blocked by most shared hosts; SMTP config is environment-specific and fragile |
| Form spam protection | Custom honeypot or manual captcha | CF7 built-in spam protection + Wordfence | CF7 ships with honeypot and CAPTCHA options; reinventing costs time with no benefit |
| Incremental backups | Manual DB exports + FTP file copies | UpdraftPlus | UpdraftPlus handles incremental backups, remote storage (Google Drive, S3), and restore — all tested at scale |
| Security firewall | Custom request filtering | Wordfence | Wordfence maintains a live threat feed; custom security code drifts out of date immediately |
| ACF field generation | Writing raw `register_meta()` + REST API integration | ACF Free | ACF handles schema, UI, REST serialization, and field rendering; `register_meta()` alone provides no UI |
| Admin URL protection | Custom redirect + .htaccess rules | WPS Hide Login | WPS Hide Login handles edge cases (lost password links, logout redirects, multisite); rolling your own breaks these |

**Key insight:** WordPress security and email delivery have enormous surface area. Every custom solution discovered in the wild has a known bypass within 12 months. Use actively maintained plugins for these concerns.

---

## Common Pitfalls

### Pitfall 1: ACF Fields Not Appearing in REST Response

**What goes wrong:** `GET /wp-json/wp/v2/pages?slug=home` returns the page but the `acf` key is missing or contains `false`.

**Why it happens:** "Show in REST API" was not enabled on the field group, or the field group location rule doesn't match the actual page (e.g., rule set to match "page template" but home page uses no template).

**How to avoid:**
1. In ACF > Field Groups > [Group Name] > Settings tab: verify "Show in REST API" is ON.
2. Check field group location rules: set to `Page == Home` (by page slug) or `Page is Front Page`.
3. Verify by hitting the API: `curl "https://example.com/wp/wp-json/wp/v2/pages?slug=home"` and checking for `"acf": {...}`.

**Warning signs:** API returns `"acf": false` — this is ACF's response when no fields are found for a post, usually meaning location rules don't match.

### Pitfall 2: CPT REST Endpoint Returns 404

**What goes wrong:** `GET /wp-json/wp/v2/insights` returns `{"code":"rest_no_route",...}`.

**Why it happens:** Rewrite rules were not flushed after registering the CPT. WordPress caches rewrite rules in the database.

**How to avoid:** After deploying CPT registration code, visit **WP Admin > Settings > Permalinks** and click Save (even without changing anything). This flushes rewrite rules.

**Warning signs:** The page `/insights/` on the WordPress frontend also 404s.

### Pitfall 3: CF7 REST Submit Returns 403 or 400

**What goes wrong:** `POST /wp-json/contact-form-7/v1/contact-forms/{id}/feedback` returns 403 or 400.

**Why it happens:** The security mu-plugin's REST write block also blocks CF7 if the namespace whitelist is missing. Alternatively, the `_wpcf7_unit_tag` field is malformed or missing.

**How to avoid:**
1. Whitelist `/contact-form-7/` in the REST write blocker (see Pattern 3 above).
2. Include all required hidden fields: `_wpcf7`, `_wpcf7_version`, `_wpcf7_locale`, `_wpcf7_unit_tag`.
3. Use `FormData` (not JSON) — CF7 REST endpoint expects `multipart/form-data`.

**Warning signs:** 403 immediately = write blocker issue. 400 with `"status":"validation_failed"` = missing CF7 fields.

### Pitfall 4: WP Mail SMTP Fails Silently on Resend

**What goes wrong:** Forms submit successfully (CF7 returns `mail_sent`) but emails never arrive.

**Why it happens:** (a) Resend domain is not verified — Resend silently accepts the API call but doesn't deliver. (b) From email address domain doesn't match the verified Resend domain. (c) API key has wrong permissions.

**How to avoid:**
1. Complete Resend domain verification (DNS TXT/DKIM records) before testing.
2. Set WP Mail SMTP "From Email" to an address on the verified domain (e.g., `noreply@example.com`).
3. Use WP Mail SMTP's built-in "Send Test Email" feature after setup to verify delivery before going live.

**Warning signs:** WP Mail SMTP email log shows "Sent" but inbox never receives it.

### Pitfall 5: WPS Hide Login Breaks on Subdirectory WP Install

**What goes wrong:** After configuring WPS Hide Login, visiting `example.com/wp/gestion` returns 404 or redirects to the old login URL.

**Why it happens:** WPS Hide Login needs to know the WordPress address (not just the site address). On subdirectory installs, the plugin settings page is in WP Admin > Settings > General — scroll to the bottom to find the "WPS Hide Login" URL field.

**How to avoid:** Verify WP Address and Site Address are correctly set in Settings > General before configuring WPS Hide Login. The login URL field in Settings > General should show `example.com/wp/gestion`.

**Warning signs:** Navigating to the new login URL shows 404 or the original `/wp-login.php` page.

### Pitfall 6: `home` Page Not Set as Static Front Page

**What goes wrong:** `/wp-json/wp/v2/pages?slug=home` returns an empty array `[]`.

**Why it happens:** A page with slug `home` exists in WP but isn't set as the static front page (Reading Settings), or was saved with a different slug.

**How to avoid:** After creating the Home page in WP Admin, go to **Settings > Reading** and set "Your homepage displays: A static page" → "Homepage: Home". Verify the page slug is exactly `home`.

**Warning signs:** API returns `[]` when the page clearly exists in the admin.

---

## Code Examples

### REST API Response Shape (expected by Phase 3)

```json
// Source: ACF official docs — https://www.advancedcustomfields.com/resources/wp-rest-api-integration/
// GET example.com/wp/wp-json/wp/v2/pages?slug=home
{
  "id": 5,
  "slug": "home",
  "acf": {
    "hero_title": "Consultoría técnica en minería de alta precisión",
    "hero_subtitle": "Más de 20 años en operaciones de oro y cobre...",
    "hero_cta_primary": "Solicitar diagnóstico inicial",
    "hero_cta_secondary": "Ver servicios",
    "hero_background": "https://example.com/wp/wp-content/uploads/hero-bg.jpg",
    "pillar_1_title": "Criterio técnico senior",
    "pillar_1_text": "Diagnóstico basado en evidencia...",
    "pillar_1_icon": "<svg>...</svg>",
    "step_1_title": "Confidencialidad garantizada",
    "step_1_text": "NDA firmado antes de recibir información...",
    "service_1_title": "Valorización y Desarrollo de Propiedades Mineras",
    "service_1_description": "Evaluación técnico-económica...",
    "service_1_focus": "NI 43-101 · PEA · FS",
    "service_1_icon_url": "https://example.com/wp/wp-content/uploads/icon-valorizacion.svg"
  }
}
```

### CF7 Submit via Fetch (Pattern for Phase 4)

```javascript
// Source: https://contactform7.com/faq/ + verified community pattern
// File: js/api/client.js (Phase 4 implementation reference)

async function submitContactForm(formId, formData) {
    const endpoint = `/wp/wp-json/contact-form-7/v1/contact-forms/${formId}/feedback`;
    // CF7 requires multipart/form-data, NOT application/json
    // Do NOT set Content-Type header — browser sets it with correct boundary
    const response = await fetch(endpoint, {
        method: 'POST',
        body: formData,  // FormData object from form element
    });
    const result = await response.json();
    return result; // { status: 'mail_sent' | 'validation_failed', message: '...' }
}
```

### wp-config.php Security Constants

```php
// Source: WordPress Codex — wp-config.php
// Add these constants to wp-config.php

define('WP_DEBUG', false);           // WP-01: disable debug in production
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('DISALLOW_FILE_EDIT', true);  // WP-02: disable file editor in admin
define('FORCE_SSL_ADMIN', true);     // Force HTTPS for admin pages
```

### .htaccess Security Rules (in `wp/` directory)

```apache
# Source: WordPress Codex + security best practices

# Block direct access to xmlrpc.php (belt-and-suspenders with mu-plugin filter)
<Files xmlrpc.php>
    Order deny,allow
    Deny from all
</Files>

# Block wp-config.php access
<Files wp-config.php>
    Order deny,allow
    Deny from all
</Files>

# Security headers (alternative to mu-plugin send_headers hook)
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

---

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| ACF-to-REST-API plugin | ACF native REST support (`show_in_rest`) | ACF 5.11 (2020) | No extra plugin needed; use ACF built-in toggle |
| CF7 with AJAX handler | CF7 REST API submit | CF7 4.8 (2017) | Native JSON-compatible submit endpoint |
| `rest_enabled` filter to block REST API | Not available — filter removed | WP 4.7 | Cannot block REST API globally this way; use `rest_authentication_errors` instead |
| Wordfence login limiting | Wordfence + WPS Hide Login (separate concerns) | Current | Wordfence handles brute force; WPS Hide Login handles URL obfuscation — use both |

**Deprecated/outdated:**
- `add_filter('rest_enabled', '__return_false')`: This filter was removed in WordPress 4.7. Using it does nothing.
- ACF-to-REST-API plugin (GitHub: airesvsg/acf-to-rest-api): Abandoned; ACF built-in REST support supersedes it entirely.
- `xmlrpc_enabled` filter was the correct approach as of WP 3.5+; still valid in WP 6.x.

---

## Open Questions

1. **Hosting environment for subdirectory WP install**
   - What we know: WordPress will be at `example.com/wp` — this affects `.htaccess` configuration and WP address settings.
   - What's unclear: Whether the hosting provider uses Apache (`.htaccess` works) or Nginx (requires server config; no `.htaccess`). Security header implementation differs.
   - Recommendation: Plan for Apache `.htaccess` as the default; note in plan that Nginx hosting requires equivalent `location` block configuration in the server config.

2. **Home page Page ID for ACF location rules**
   - What we know: ACF location rule for home page fields should target "Page == Home" (by slug).
   - What's unclear: The exact Page ID is not known until the Home page is created in the WP admin.
   - Recommendation: Set ACF location rule to `Post Type == Page AND Page Slug == home`. After page creation, verify the location rule matches.

3. **Resend domain verification ownership**
   - What we know: Resend requires DNS record changes on the sending domain to verify ownership.
   - What's unclear: Whether the developer or the client controls the domain DNS at the time of setup.
   - Recommendation: Plan a task that includes DNS verification steps with placeholder instructions; note that domain access is a prerequisite for email delivery testing.

4. **WP Mail SMTP Resend API key scope**
   - What we know: Resend free tier is confirmed to work with WP Mail SMTP free.
   - What's unclear: Which Resend API key permissions are required (sending only vs. full access).
   - Recommendation: Create a Resend API key with "Sending access" only — minimum required scope.

---

## Validation Architecture

### Test Framework

| Property | Value |
|----------|-------|
| Framework | Manual REST API testing (curl / browser) + WordPress admin verification |
| Config file | None — no automated test runner for WordPress config tasks |
| Quick run command | `curl -s "https://example.com/wp/wp-json/wp/v2/pages?slug=home" \| python3 -m json.tool` |
| Full suite command | Run all verification steps in Phase 2 verification checklist |

### Phase Requirements → Test Map

| Req ID | Behavior | Test Type | Automated Command | File Exists? |
|--------|----------|-----------|-------------------|-------------|
| WP-01 | WP returns valid JSON from REST API; HTTPS active | smoke | `curl -s -o /dev/null -w "%{http_code}" https://example.com/wp/wp-json/` → 200 | ❌ Wave 0 |
| WP-02 | `/users` returns 403; XML-RPC returns 403; `/gestion` loads login form | smoke | `curl -s -o /dev/null -w "%{http_code}" https://example.com/wp/wp-json/wp/v2/users` → 403 | ❌ Wave 0 |
| WP-03 | Home page REST response contains `acf` key with all field groups | smoke | `curl -s "https://example.com/wp/wp-json/wp/v2/pages?slug=home" \| python3 -c "import sys,json; d=json.load(sys.stdin); assert 'acf' in d[0]"` | ❌ Wave 0 |
| WP-04 | ACF fields visible in REST — `hero_title`, `pillar_1_title`, etc. | smoke | Manual: inspect JSON output from WP-03 curl for expected field names | manual-only |
| WP-05 | CF7 REST submit returns `mail_sent` status | integration | `curl -X POST "https://example.com/wp/wp-json/contact-form-7/v1/contact-forms/{id}/feedback" -F "your-name=Test" ...` | ❌ Wave 0 |
| WP-06 | Email arrives in configured inbox | integration | Send test via WP Mail SMTP admin panel + check inbox | manual-only |
| WP-07 | `/wp-json/wp/v2/insights` returns array (seeded posts) | smoke | `curl -s "https://example.com/wp/wp-json/wp/v2/insights" \| python3 -c "import sys,json; d=json.load(sys.stdin); assert isinstance(d, list)"` | ❌ Wave 0 |
| WP-08 | Rank Math Organization schema present in page source | smoke | `curl -s https://example.com/ \| grep -o '"@type":"Organization"'` | ❌ Wave 0 |
| WP-09 | Wordfence active; UpdraftPlus scheduled backup configured | manual | WP Admin > Wordfence > Dashboard shows "Protected"; UpdraftPlus > Settings shows schedule | manual-only |

### Sampling Rate
- **Per task commit:** Run relevant smoke curl command for that task's requirement
- **Per wave merge:** Run all smoke commands (WP-01, WP-02, WP-03, WP-05, WP-07, WP-08)
- **Phase gate:** All smoke commands green + manual verifications (WP-04, WP-06, WP-09) confirmed before `/gsd:verify-work`

### Wave 0 Gaps
- [ ] `scripts/verify-wp-phase2.sh` — shell script bundling all curl smoke tests with pass/fail output
- [ ] Seed script or WP CLI commands for creating Home page + inserting placeholder ACF content
- [ ] Seed script for creating 1 Insights CPT post (for WP-07 verification)

---

## Sources

### Primary (HIGH confidence)
- `https://www.advancedcustomfields.com/resources/wp-rest-api-integration/` — ACF REST API, `show_in_rest` toggle, response structure
- `https://www.advancedcustomfields.com/resources/register-fields-via-php/` — `acf_add_local_field_group()` pattern
- `https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-rest-api-support-for-custom-content-types/` — `show_in_rest` for CPT
- `https://wpmailsmtp.com/docs/a-complete-guide-to-wp-mail-smtp-mailers/` — Resend confirmed in free tier
- `https://wpmailsmtp.com/docs/how-to-set-up-the-resend-mailer-in-wp-mail-smtp/` — WP Mail SMTP Resend setup steps
- `https://rankmath.com/kb/organization-schema/` — Rank Math Organization schema via Local SEO module (free)
- `https://wordpress.org/plugins/wps-hide-login/` — WPS Hide Login subfolder compatibility confirmed

### Secondary (MEDIUM confidence)
- `https://simplileap.com/blog/technical/how-to-submit-contact-form-7-data-via-rest-api/` — CF7 REST endpoint URL and required fields (verified against CF7 FAQ)
- `https://contactform7.com/faq/` — CF7 REST API usage since v4.8 (official CF7 site)
- `https://wpcodebox.com/tutorial/disable-rest-api/` — REST write block pattern with CF7 whitelist (community, verified pattern matches WP Codex filter)

### Tertiary (LOW confidence — needs validation at implementation)
- Community patterns for `rest_endpoints` filter to remove `/users` endpoint — widely referenced but test against installed WP version
- `.htaccess` security headers approach — depends on Apache/mod_headers being available on the specific host

---

## Metadata

**Confidence breakdown:**
- Standard stack: HIGH — all plugins verified as free-tier capable; Resend in WP Mail SMTP confirmed via official mailer guide
- Architecture patterns: HIGH — ACF REST API, CPT registration, CF7 endpoint confirmed via official docs
- Security mu-plugin: MEDIUM — patterns are well-established but the exact CF7 namespace whitelist string needs testing on the live install
- Pitfalls: HIGH — all pitfalls sourced from official docs or widely verified community knowledge

**Research date:** 2026-03-17
**Valid until:** 2026-04-17 (stable ecosystem — WP, ACF, CF7 change slowly; 30-day horizon safe)

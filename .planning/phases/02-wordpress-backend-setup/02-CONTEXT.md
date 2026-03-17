# Phase 2: WordPress Backend Setup - Context

**Gathered:** 2026-03-17
**Status:** Ready for planning

<domain>
## Phase Boundary

Instalar y configurar WordPress como backend/CMS headless: instalación base, hardening de seguridad, field groups ACF para todas las secciones del home, CPT Insights, Contact Form 7 con entrega de email confiable, y plugins de SEO y seguridad. El resultado es un WordPress en producción con la REST API lista para servir respuestas reales al frontend. El frontend HTML/CSS/JS (Phase 1) no se toca en esta fase.

</domain>

<decisions>
## Implementation Decisions

### Hosting & CORS

- **Estructura de dominios**: WordPress instalado en `/wp` subdirectorio del mismo dominio — `example.com/wp`. Frontend sirve desde `example.com/`.
- **API base URL**: `example.com/wp/wp-json/wp/v2/` — path por defecto, sin rewrites. El módulo `js/api/client.js` (Phase 3) usará esta base.
- **CORS**: No se requieren headers CORS — mismo origen. No instalar plugin de CORS.
- **Entrega**: El desarrollador configura WordPress completo; el cliente edita contenido vía WP admin sin tocar código.
- **Dominio real**: Placeholder `example.com` en el plan — se reemplaza con el dominio real en el momento de instalación.

### ACF Free — workaround sin Repeater

- **No se usará ACF Pro** — ACF Free es suficiente para v1.
- **Estructura de campos indexados** para secciones multi-ítem:
  - `home_trust_pillars`: `pillar_1_title`, `pillar_1_text`, `pillar_1_icon`, `pillar_2_title` … `pillar_4_icon` (4 pilares fijos)
  - `home_methodology`: `step_1_title`, `step_1_text`, `step_2_title`, `step_2_text` … `step_5_title`, `step_5_text` (5 pasos fijos)
  - `home_services`: `service_1_title`, `service_1_description`, `service_1_focus`, `service_1_icon_url` … `service_4_icon_url` (4 servicios fijos)
- **Inflexibilidad es aceptable**: estas secciones tienen ítems fijos en v1; el cliente no necesita agregar/quitar pasos o pilares.
- **Insights CPT**: usa ACF fields normales (no repeater) — `insight_category`, `insight_excerpt`, `insight_featured_image` por post.

### Email delivery

- **Servicio**: Resend — free tier (3,000 emails/mes), soporte nativo en WP Mail SMTP.
- **Plugin**: WP Mail SMTP configurado con driver Resend + API key.
- **Inbox de destino**: `contacto@example.com` (placeholder — reemplazar en deploy con el email real del cliente).
- **CF7**: Formulario configurado con `To: contacto@example.com`, subject `[FN Mining Advisor] Consulta de {nombre}`.

### Admin URL

- **Slug personalizado**: `/gestion` — reemplaza `/wp-admin/`.
- **Plugin**: WPS Hide Login (liviano, sin conflictos con Wordfence).
- **Login URL**: `example.com/wp/gestion`

### Security hardening

**Mínimos WP-02:**
- Endpoint `/wp-json/wp/v2/users` bloqueado (retorna 403 o array vacío vía filtro REST)
- XML-RPC desactivado (`add_filter('xmlrpc_enabled', '__return_false')` en mu-plugin)
- Admin URL renombrada a `/gestion` (WPS Hide Login)
- Headers de seguridad: `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `X-XSS-Protection: 1; mode=block`, `Referrer-Policy: strict-origin-when-cross-origin` — vía `.htaccess` o mu-plugin

**Adicionales decididos:**
- `DISALLOW_FILE_EDIT = true` en `wp-config.php` — desactiva edición de archivos desde el admin
- **Login brute-force**: cubierto por Wordfence (ya en WP-09) — no plugin adicional
- **REST API writes bloqueados para no autenticados**: mu-plugin que retorna 403 en POST/PUT/DELETE si el usuario no está autenticado
- **REST API reads**: completamente públicas (sin restricción de origen) — el contenido es público y el frontend necesita acceso sin autenticación

### Claude's Discretion

- Orden exacto de instalación de plugins (cuál va primero)
- Configuración interna de Wordfence y UpdraftPlus (horario de backups, destino)
- Nombres exactos de los field groups en el ACF admin (labels de UI, no los field names que sí están decididos)
- Contenido seed de los ACF fields en el Home page (placeholder profesional en español)
- Estructura del mu-plugin de seguridad (puede ser un archivo o varios)

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Phase 1 — Frontend ya construido
- `.planning/phases/01-design-system-static-shell/01-CONTEXT.md` — Decisiones del shell HTML: secciones, servicios, pilares, pasos de metodología. Los field names ACF deben coincidir con los `data-api-target` attributes del HTML.
- `.planning/phases/01-design-system-static-shell/01-RESEARCH.md` — Notas técnicas sobre integración API; incluye los `data-api-target` que el JavaScript de Phase 4 usará.

### Requirements
- `.planning/REQUIREMENTS.md` — WP-01 a WP-09: especificaciones exactas de WordPress, ACF field groups (campo por campo), CPT Insights, CF7, WP Mail SMTP, Rank Math, Wordfence, UpdraftPlus.

### Project context
- `.planning/PROJECT.md` — Decisiones de stack: WordPress solo como CMS/backend headless, ACF Free, CF7, sin tema WP personalizado.

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- `index.html`: Contiene `data-api-target` attributes en secciones — estos IDs corresponden directamente a los ACF field names que se configurarán. Los field names deben coincidir para que Phase 4 (API integration) funcione sin cambios.
- `js/animations.js`: Usa `IntersectionObserver` — patrón a mantener en Phase 4 cuando se hidrate el DOM con datos de la API.

### Established Patterns
- CSS tokens en `css/tokens.css` — Phase 2 no toca CSS, pero Phase 4 usará los mismos tokens para elementos hidratados dinámicamente.
- ES modules en `js/` — Phase 3 agregará `js/api/client.js` y `js/api/transforms.js` como módulos adicionales al mismo patrón.

### Integration Points
- `index.html` `<section id="hero">`, `<section id="servicios">`, `<section id="metodologia">`, `<section id="propuesta-de-valor">` — estos IDs son los targets de la API integration de Phase 4. Los ACF field names de Phase 2 deben nombrarse de forma que los transforms de Phase 3 puedan mapearlos limpiamente.
- `index.html` `<form id="contact-form" data-cf7-form-id="">` — el `data-cf7-form-id` se llenará con el ID real del formulario CF7 tras su creación en Phase 2.

</code_context>

<specifics>
## Specific Ideas

- El cliente editará contenido regularmente desde el WP admin — los field labels en ACF deben ser claros en español (ej. "Título del héroe" no "hero_title")
- Los ACF fields deben tener instrucciones inline en el admin (campo `instructions` de ACF) para que el cliente sepa qué escribir en cada campo
- El seed content de los ACF fields debe usar el copy placeholder minero ya escrito en el HTML de Phase 1 (copiar desde `index.html` para mantener consistencia)

</specifics>

<deferred>
## Deferred Ideas

- Ninguna idea de scope creep surgió — la discusión se mantuvo dentro del dominio de Phase 2.

</deferred>

---

*Phase: 02-wordpress-backend-setup*
*Context gathered: 2026-03-17*

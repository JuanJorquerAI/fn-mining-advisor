# Requirements: FN Mining Advisor

**Defined:** 2026-03-16
**Core Value:** Transmitir confianza, autoridad técnica y criterio profesional senior en minería — cada elemento del diseño, copy y estructura debe reforzar credibilidad y convertir visitas a contacto inicial.

## v1 Requirements

### Design System

- [x] **DSYS-01**: Sistema de CSS custom properties define paleta completa (grafito, dorado, blanco cálido, verde petróleo, grises), tipografías (Cormorant Garamond + Inter), spacing, border-radius y sombras
- [x] **DSYS-02**: El sistema visual usa tokens flexibles que permiten cambiar nombre de marca (FN → NMC) sin reescribir CSS de layout o componentes
- [x] **DSYS-03**: Biblioteca de componentes base documentada: botones (primario/secundario/ghost), cards de servicio, badges, inputs de formulario, sección-header, dividers

### HTML Shell

- [x] **SHEL-01**: Estructura HTML semántica completa del home con 9 secciones: Hero, Propuesta de Valor, Servicios, Innovación/Sustentabilidad, Metodología, Experiencia, Insights, CTA Final, Contacto
- [x] **SHEL-02**: Cada sección tiene contenido estático HTML hardcodeado como fallback (la página es 100% funcional sin JavaScript)
- [x] **SHEL-03**: Header sticky con logo (SVG/PNG del cliente), navegación anchor links a secciones, y botón CTA destacado
- [x] **SHEL-04**: Footer con datos de contacto directos, links de secciones y nota legal básica

### Animaciones y UX

- [x] **UX-01**: Animaciones fade-in al scroll vía Intersection Observer API — sin librerías externas
- [x] **UX-02**: Hover sutil en cards y botones (transform scale, color transition) — sin animaciones extravagantes
- [x] **UX-03**: Navegación anchor con scroll suave (scroll-behavior: smooth) y offset para header sticky

### WordPress Setup

- [ ] **WP-01**: WordPress 6.9 instalado con PHP 8.2+, HTTPS forzado, depuración desactivada en producción
- [ ] **WP-02**: Hardening de seguridad: endpoint /wp-json/wp/v2/users bloqueado, XML-RPC desactivado, URL de admin personalizada, encabezados de seguridad configurados
- [ ] **WP-03**: ACF Free instalado con field groups creados para: home_hero (hero_title, hero_subtitle, hero_cta_primary, hero_cta_secondary, hero_background), home_trust_pillars (repeater: pillar_title, pillar_text, pillar_icon), home_services (ver SECT-01), home_methodology (repeater: step_number, step_title, step_text), home_experience (experience_text, experience_highlights), home_cta_final (cta_title, cta_text, cta_primary, cta_secondary)
- [ ] **WP-04**: Todos los ACF field groups tienen "Show in REST API" habilitado con nombres de campo explícitos
- [ ] **WP-05**: Contact Form 7 instalado con formulario de contacto configurado (nombre, empresa, email, teléfono, mensaje) y endpoint REST activo
- [ ] **WP-06**: WP Mail SMTP instalado y configurado con servicio transaccional (Resend o Mailgun) — correos de formulario se entregan de forma confiable
- [ ] **WP-07**: Custom Post Type "Insights" (slug: `insights`) registrado con soporte REST API, campos ACF: insight_category, insight_excerpt, insight_featured_image
- [ ] **WP-08**: Rank Math SEO instalado con schema Organization configurado (nombre, logo, país, sector)
- [ ] **WP-09**: Wordfence y UpdraftPlus instalados y configurados (seguridad + backups automáticos)

### API Integration

- [ ] **API-01**: Módulo `js/api/client.js` con función `fetchEndpoint(url, options)` que incluye: manejo de errores sin romper el DOM, timeout configurable, y retorno de datos o null en fallo
- [ ] **API-02**: Módulo `js/api/transforms.js` con funciones de transformación por sección que normalizan la respuesta ACF (maneja `acf: false` sin TypeError)
- [ ] **API-03**: Hidratación del Hero desde WP API con fallback al contenido HTML estático — el LCP nunca depende de un fetch completado
- [ ] **API-04**: Hidratación de Servicios desde WP API — 4 service cards se reemplazan con datos desde ACF cuando la respuesta llega
- [ ] **API-05**: Hidratación de Insights desde CPT — lista los últimos N posts del CPT "Insights"; si no hay posts, muestra estado "próximamente" sin errores
- [ ] **API-06**: Hidratación de Metodología y Pilares de Confianza desde WP API — pasos y pilares editables sin tocar código

### Secciones de Contenido

- [x] **SECT-01**: Sección Servicios con 4 cards: Valorización y Desarrollo de Propiedades Mineras, Optimización de Procesos Metalúrgicos y Operacionales, Clínica Metalúrgica, Capacitación en Procesos Metalúrgicos — cada card tiene título, descripción, foco de negocio y CTA "Consultar por este servicio"
- [x] **SECT-02**: Bloque Propuesta de Valor con 4 pilares visuales respondiendo: por qué confiar, qué problemas resuelve, qué diferencia a la consultora, visión de largo plazo
- [x] **SECT-03**: Bloque Innovación y Sustentabilidad con 4 subpuntos técnicos (no cliché verde): innovación aplicada, optimización energética, buenas prácticas internacionales, reducción de impacto ambiental
- [x] **SECT-04**: Sección Metodología con 5 pasos secuenciales: NDA/confidencialidad → recepción de antecedentes → diagnóstico inicial → propuesta técnica y económica → ejecución y acompañamiento
- [x] **SECT-05**: Sección Experiencia Profesional con bloque editorial elegante: experiencia en minería de oro y cobre, trayectoria nacional e internacional, criterio técnico senior — estructurada para añadir cifras/hitos futuros
- [x] **SECT-06**: Sección Insights preparada para artículos futuros — muestra cards placeholder y consume CPT "Insights" desde WP API cuando hay contenido
- [x] **SECT-07**: CTA Final con mensaje de conversión orientado a diagnóstico inicial, CTA principal (formulario) y CTA secundario (WhatsApp)

### Contacto

- [ ] **CONT-01**: Formulario de contacto con campos: nombre, empresa, email, teléfono, mensaje — enviado vía CF7 REST API con feedback visual (éxito/error)
- [x] **CONT-02**: Nota de confidencialidad visible junto al formulario ("Sus datos y consulta son tratados con estricta confidencialidad")
- [x] **CONT-03**: Botón/enlace de WhatsApp en sección CTA Final y en la sección de contacto
- [x] **CONT-04**: Email de contacto directo visible en la sección de contacto
- [x] **CONT-05**: Enlace a perfil LinkedIn del consultor en footer y/o sección de experiencia

### SEO y Performance

- [ ] **SEO-01**: Jerarquía semántica H1/H2/H3 correcta en todo el documento — una sola H1 en el hero, H2 por sección, H3 en subsecciones y cards
- [ ] **SEO-02**: JSON-LD con schema Organization en `<head>`: nombre, url, logo, contactPoint, areaServed (Chile, Latinoamérica), knowsAbout (minería, metalurgia)
- [ ] **SEO-03**: Metadatos Open Graph y Twitter Card completos: og:title, og:description, og:image, og:type, twitter:card
- [ ] **SEO-04**: Core Web Vitals: font-display:swap en tipografías, lazy loading en imágenes, dimensiones explícitas en `<img>` para evitar CLS, favicon en múltiples tamaños
- [ ] **SEO-05**: HTML mobile-first con viewport correcto, sin contenido horizontal overflow, touch targets mínimo 44px

### Responsive

- [x] **RESP-01**: Layout responsive funcional en mobile (320px+), tablet (768px+) y desktop (1024px+) — sin overflow horizontal en ningún breakpoint
- [x] **RESP-02**: Menú de navegación mobile con hamburger menu o menú colapsado — accesible y sin JavaScript externo
- [x] **RESP-03**: Cards de servicios cambian de grid multi-columna a columna única en mobile
- [x] **RESP-04**: Formulario de contacto 100% usable en mobile con inputs correctamente dimensionados

### Escalabilidad

- [x] **SCAL-01**: Estructura de directorios preparada para secciones futuras: `/pages/blog/`, `/pages/casos-de-exito/`, `/pages/capacitaciones/`
- [x] **SCAL-02**: El HTML shell usa `<article>` y `<section>` con IDs semánticos que sirven como anchor links y futuros targets de SPA si se agrega router
- [x] **SCAL-03**: Logo integrado con variable CSS `--logo-src` y versiones previstas: principal, simplificada, mobile, favicon — espacio reservado en header para cuando el cliente entregue el SVG

## v2 Requirements

### Páginas Adicionales

- **PAG-01**: Página de Blog/Artículos técnicos — lista paginada de CPT Insights con filtros por categoría
- **PAG-02**: Página de Casos de Éxito — CPT propio con estructura de caso (problema, solución, resultado)
- **PAG-03**: Página de Capacitaciones — catálogo de cursos con modalidades y formulario de inscripción
- **PAG-04**: Landing pages adicionales por servicio — una URL por cada servicio principal

### Funcionalidades Avanzadas

- **FUNC-01**: Calculadora de diagnóstico inicial (quiz interactivo para derivar al servicio adecuado)
- **FUNC-02**: Sistema de descarga de documentos técnicos con captura de email
- **FUNC-03**: Integración con CRM (HubSpot u otro) para gestión de leads desde el formulario
- **FUNC-04**: Newsletter básico de Insights técnicos

## Out of Scope

| Feature | Reason |
|---------|--------|
| Tema WordPress personalizado | Frontend desacoplado — WP es solo CMS/backend |
| Panel de administración personalizado | WP admin nativo es suficiente para el cliente |
| Autenticación de usuarios en frontend | No hay área privada en v1 |
| E-commerce o cotizaciones automatizadas | No corresponde al modelo de negocio de consultoría senior |
| App móvil nativa | Web mobile-first es suficiente para v1 |
| Plataforma de e-learning | Capacitaciones son solo sección informativa en v1 |
| Chatbot o live chat | Anti-feature: reduce percepción de seriedad en B2B minero |
| Animaciones complejas (parallax, partículas, SVG animado) | Reducen seriedad y performance |
| Sistema de comentarios en Insights | Complejidad y riesgo de moderación sin beneficio B2B claro |
| Integración con redes sociales (feed) | Anti-feature para consultora B2B técnica |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| DSYS-01, DSYS-02, DSYS-03 | Phase 1 | Pending |
| SHEL-01, SHEL-02, SHEL-03, SHEL-04 | Phase 1 | Pending |
| UX-01, UX-02, UX-03 | Phase 1 | Pending |
| SECT-01, SECT-02, SECT-03, SECT-04, SECT-05, SECT-06, SECT-07 | Phase 1 | Pending |
| CONT-02, CONT-03, CONT-04, CONT-05 | Phase 1 | Pending |
| RESP-01, RESP-02, RESP-03, RESP-04 | Phase 1 | Pending |
| SCAL-01, SCAL-02, SCAL-03 | Phase 1 | Pending |
| WP-01, WP-02, WP-03, WP-04, WP-05, WP-06, WP-07, WP-08, WP-09 | Phase 2 | Pending |
| API-01, API-02 | Phase 3 | Pending |
| API-03, API-04, API-05, API-06, CONT-01 | Phase 4 | Pending |
| SEO-01, SEO-02, SEO-03, SEO-04, SEO-05 | Phase 5 | Pending |

**Coverage:**
- v1 requirements: 49 total
- Mapped to phases: 49
- Unmapped: 0

**Phase 6 note:** Pre-Launch Hardening carries no new requirements — it is a verification phase that validates all prior phase requirements work end-to-end under production conditions.

---
*Requirements defined: 2026-03-16*
*Last updated: 2026-03-16 — traceability updated after roadmap creation*

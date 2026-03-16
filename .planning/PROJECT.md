# FN Mining Advisor — Landing Corporativa

## What This Is

Landing page corporativa para **FN Mining Advisor**, consultora minera y metalúrgica senior. El sitio es una landing larga (single-page) con frontend desacoplado en HTML/CSS/JS puro, alimentada por contenido administrable desde WordPress vía REST API. Dirigida a empresas y proyectos mineros B2B que requieren asesoría técnica en valorización de propiedades, optimización de procesos y capacitación metalúrgica.

## Core Value

**Transmitir confianza, autoridad técnica y criterio profesional senior en minería** — cada elemento del diseño, copy y estructura debe reforzar credibilidad y convertir visitas a contacto inicial.

## Requirements

### Validated

(None yet — ship to validate)

### Active

- [ ] Landing page HTML/CSS/JS completa con las 9 secciones definidas
- [ ] Diseño corporativo minero premium (paleta grafito/dorado, tipografía Cormorant + Inter)
- [ ] Responsive total (mobile-first) con navegación sticky y anchor links
- [ ] Hero con overlay, headline, subheadline y 2 CTAs
- [ ] Bloque de propuesta de valor con 4 pilares de confianza
- [ ] Sección de 4 servicios principales en cards con CTA individual
- [ ] Bloque transversal de innovación/sustentabilidad (sobrio, técnico)
- [ ] Metodología de trabajo paso a paso (NDA → diagnóstico → propuesta → ejecución)
- [ ] Sección de experiencia profesional con enfoque en autoridad técnica
- [ ] Sección de contenido/insights preparada para artículos futuros desde WP
- [ ] CTA final de conversión con mensaje de diagnóstico
- [ ] Formulario de contacto (nombre, empresa, email, teléfono, mensaje)
- [ ] SEO técnico: H1/H2/H3 semántico, metadatos, schema Organization básico
- [ ] Integración con WordPress REST API para contenido dinámico (hero, servicios, insights)
- [ ] Modelo de datos documentado: campos ACF y estructura de endpoints
- [ ] Setup de WordPress: custom post types, ACF fields, plugin recomendations
- [ ] Textos placeholder profesionales en español (minería/metalurgia)
- [ ] Logo SVG/PNG del cliente integrado en header
- [ ] Estructura preparada para escalar (blog, casos de éxito, capacitaciones, nuevas landings)

### Out of Scope

- Construcción de tema WordPress completo — solo frontend desacoplado para el home
- Diseño del panel WordPress o área de administración
- Integración con sistemas externos (CRM, ERP, plataforma e-learning) — fase futura
- App móvil nativa
- E-commerce o cotizaciones automatizadas
- Autenticación de usuarios en el frontend
- Capacitaciones digitales como plataforma — solo sección placeholder por ahora

## Context

- **Nombre temporal**: "FN Mining Advisor" — puede ajustarse a "Nuñez Mining Consulting / NMC" sin rehacer UI
- **Sistema visual**: Diseñado flexible para cambio de nombre; el branding usa tokens CSS
- **Cliente tiene logo**: SVG/PNG disponible para integrar
- **WordPress**: No instalado aún — el proyecto incluye guía de setup + ACF + endpoints
- **Contenido**: Placeholders profesionales en español (minería/metalurgia) a reemplazar
- **Mercado**: B2B, empresas mineras en Chile y Latinoamérica, proyectos greenfield/brownfield
- **Referencias visuales (inspiración conceptual, no copia)**: Gold Fields, Mettest / McClelland Laboratories, Mercado Minero
- **Competencia percibida**: Consultoras senior, no agencias ni startups

## Constraints

- **Tech stack**: HTML + CSS + JavaScript moderno; no frameworks JS pesados (no React/Vue/Angular) — vanilla JS con módulos ES6
- **CMS**: WordPress como backend/CMS exclusivo — sin headless CMS alternativo
- **Frontend API**: WordPress REST API + ACF (Advanced Custom Fields) para datos estructurados
- **Performance**: Mobile-first, sin constructores visuales pesados, mínimo JS de terceros
- **Branding**: Sistema visual con CSS custom properties para facilitar cambio de nombre/colores
- **No template genérico**: Diseño custom que transmita consultora minera senior, no agencia

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Frontend desacoplado (HTML/CSS/JS puro) | Performance, control total, sin dependencia de tema WP | — Pending |
| WordPress solo como CMS/backend | Cliente ya conoce WP, bajo costo de mantenimiento | — Pending |
| ACF para campos estructurados | Estándar del ecosistema WP, fácil para cliente no técnico | — Pending |
| Paleta grafito + dorado mineral | Transmite industria minera premium sin ser cliché | — Pending |
| Tipografía Cormorant Garamond + Inter | Autoridad institucional + legibilidad técnica moderna | — Pending |
| Branding con CSS tokens | Facilita cambio de nombre FN → NMC sin rehacer diseño | — Pending |

---
*Last updated: 2026-03-16 after initialization*

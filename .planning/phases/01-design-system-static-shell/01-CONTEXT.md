# Phase 1: Design System + Static Shell - Context

**Gathered:** 2026-03-16
**Status:** Ready for planning

<domain>
## Phase Boundary

Construir el HTML shell completo con las 9 secciones en orden, el sistema de design tokens CSS, y contenido estático placeholder en español (minería/metalurgia). La página debe ser 100% navegable y visualmente completa sin JavaScript ni conexión a API. Animaciones (fade-in scroll) y comportamiento del header (transparente→sólido) sí requieren JS mínimo inline — no librerías externas.

</domain>

<decisions>
## Implementation Decisions

### Hero visual

- **Fondo**: Gradiente CSS de carbono (#15181C) a gris acero oscuro (#2A3038) — sin imagen real por ahora. Preparar estructura `<figure>` o CSS `background-image` para que cuando llegue la imagen real del cliente, se reemplace con una sola línea CSS.
- **Layout del texto**: Centrado, con línea de acento dorada bajo el H1 (border-bottom en `::after` del heading o elemento separador explícito)
- **Elementos**: H1 (headline principal) + párrafo subheadline técnico-comercial + 2 CTAs en fila horizontal (primario dorado, secundario ghost/outline) + frase de trayectoria bajo los CTAs (ej. "+20 años de experiencia en minería de oro y cobre, Chile y Latinoamérica")
- **Altura**: 100vh en desktop; min-height adaptativo en mobile para que el contenido no quede cortado
- **Scroll indicator**: Flecha o chevron animado sutil en la parte inferior del hero invitando al scroll
- **Sin stats/cifras** en el hero — solo la frase de trayectoria breve

### Ritmo de color entre secciones

**Secciones con fondo oscuro (carbono #15181C o variante):**
- Hero — establece tono premium inmediato
- Innovación/Sustentabilidad — banda de contraste a mitad de página
- Metodología — da peso y seriedad al proceso
- CTA Final — contraste alto refuerza urgencia de contactar

**Secciones con fondo claro (alternando):**
- Propuesta de Valor: blanco cálido (#F5F5F2)
- Servicios: gris claro (#E9ECEF)
- Experiencia Profesional: blanco cálido (#F5F5F2)
- Insights/Contenido: gris claro (#E9ECEF)
- Contacto: blanco cálido (#F5F5F2)

**Usos del dorado mineral (#B88A3B):**
- Línea decorativa bajo H2 de cada sección (border-bottom o pseudo-elemento `::after` de 2-3px, ancho ~40-60px)
- Background de botones CTA primarios (con texto en carbono para contraste)
- Números de pasos de metodología (01, 02, 03, 04, 05) en dorado grande
- Border-left de 3px en los 4 pilares de confianza

### Densidad y layout de servicios

- **Grid**: 2 columnas × 2 filas (grid 2x2) en desktop; 1 columna en mobile; 2 columnas en tablet
- **Contenido de cada card**:
  - Icono SVG lineal (técnico, relacionado con el servicio — no genérico)
  - Título del servicio (H3)
  - Descripción de 2-3 líneas
  - Etiqueta "Foco:" con lista corta de bullets o texto inline (ej. "Evaluación técnica · Diagnóstico de pertenencias · Valorización")
  - **Sin CTA individual** en cada card — el CTA está en la sección general, no en cada card
- **Estilo de card**: Borde fino 1px #E9ECEF + box-shadow sutil (0 2px 8px rgba(0,0,0,0.06)) + fondo blanco + padding generoso
- **Hover**: Ligero lift (transform: translateY(-2px)) + sombra más pronunciada + borde superior dorado aparece en hover

### Header y navegación

- **Comportamiento scroll**: Transparente sobre el hero → sólido (background carbono #15181C + sombra) al superar la altura del hero. Transición con `transition: background 0.3s ease`. Detectado con `IntersectionObserver` o `scroll` event listener simple.
- **Logo**: Logotipo tipográfico CSS — "FN" en Cormorant Garamond semi-bold con color dorado (#B88A3B), " Mining Advisor" en Inter light/regular en blanco — todo en un `<a href="/">` con `aria-label`. Preparado con `var(--logo-text)` y `var(--logo-accent)` para cuando llegue el SVG real.
- **Nav desktop**: Links de anchor: Servicios, Metodología, Experiencia, Contacto + botón CTA "Solicitar diagnóstico" (primario dorado) a la derecha
- **Nav mobile**: Botón hamburger a la derecha, al tap → overlay full-screen con fondo carbono, links grandes centrados (Cormorant Garamond, 24px+), botón CTA y opción de cierre (X). Animación de apertura simple (fade-in o slide-down).

### Claude's Discretion

- Tipografías específicas: `font-size` exactos de la escala tipográfica (H1, H2, H3, body, small) — Claude elige dentro del sistema Cormorant + Inter
- Iconos SVG de servicios — Claude elige iconos técnicos lineales apropiados para cada servicio (puede usar Heroicons, Phosphor Icons, o SVGs inline)
- Copy placeholder específico — Claude genera textos placeholder profesionales en español con terminología minera/metalúrgica real (flotación, conminución, NI 43-101, recuperación metalúrgica, etc.)
- Espaciado preciso entre secciones — Claude usa `padding-block` generoso (80-120px desktop, 60px mobile) de forma consistente
- Scroll indicator animation del hero — Claude elige implementación (CSS animation pura)
- Comportamiento exacto del footer — estructura y contenido

</decisions>

<canonical_refs>
## Canonical References

**Downstream agents MUST read these before planning or implementing.**

### Project context
- `.planning/PROJECT.md` — Visión, nombre de marca, constraints de stack, key decisions sobre tipografía y paleta
- `.planning/REQUIREMENTS.md` — Requirements DSYS-01~03, SHEL-01~04, UX-01~03, SECT-01~07, CONT-02~05, RESP-01~04, SCAL-01~03 (todos los requirements de Fase 1)

### Research
- `.planning/research/STACK.md` — Stack recomendado: ES modules, CSS custom properties, BEM, sin build tool, Intersection Observer API
- `.planning/research/FEATURES.md` — Feature landscape B2B: table stakes, diferenciadores, anti-features para consultora minera
- `.planning/research/ARCHITECTURE.md` — Estructura de directorios recomendada, patrón progressive enhancement (contenido estático primero)
- `.planning/research/PITFALLS.md` — Pitfalls a evitar: no depender de fetch para LCP, CSS tokens bloqueados antes de construir secciones, no template genérico
- `.planning/research/SUMMARY.md` — Síntesis ejecutiva del research

### Paleta de colores (valores exactos)
- Carbono: `#15181C`
- Gris acero oscuro (hero gradiente): `#2A3038`
- Gris acero: `#5E6873`
- Blanco cálido: `#F5F5F2`
- Dorado mineral: `#B88A3B`
- Dorado claro: `#D6B15A`
- Verde petróleo: `#1F4D4A`
- Gris claro: `#E9ECEF`

### Tipografías
- Headings: Cormorant Garamond (Google Fonts) — Regular 400, SemiBold 600
- Body/UI: Inter (Google Fonts) — Regular 400, Medium 500
- Carga: `font-display: swap` obligatorio

No external specs beyond the files listed above — requirements are fully captured in this context and in REQUIREMENTS.md.

</canonical_refs>

<code_context>
## Existing Code Insights

### Reusable Assets
- Proyecto greenfield: no hay código existente. Todo se crea desde cero.

### Established Patterns
- Stack decidido: HTML semántico + CSS puro con custom properties + vanilla JS ES modules
- Sin build tool (no Vite/Webpack) — archivos servidos directamente
- Arquitectura de archivos esperada:
  ```
  /
  ├── index.html
  ├── css/
  │   ├── tokens.css          (custom properties)
  │   ├── base.css            (reset + tipografía base)
  │   ├── layout.css          (header, footer, grid)
  │   └── sections/           (un archivo por sección)
  ├── js/
  │   ├── main.js             (punto de entrada, type="module")
  │   ├── header.js           (scroll behavior, mobile nav)
  │   └── animations.js       (Intersection Observer)
  ├── assets/
  │   ├── icons/              (SVGs de servicios)
  │   └── images/             (placeholder logo, futura imagen hero)
  └── pages/
      ├── blog/
      ├── casos-de-exito/
      └── capacitaciones/
  ```

### Integration Points
- Esta fase es la base de todo. Fases posteriores (3 y 4) agregan `js/api/` y modifican las secciones para hidratar desde WP.
- Los IDs de sección son los anchor targets: `#hero`, `#valor`, `#servicios`, `#innovacion`, `#metodologia`, `#experiencia`, `#insights`, `#contacto`
- El logo en el header debe estar en un elemento con clase `.site-logo` preparado para recibir `<img src="logo.svg">` en reemplazo del tipográfico CSS

</code_context>

<specifics>
## Specific Ideas

- El logo tipográfico: "**FN**" (Cormorant, dorado, semibold) + " Mining Advisor" (Inter, blanco, light). Esto replica la convención de marcas mineras que usan iniciales prominentes.
- Los números de metodología (01–05) deben ser grandes, en Cormorant Garamond, color dorado — evoca numeración de reportes técnicos y documentos de ingeniería.
- La frase de trayectoria bajo los CTAs del hero: en texto pequeño, con un separador de línea fina dorada antes — estética de firma o dateline.
- El ritmo oscuro/claro busca que el visitante sienta "presencia" en las secciones clave (hero, metodología, CTA) y "apertura" en las secciones de contenido (servicios, experiencia).
- No usar emojis, ilustraciones flat, ni iconografía startup. Los iconos deben ser técnicos, lineales, del estilo de Phosphor Icons o Heroicons en variante outline/regular.

</specifics>

<deferred>
## Deferred Ideas

- Animación de número/cifras (counter animation en stats) — considerado para sección Experiencia pero se defiere a Fase 4 cuando haya datos reales
- Video background en hero — mencionado como posibilidad; se defiere hasta que el cliente provea asset de video
- Versión dark/light mode toggle — fuera de scope, consultora con identidad fija no necesita esto en v1
- CTAs individuales por servicio ("Consultar por este servicio") — se incluyeron en REQUIREMENTS pero se decidió NO incluirlos en las cards de Fase 1; se pueden añadir en Fase 4 cuando se conecte a WP

</deferred>

---

*Phase: 01-design-system-static-shell*
*Context gathered: 2026-03-16*

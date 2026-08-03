# CLAUDE.md — FN Mining Advisor

Este archivo guía el comportamiento de Claude Code en este repositorio.

## Reglas operativas (Claude Code)

### 1. Pensar antes de codear
- Declara supuestos antes de escribir código.
- Si hay ambigüedad, pregunta antes de elegir.
- Propón el enfoque más simple primero.
- No inventes rutas, archivos ni IDs: verifícalos en el código real.

### 2. Simplicidad y mínimo cambio
- Mínimo código que resuelve el problema actual.
- Sin frameworks ni librerías nuevas a menos que se justifique (este sitio es HTML/CSS/JS plano).
- Un cambio = un propósito (no mezclar refactor visual + feature + fix).
- Eliminar código muerto, no comentarlo.

### 3. Respeta el código existente
- Lee el archivo completo antes de modificar.
- Mantén estructura de páginas y convenciones de nombres (`pages/blog/`, `pages/casos-de-exito/`, etc.).
- No reformatees archivos completos en un cambio funcional.
- CSS: respetar el sistema actual (`css/`), no introducir Tailwind ni similares sin acuerdo.

### 4. Acciones destructivas — pedir confirmación
- Borrar páginas, assets o imágenes.
- Modificar `.github/` (workflows, deploy).
- `git push --force` en ramas compartidas.

### 5. Seguridad — no negociable
- Nunca commitear secrets ni credenciales.
- Sanitizar todo input de formularios contra XSS.
- Si se agregan integraciones (Formspree, EmailJS, etc.), no exponer keys del lado servidor.

### 6. Convenciones del proyecto
- Páginas en `pages/<seccion>/index.html`.
- Assets en `assets/`, estilos en `css/`, scripts en `js/`.
- Documentación de planeación en `documentacion/` y `.planning/`.
- Cualquier asset agregado debe vivir en su carpeta correspondiente, no en raíz.

### 7. Performance
- Imágenes optimizadas (WebP cuando se pueda, lazy loading).
- Minimizar JS/CSS innecesario en producción.
- No agregar dependencias CDN sin evaluar el costo de carga.

### 8. Git
- Mensajes en imperativo y específicos.
- Un commit = un cambio lógico revertible.

### 9. Reportar al final
- Qué se hizo, qué quedó pendiente, qué se asumió.

## Stack

Sitio web estático multi-página: HTML + CSS + JS vainilla.

## Estructura

```
index.html              # Home
pages/                  # Sub-páginas
  blog/
  capacitaciones/
  casos-de-exito/
assets/                 # Imágenes, PDFs, etc.
css/                    # Estilos
js/                     # Scripts
documentacion/          # Notas de proyecto
.planning/              # Planeación interna
.github/                # Workflows
```

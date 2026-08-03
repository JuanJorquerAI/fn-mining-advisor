<?php
require_once __DIR__ . '/config.php';
require_login();

$msg = '';
$msg_type = 'success';
$active_tab = $_POST['active_tab'] ?? 'tab-hero';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $msg = 'Error de seguridad (CSRF inválido). Intente nuevamente.';
        $msg_type = 'error';
    } else {
        $action = $_POST['action'] ?? 'save_content';

        if ($action === 'change_auth') {
            $active_tab = 'tab-security';
            $new_user = trim($_POST['new_username'] ?? '');
            $new_pass = trim($_POST['new_password'] ?? '');
            $confirm_pass = trim($_POST['confirm_password'] ?? '');

            if (!empty($new_pass) && $new_pass !== $confirm_pass) {
                $msg = 'Las contraseñas ingresadas no coinciden.';
                $msg_type = 'error';
            } else {
                updateUsernameAndPassword($new_user, $new_pass);
                if (!empty($new_user)) {
                    $_SESSION['admin_user'] = $new_user;
                }
                $msg = 'Credenciales de acceso actualizadas correctamente.';
                $msg_type = 'success';
            }
        } else {
            // Save Content
            $content = getAllContent();

            // Hero
            if (isset($_POST['hero'])) {
                foreach ($_POST['hero'] as $k => $v) {
                    $content['hero'][$k] = trim($v);
                }
            }

            // Valor
            if (isset($_POST['valor'])) {
                foreach ($_POST['valor'] as $k => $v) {
                    $content['valor'][$k] = trim($v);
                }
            }

            // Servicios
            if (isset($_POST['servicios'])) {
                foreach ($_POST['servicios'] as $sKey => $sVal) {
                    if (is_array($sVal)) {
                        foreach ($sVal as $k => $v) {
                            $content['servicios'][$sKey][$k] = trim($v);
                        }
                    } else {
                        $content['servicios'][$sKey] = trim($sVal);
                    }
                }
            }

            // Innovacion
            if (isset($_POST['innovacion'])) {
                foreach ($_POST['innovacion'] as $iKey => $iVal) {
                    if (is_array($iVal)) {
                        foreach ($iVal as $k => $v) {
                            $content['innovacion'][$iKey][$k] = trim($v);
                        }
                    } else {
                        $content['innovacion'][$iKey] = trim($iVal);
                    }
                }
            }

            // Metodologia
            if (isset($_POST['metodologia'])) {
                foreach ($_POST['metodologia'] as $mKey => $mVal) {
                    if (is_array($mVal)) {
                        foreach ($mVal as $k => $v) {
                            $content['metodologia'][$mKey][$k] = trim($v);
                        }
                    } else {
                        $content['metodologia'][$mKey] = trim($mVal);
                    }
                }
            }

            // Experiencia
            if (isset($_POST['experiencia'])) {
                foreach ($_POST['experiencia'] as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $subK => $subV) {
                            $content['experiencia'][$k][$subK] = trim($subV);
                        }
                    } else {
                        $content['experiencia'][$k] = trim($v);
                    }
                }
            }

            // Cifras
            if (isset($_POST['cifras'])) {
                foreach ($_POST['cifras'] as $k => $v) {
                    $content['cifras'][$k] = trim($v);
                }
            }

            // CTA Final
            if (isset($_POST['cta_final'])) {
                foreach ($_POST['cta_final'] as $k => $v) {
                    $content['cta_final'][$k] = trim($v);
                }
            }

            // Contacto
            if (isset($_POST['contacto'])) {
                foreach ($_POST['contacto'] as $k => $v) {
                    $content['contacto'][$k] = trim($v);
                }
            }

            if (saveAllContent($content)) {
                $msg = '¡Todos los cambios han sido guardados con éxito!';
                $msg_type = 'success';
            } else {
                $msg = 'Ocurrió un error al intentar guardar el archivo de datos.';
                $msg_type = 'error';
            }
        }
    }
}

$c = getAllContent();
$auth = getAuthData();
$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editor de Contenido — FN Mining Advisor</title>
  <link rel="stylesheet" href="css/admin.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Top Navigation Bar -->
  <header class="admin-topbar">
    <div class="admin-topbar__brand">
      <img src="../assets/logo-nmc.png" alt="FN Mining Advisor" class="admin-topbar__logo" />
      <span class="admin-topbar__title">Editor de Landing</span>
    </div>
    <div class="admin-topbar__actions">
      <a href="../index.php" target="_blank" class="btn-admin btn-admin--outline btn-admin--sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
        Ver Sitio Web
      </a>
      <a href="logout.php" class="btn-admin btn-admin--outline btn-admin--sm">Cerrar Sesión</a>
    </div>
  </header>

  <div class="admin-container">
    
    <?php if (!empty($msg)): ?>
      <div class="admin-alert admin-alert--<?php echo $msg_type; ?>">
        <?php if ($msg_type === 'success'): ?>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <?php else: ?>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <?php endif; ?>
        <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <!-- Tabs Navigation -->
    <div class="admin-tabs">
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-hero' ? 'active' : ''; ?>" data-target="tab-hero">🎯 Hero Principal</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-valor' ? 'active' : ''; ?>" data-target="tab-valor">💡 Propuesta de Valor</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-servicios' ? 'active' : ''; ?>" data-target="tab-servicios">🛠️ Servicios</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-innovacion' ? 'active' : ''; ?>" data-target="tab-innovacion">🔬 Innovación</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-metodologia' ? 'active' : ''; ?>" data-target="tab-metodologia">📋 Metodología</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-experiencia' ? 'active' : ''; ?>" data-target="tab-experiencia">👤 Trayectoria</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-contacto' ? 'active' : ''; ?>" data-target="tab-contacto">📞 Contacto</button>
      <button type="button" class="admin-tab <?php echo $active_tab === 'tab-security' ? 'active' : ''; ?>" data-target="tab-security">🔑 Seguridad</button>
    </div>

    <!-- Main Content Form -->
    <form method="POST" action="dashboard.php" id="admin-form">
      <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
      <input type="hidden" name="active_tab" id="active_tab_field" value="<?php echo htmlspecialchars($active_tab, ENT_QUOTES, 'UTF-8'); ?>" />
      <input type="hidden" name="action" value="save_content" />

      <!-- TAB 1: HERO -->
      <div class="admin-panel <?php echo $active_tab === 'tab-hero' ? 'active' : ''; ?>" id="tab-hero">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>🎯</span> Encabezado Hero</h2>
          <div class="form-group">
            <label class="form-label">Título Principal</label>
            <input type="text" name="hero[heading]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Texto Botón Principal (CTA)</label>
              <input type="text" name="hero[cta_primary]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['cta_primary'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Texto Botón Secundario</label>
              <input type="text" name="hero[cta_secondary]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['cta_secondary'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        </div>

        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>❓</span> Puntos de Dolor (Problemas que resolvemos)</h2>
          <div class="form-group">
            <label class="form-label">Pregunta 1</label>
            <input type="text" name="hero[pain_point_1_title]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['pain_point_1_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Detalle Pregunta 1</label>
            <input type="text" name="hero[pain_point_1_sub]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['pain_point_1_sub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Pregunta 2</label>
            <input type="text" name="hero[pain_point_2_title]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['pain_point_2_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Pregunta 3</label>
            <input type="text" name="hero[pain_point_3_title]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['pain_point_3_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Detalle Pregunta 3</label>
            <input type="text" name="hero[pain_point_3_sub]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['pain_point_3_sub'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
        </div>

        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>🏆</span> Distintivo de Trayectoria</h2>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Texto Trayectoria</label>
              <input type="text" name="hero[trayectoria_text]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['trayectoria_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Badge Destacado</label>
              <input type="text" name="hero[trayectoria_badge]" class="form-control" value="<?php echo htmlspecialchars($c['hero']['trayectoria_badge'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 2: PROPUESTA DE VALOR -->
      <div class="admin-panel <?php echo $active_tab === 'tab-valor' ? 'active' : ''; ?>" id="tab-valor">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>💡</span> Encabezado de la Sección</h2>
          <div class="form-group">
            <label class="form-label">Título</label>
            <input type="text" name="valor[heading]" class="form-control" value="<?php echo htmlspecialchars($c['valor']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Bajada de Texto</label>
            <textarea name="valor[subheading]" class="form-control"><?php echo htmlspecialchars($c['valor']['subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <?php for($i=1; $i<=4; $i++): ?>
          <div class="admin-section-card">
            <h2 class="admin-section-title"><span>📌</span> Pilar <?php echo $i; ?></h2>
            <div class="form-group">
              <label class="form-label">Título del Pilar</label>
              <input type="text" name="valor[pilar_<?php echo $i; ?>_title]" class="form-control" value="<?php echo htmlspecialchars($c['valor']["pilar_{$i}_title"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Descripción</label>
              <textarea name="valor[pilar_<?php echo $i; ?>_desc]" class="form-control"><?php echo htmlspecialchars($c['valor']["pilar_{$i}_desc"] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- TAB 3: SERVICIOS -->
      <div class="admin-panel <?php echo $active_tab === 'tab-servicios' ? 'active' : ''; ?>" id="tab-servicios">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>🛠️</span> Encabezado de Servicios</h2>
          <div class="form-group">
            <label class="form-label">Título General</label>
            <input type="text" name="servicios[heading]" class="form-control" value="<?php echo htmlspecialchars($c['servicios']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Bajada de Texto</label>
            <textarea name="servicios[subheading]" class="form-control"><?php echo htmlspecialchars($c['servicios']['subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <?php for($s=1; $s<=4; $s++): $sData = $c['servicios']["servicio_{$s}"] ?? []; ?>
          <div class="admin-section-card">
            <h2 class="admin-section-title"><span>📦</span> Servicio <?php echo $s; ?></h2>
            <div class="form-group">
              <label class="form-label">Nombre del Servicio</label>
              <input type="text" name="servicios[servicio_<?php echo $s; ?>][title]" class="form-control" value="<?php echo htmlspecialchars($sData['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <?php if(isset($sData['tagline'])): ?>
              <div class="form-group">
                <label class="form-label">Subtítulo / Tagline</label>
                <input type="text" name="servicios[servicio_<?php echo $s; ?>][tagline]" class="form-control" value="<?php echo htmlspecialchars($sData['tagline'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
              </div>
            <?php endif; ?>
            <div class="form-group">
              <label class="form-label">Descripción</label>
              <textarea name="servicios[servicio_<?php echo $s; ?>][desc]" class="form-control"><?php echo htmlspecialchars($sData['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div class="form-group">
              <label class="form-label">Áreas de Foco (Puntos Clave)</label>
              <input type="text" name="servicios[servicio_<?php echo $s; ?>][foco]" class="form-control" value="<?php echo htmlspecialchars($sData['foco'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- TAB 4: INNOVACION -->
      <div class="admin-panel <?php echo $active_tab === 'tab-innovacion' ? 'active' : ''; ?>" id="tab-innovacion">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>🔬</span> Innovación y Sustentabilidad</h2>
          <div class="form-group">
            <label class="form-label">Título</label>
            <input type="text" name="innovacion[heading]" class="form-control" value="<?php echo htmlspecialchars($c['innovacion']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Bajada de Texto</label>
            <textarea name="innovacion[subheading]" class="form-control"><?php echo htmlspecialchars($c['innovacion']['subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <?php for($i=1; $i<=4; $i++): $iData = $c['innovacion']["item_{$i}"] ?? []; ?>
          <div class="admin-section-card">
            <h2 class="admin-section-title"><span>🌱</span> Bloque de Innovación <?php echo $i; ?></h2>
            <div class="form-group">
              <label class="form-label">Título</label>
              <input type="text" name="innovacion[item_<?php echo $i; ?>][title]" class="form-control" value="<?php echo htmlspecialchars($iData['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Descripción</label>
              <textarea name="innovacion[item_<?php echo $i; ?>][desc]" class="form-control"><?php echo htmlspecialchars($iData['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- TAB 5: METODOLOGIA -->
      <div class="admin-panel <?php echo $active_tab === 'tab-metodologia' ? 'active' : ''; ?>" id="tab-metodologia">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>📋</span> Encabezado Metodología</h2>
          <div class="form-group">
            <label class="form-label">Título</label>
            <input type="text" name="metodologia[heading]" class="form-control" value="<?php echo htmlspecialchars($c['metodologia']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Bajada de Texto</label>
            <textarea name="metodologia[subheading]" class="form-control"><?php echo htmlspecialchars($c['metodologia']['subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <?php for($p=1; $p<=5; $p++): $pData = $c['metodologia']["paso_{$p}"] ?? []; ?>
          <div class="admin-section-card">
            <h2 class="admin-section-title"><span>0<?php echo $p; ?></span> Paso <?php echo $p; ?></h2>
            <div class="form-group">
              <label class="form-label">Título del Paso</label>
              <input type="text" name="metodologia[paso_<?php echo $p; ?>][title]" class="form-control" value="<?php echo htmlspecialchars($pData['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Descripción</label>
              <textarea name="metodologia[paso_<?php echo $p; ?>][desc]" class="form-control"><?php echo htmlspecialchars($pData['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
          </div>
        <?php endfor; ?>
      </div>

      <!-- TAB 6: EXPERIENCIA Y CIFRAS -->
      <div class="admin-panel <?php echo $active_tab === 'tab-experiencia' ? 'active' : ''; ?>" id="tab-experiencia">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>👤</span> Biografía del Consultor</h2>
          <div class="form-group">
            <label class="form-label">Título Sección</label>
            <input type="text" name="experiencia[heading]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Párrafo Destacado (Lead)</label>
            <textarea name="experiencia[lead]" class="form-control"><?php echo htmlspecialchars($c['experiencia']['lead'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Párrafo 1 de Biografía</label>
            <textarea name="experiencia[bio_para_1]" class="form-control"><?php echo htmlspecialchars($c['experiencia']['bio_para_1'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Párrafo 2 de Biografía</label>
            <textarea name="experiencia[bio_para_2]" class="form-control"><?php echo htmlspecialchars($c['experiencia']['bio_para_2'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>🏅</span> Tarjeta Persona Competente</h2>
          <div class="form-group">
            <label class="form-label">Certificación / Distintivo</label>
            <input type="text" name="experiencia[persona_competente][badge]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['badge'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Título Certificación</label>
            <input type="text" name="experiencia[persona_competente][title]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Subtítulo Institución</label>
            <input type="text" name="experiencia[persona_competente][subtitle]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">N° Registro</label>
              <input type="text" name="experiencia[persona_competente][registro]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['registro'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Profesión</label>
              <input type="text" name="experiencia[persona_competente][profesion]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['profesion'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Especialidad</label>
            <input type="text" name="experiencia[persona_competente][especialidad]" class="form-control" value="<?php echo htmlspecialchars($c['experiencia']['persona_competente']['especialidad'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Explicación del Registro</label>
            <textarea name="experiencia[persona_competente][desc]" class="form-control"><?php echo htmlspecialchars($c['experiencia']['persona_competente']['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
        </div>

        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>📊</span> Cifras Clave (Métricas)</h2>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Cifra 1 (Valor)</label>
              <input type="text" name="cifras[item_1_val]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_1_val'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Cifra 1 (Etiqueta)</label>
              <input type="text" name="cifras[item_1_label]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_1_label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Cifra 2 (Valor)</label>
              <input type="text" name="cifras[item_2_val]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_2_val'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Cifra 2 (Etiqueta)</label>
              <input type="text" name="cifras[item_2_label]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_2_label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Cifra 3 (Valor)</label>
              <input type="text" name="cifras[item_3_val]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_3_val'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Cifra 3 (Etiqueta)</label>
              <input type="text" name="cifras[item_3_label]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_3_label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Cifra 4 (Valor)</label>
              <input type="text" name="cifras[item_4_val]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_4_val'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Cifra 4 (Etiqueta)</label>
              <input type="text" name="cifras[item_4_label]" class="form-control" value="<?php echo htmlspecialchars($c['cifras']['item_4_label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        </div>
      </div>

      <!-- TAB 7: CONTACTO -->
      <div class="admin-panel <?php echo $active_tab === 'tab-contacto' ? 'active' : ''; ?>" id="tab-contacto">
        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>📣</span> Llamado a la Acción Final (CTA)</h2>
          <div class="form-group">
            <label class="form-label">Título CTA</label>
            <input type="text" name="cta_final[heading]" class="form-control" value="<?php echo htmlspecialchars($c['cta_final']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="cta_final[desc]" class="form-control"><?php echo htmlspecialchars($c['cta_final']['desc'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Texto Botón Diagnóstico</label>
              <input type="text" name="cta_final[button_primary]" class="form-control" value="<?php echo htmlspecialchars($c['cta_final']['button_primary'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Texto Botón WhatsApp</label>
              <input type="text" name="cta_final[button_whatsapp]" class="form-control" value="<?php echo htmlspecialchars($c['cta_final']['button_whatsapp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        </div>

        <div class="admin-section-card">
          <h2 class="admin-section-title"><span>📞</span> Información Directa de Contacto</h2>
          <div class="form-group">
            <label class="form-label">Título Sección Contacto</label>
            <input type="text" name="contacto[heading]" class="form-control" value="<?php echo htmlspecialchars($c['contacto']['heading'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
          </div>
          <div class="form-group">
            <label class="form-label">Bajada de Texto</label>
            <textarea name="contacto[subheading]" class="form-control"><?php echo htmlspecialchars($c['contacto']['subheading'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" name="contacto[email]" class="form-control" value="<?php echo htmlspecialchars($c['contacto']['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">Teléfono Visible</label>
              <input type="text" name="contacto[telefono]" class="form-control" value="<?php echo htmlspecialchars($c['contacto']['telefono'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Número WhatsApp (sin espacios ni +, ej: 56982931859)</label>
              <input type="text" name="contacto[whatsapp]" class="form-control" value="<?php echo htmlspecialchars($c['contacto']['whatsapp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
            <div class="form-group">
              <label class="form-label">URL Perfil LinkedIn</label>
              <input type="text" name="contacto[linkedin]" class="form-control" value="<?php echo htmlspecialchars($c['contacto']['linkedin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
            </div>
          </div>
        </div>
      </div>

      <!-- Sticky Save Bar -->
      <div class="admin-sticky-save">
        <span class="admin-sticky-save__info">Modifique los textos requeridos y presione guardar para actualizar la landing instantáneamente.</span>
        <button type="submit" class="btn-admin">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
          Guardar Cambios
        </button>
      </div>

    </form>

    <!-- TAB 8: SEGURIDAD -->
    <div class="admin-panel <?php echo $active_tab === 'tab-security' ? 'active' : ''; ?>" id="tab-security">
      <div class="admin-section-card" style="max-width: 540px; margin: 0 auto;">
        <h2 class="admin-section-title"><span>🔑</span> Cambiar Usuario y Contraseña</h2>
        <p style="font-size: 13px; color: var(--admin-text-muted); margin-bottom: 20px;">
          Puede modificar el usuario o la contraseña de acceso al editor en cualquier momento.
        </p>

        <form method="POST" action="dashboard.php">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
          <input type="hidden" name="active_tab" value="tab-security" />
          <input type="hidden" name="action" value="change_auth" />

          <div class="form-group">
            <label class="form-label">Usuario Actual</label>
            <input type="text" name="new_username" class="form-control" value="<?php echo htmlspecialchars($auth['username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?>" required />
          </div>

          <div class="form-group">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" name="new_password" class="form-control" placeholder="Dejar en blanco para no cambiar" />
          </div>

          <div class="form-group">
            <label class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Dejar en blanco para no cambiar" />
          </div>

          <button type="submit" class="btn-admin" style="margin-top: 12px; width: 100%;">
            Actualizar Credenciales
          </button>
        </form>
      </div>
    </div>

  </div>

  <script>
    // Tab switching logic
    document.querySelectorAll('.admin-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.admin-panel').forEach(p => p.classList.remove('active'));
        
        tab.classList.add('active');
        const targetId = tab.getAttribute('data-target');
        document.getElementById(targetId).classList.add('active');
        document.getElementById('active_tab_field').value = targetId;
      });
    });
  </script>

</body>
</html>

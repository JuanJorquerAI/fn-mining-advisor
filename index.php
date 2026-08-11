<?php
require_once __DIR__ . '/data/content_helper.php';
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?php e('hero.subheading', 'Consultoría especializada en valorización de propiedades, optimización metalúrgica y gestión de proyectos mineros en Chile y Latinoamérica.'); ?>"
    />

    <title>
      FN Mining Advisor — Consultoría Técnica Senior en Minería y Metalurgia
    </title>

    <!-- Design tokens load first — all other CSS depends on these variables -->
    <link rel="stylesheet" href="css/tokens.css?v=1.2.1" />
    <link rel="stylesheet" href="css/base.css?v=1.2.1" />
    <link rel="stylesheet" href="css/layout.css?v=1.2.1" />
    <link rel="stylesheet" href="css/utilities.css?v=1.2.1" />

    <!-- Section CSS -->
    <link rel="stylesheet" href="css/sections/hero.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/valor.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/servicios.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/innovacion.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/metodologia.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/experiencia.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/insights.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/cta-final.css?v=1.2.1" />
    <link rel="stylesheet" href="css/sections/contacto.css?v=1.2.1" />
    <link rel="stylesheet" href="css/header.css?v=1.2.1" />
    <link rel="stylesheet" href="css/footer.css?v=1.2.2" />
  </head>
  <body>
    <!-- ============================================================
       HEADER — sticky, transparent over hero, solid on scroll
       ============================================================ -->
    <header class="site-header" id="site-header" role="banner">
      <div class="container site-header__inner">
        <a href="/" class="site-logo" aria-label="FN Mining Advisor — Inicio">
          <img
            src="assets/logo-nmc.png"
            alt="Nuñez Mining Consulting"
            class="site-logo__img"
          />
        </a>

        <!-- Desktop navigation -->
        <nav
          class="site-nav"
          role="navigation"
          aria-label="Navegación principal"
        >
          <ul class="site-nav__list" role="list">
            <li><a href="#servicios" class="site-nav__link">Servicios</a></li>
            <li>
              <a href="#metodologia" class="site-nav__link">Metodología</a>
            </li>
            <li>
              <a href="#experiencia" class="site-nav__link">Trayectoria</a>
            </li>
            <li><a href="#contacto" class="site-nav__link">Contacto</a></li>
          </ul>
          <a href="#contacto" class="btn btn--ghost site-nav__cta"
            ><?php e('hero.cta_primary', 'Solicitar diagnóstico'); ?></a
          >
        </nav>

        <!-- Mobile hamburger button -->
        <button
          class="site-nav__hamburger"
          id="nav-toggle"
          aria-label="Abrir menú"
          aria-expanded="false"
          aria-controls="mobile-nav"
        >
          <span class="site-nav__hamburger-bar"></span>
          <span class="site-nav__hamburger-bar"></span>
          <span class="site-nav__hamburger-bar"></span>
        </button>
      </div>
    </header>

    <!-- Mobile nav overlay -->
    <div
      class="mobile-nav"
      id="mobile-nav"
      aria-hidden="true"
      role="dialog"
      aria-label="Menú de navegación"
    >
      <button class="mobile-nav__close" id="nav-close" aria-label="Cerrar menú">
        &#10005;
      </button>
      <nav aria-label="Navegación móvil">
        <ul class="mobile-nav__list" role="list">
          <li><a href="#servicios" class="mobile-nav__link">Servicios</a></li>
          <li>
            <a href="#metodologia" class="mobile-nav__link">Metodología</a>
          </li>
          <li>
            <a href="#experiencia" class="mobile-nav__link">Trayectoria</a>
          </li>
          <li><a href="#contacto" class="mobile-nav__link">Contacto</a></li>
        </ul>
        <a href="#contacto" class="btn btn--primary mobile-nav__cta"
          ><?php e('hero.cta_primary', 'Solicitar diagnóstico'); ?></a
        >
      </nav>
    </div>

    <main id="main-content">
      <!-- ============================================================
         SECTION 1: HERO
         ============================================================ -->
      <section
        id="hero"
        class="hero section--dark"
        aria-labelledby="hero-heading"
        style="background-image: url('assets/images/hero-bg.jpg')"
      >
        <div class="container hero__container">
          <div class="hero__content fade-in">
            <h1 class="hero__heading" id="hero-heading">
              <?php e('hero.heading'); ?>
            </h1>
            <ul class="hero__pain-points" aria-label="Problemas que resolvemos">
              <li>
                <strong><?php e('hero.pain_point_1_title'); ?></strong>
                <?php if (getContent('hero.pain_point_1_sub')): ?>
                  <span class="hero__pain-sub"><?php e('hero.pain_point_1_sub'); ?></span>
                <?php endif; ?>
              </li>
              <li>
                <strong><?php e('hero.pain_point_2_title'); ?></strong>
              </li>
              <li>
                <strong><?php e('hero.pain_point_3_title'); ?></strong>
                <?php if (getContent('hero.pain_point_3_sub')): ?>
                  <span class="hero__pain-sub"><?php e('hero.pain_point_3_sub'); ?></span>
                <?php endif; ?>
              </li>
            </ul>
            <div class="hero__ctas">
              <a href="#contacto" class="btn btn--primary"
                ><?php e('hero.cta_primary', 'Solicitar diagnóstico'); ?></a
              >
              <a href="#servicios" class="btn btn--ghost"><?php e('hero.cta_secondary', 'Ver servicios'); ?></a>
            </div>
            <p class="hero__trayectoria">
              <span class="hero__trayectoria-line" aria-hidden="true"></span>
              <?php e('hero.trayectoria_text'); ?>
              <span class="hero__badge-qp"><?php e('hero.trayectoria_badge'); ?></span>
            </p>
          </div>
        </div>
        <!-- Scroll indicator -->
        <div class="hero__scroll-indicator" aria-hidden="true">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </div>
      </section>

      <!-- ============================================================
         SECTION 2: PROPUESTA DE VALOR
         ============================================================ -->
      <section id="valor" class="valor-section" aria-labelledby="valor-heading">
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="valor-heading"><?php e('valor.heading'); ?></h2>
            <p><?php e('valor.subheading'); ?></p>
          </header>

          <div class="valor-section__grid grid-2 fade-in">
            <article class="trust-pillar" aria-labelledby="pilar-1-title">
              <div class="trust-pillar__icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M128,152a76,76,0,1,0-76-76A76.08,76.08,0,0,0,128,152Zm0-136a60,60,0,1,1-60,60A60.07,60.07,0,0,1,128,16Zm97.19,161.46a8,8,0,0,1-2.53,11A103.11,103.11,0,0,1,176,203.72V240a8,8,0,0,1-4.42,7.16,8.2,8.2,0,0,1-3.58.84,8,8,0,0,1-4.79-1.58L128,220.43l-35.21,26a8,8,0,0,1-12.79-6.41V203.72a103.11,103.11,0,0,1-46.66-15.28,8,8,0,1,1,8.44-13.56A88,88,0,0,0,160,192a88.91,88.91,0,0,0,12-1.6A88,88,0,0,0,215.85,176a8,8,0,0,1,9.34,3.46ZM96,231.57,128,208l32,23.57V212.64a103.25,103.25,0,0,1-64,0Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="pilar-1-title"><?php e('valor.pilar_1_title'); ?></h3>
              <p><?php e('valor.pilar_1_desc'); ?></p>
            </article>

            <article class="trust-pillar" aria-labelledby="pilar-2-title">
              <div class="trust-pillar__icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M229.66,218.34l-50.07-50.07a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.31ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="pilar-2-title"><?php e('valor.pilar_2_title'); ?></h3>
              <p><?php e('valor.pilar_2_desc'); ?></p>
            </article>

            <article class="trust-pillar" aria-labelledby="pilar-3-title">
              <div class="trust-pillar__icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M208,40H48A16,16,0,0,0,32,56V120c0,88,88,120,88,120s88-32,88-120V56A16,16,0,0,0,208,40Zm0,80c0,65.74-67.51,96-80,101.16C115.51,216,48,185.74,48,120V56H208ZM82.34,130.34,104,108.69V160a8,8,0,0,0,16,0V108.69l21.66,21.65a8,8,0,0,0,11.31-11.31l-32-32a8,8,0,0,0-11.32,0l-32,32a8,8,0,0,0,11.32,11.31Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="pilar-3-title"><?php e('valor.pilar_3_title'); ?></h3>
              <p><?php e('valor.pilar_3_desc'); ?></p>
            </article>

            <article class="trust-pillar" aria-labelledby="pilar-4-title">
              <div class="trust-pillar__icon" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M232,48a8,8,0,0,0-8-8c-82.43,0-144,61.57-144,144v16a8,8,0,0,0,16,0V184A167.9,167.9,0,0,1,224,56,8,8,0,0,0,232,48ZM56,192c0-57.14,28.52-104.15,78.8-133.4A175.08,175.08,0,0,0,96,184v16a8,8,0,0,1-16,0V200H64a8,8,0,0,1-8-8Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="pilar-4-title"><?php e('valor.pilar_4_title'); ?></h3>
              <p><?php e('valor.pilar_4_desc'); ?></p>
            </article>
          </div>
        </div>
      </section>

      <!-- ============================================================
         SECTION 3: SERVICIOS
         ============================================================ -->
      <section
        id="servicios"
        class="servicios-section"
        aria-labelledby="servicios-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="servicios-heading"><?php e('servicios.heading'); ?></h2>
            <p><?php e('servicios.subheading'); ?></p>
          </header>

          <div class="servicios-section__grid fade-in">
            <!-- Card 1 -->
            <article class="service-card" aria-labelledby="servicio-1-title">
              <div class="service-card__icon" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M234.29,213.39,162.57,80.17a40,40,0,0,0-69.14,0L21.71,213.39A16,16,0,0,0,35.64,237.5H220.36A16,16,0,0,0,234.29,213.39ZM128,96l18.39,32H109.61Zm-88,125.5L80,144.24l33.42,58.07a8,8,0,0,0,13.86-8L110.85,168h34.3l-16.43,26.32a8,8,0,0,0,13.86,8L176,144.24l40,77.26Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="servicio-1-title"><?php e('servicios.servicio_1.title'); ?></h3>
              <?php if (getContent('servicios.servicio_1.tagline')): ?>
                <p class="service-card__tagline"><?php e('servicios.servicio_1.tagline'); ?></p>
              <?php endif; ?>
              <p><?php e('servicios.servicio_1.desc'); ?></p>
              <p class="service-card__foco">
                <strong>Foco:</strong> <?php e('servicios.servicio_1.foco'); ?>
              </p>
            </article>

            <!-- Card 2 -->
            <article class="service-card" aria-labelledby="servicio-2-title">
              <div class="service-card__icon" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M237.94,107.21a8,8,0,0,0-3.89-5.4l-32.86-19-3.91-32.17a8,8,0,0,0-4.7-6.28L160,30.05a8,8,0,0,0-7.5.38L128,43.94l-24.5-13.51a8,8,0,0,0-7.5-.38L58.42,44.37a8,8,0,0,0-4.7,6.28l-3.91,32.17-32.86,19a8,8,0,0,0-3.89,5.4l-6.83,33.91a8,8,0,0,0,1.83,6.9l21.67,23.43-3.23,32.53a8,8,0,0,0,3.23,7.49l28.37,20.24a8,8,0,0,0,7.86.64l30.81-14.25L128,213.86l32.21,14.25a8,8,0,0,0,7.86-.64l28.37-20.24a8,8,0,0,0,3.23-7.49L196.44,167l21.67-23.43a8,8,0,0,0,1.83-6.9ZM128,168a40,40,0,1,1,40-40A40,40,0,0,1,128,168Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="servicio-2-title"><?php e('servicios.servicio_2.title'); ?></h3>
              <p><?php e('servicios.servicio_2.desc'); ?></p>
              <p class="service-card__foco">
                <strong>Foco:</strong> <?php e('servicios.servicio_2.foco'); ?>
              </p>
            </article>

            <!-- Card 3 -->
            <article class="service-card" aria-labelledby="servicio-3-title">
              <div class="service-card__icon" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M224,216H208V152a8,8,0,0,0-8-8H168V104a8,8,0,0,0-8-8H136V72h16a8,8,0,0,0,5.66-13.66l-40-40a8,8,0,0,0-11.32,0l-40,40A8,8,0,0,0,72,72H88V96H64a8,8,0,0,0-8,8v40H32a8,8,0,0,0-8,8v64H8a8,8,0,0,0,0,16H224a8,8,0,0,0,0-16ZM88,216H40V160H88Zm72,0H104V112H160Zm16-96h16v96H176Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="servicio-3-title"><?php e('servicios.servicio_3.title'); ?></h3>
              <p><?php e('servicios.servicio_3.desc'); ?></p>
              <p class="service-card__foco">
                <strong>Foco:</strong> <?php e('servicios.servicio_3.foco'); ?>
              </p>
            </article>

            <!-- Card 4 -->
            <article class="service-card" aria-labelledby="servicio-4-title">
              <div class="service-card__icon" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M251.76,88.94l-120-64a8,8,0,0,0-7.52,0l-120,64a8,8,0,0,0,0,14.12L32,117.87V176a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V117.87l16-8.81V208a8,8,0,0,0,16,0V96A8,8,0,0,0,251.76,88.94ZM208,168H48V127.47l72,39.59a8,8,0,0,0,7.52,0l80-44v45ZM128,151.06,32,98.94,128,46.94l96,52Z" fill="currentColor"/>
                </svg>
              </div>
              <h3 id="servicio-4-title"><?php e('servicios.servicio_4.title'); ?></h3>
              <p><?php e('servicios.servicio_4.desc'); ?></p>
              <p class="service-card__foco">
                <strong>Foco:</strong> <?php e('servicios.servicio_4.foco'); ?>
              </p>
            </article>
          </div>
        </div>
      </section>

      <!-- Image banner -->
      <div
        class="img-banner"
        role="presentation"
        aria-hidden="true"
        style="
          background-image: url('assets/images/tecnico-planta.png');
          background-position: center 30%;
        "
      ></div>

      <!-- ============================================================
         SECTION 4: INNOVACIÓN Y SUSTENTABILIDAD
         ============================================================ -->
      <section
        id="innovacion"
        class="innovacion-section section--dark"
        aria-labelledby="innovacion-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="innovacion-heading"><?php e('innovacion.heading'); ?></h2>
            <p><?php e('innovacion.subheading'); ?></p>
          </header>

          <div class="innovacion-section__grid grid-2 fade-in">
            <article class="innovacion-item" aria-labelledby="inn-1-title">
              <h3 id="inn-1-title"><?php e('innovacion.item_1.title'); ?></h3>
              <p><?php e('innovacion.item_1.desc'); ?></p>
            </article>

            <article class="innovacion-item" aria-labelledby="inn-2-title">
              <h3 id="inn-2-title"><?php e('innovacion.item_2.title'); ?></h3>
              <p><?php e('innovacion.item_2.desc'); ?></p>
            </article>

            <article class="innovacion-item" aria-labelledby="inn-3-title">
              <h3 id="inn-3-title"><?php e('innovacion.item_3.title'); ?></h3>
              <p><?php e('innovacion.item_3.desc'); ?></p>
            </article>

            <article class="innovacion-item" aria-labelledby="inn-4-title">
              <h3 id="inn-4-title"><?php e('innovacion.item_4.title'); ?></h3>
              <p><?php e('innovacion.item_4.desc'); ?></p>
            </article>
          </div>
        </div>
      </section>

      <!-- ============================================================
         SECTION 5: METODOLOGÍA
         ============================================================ -->
      <section
        id="metodologia"
        class="metodologia-section section--dark"
        aria-labelledby="metodologia-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="metodologia-heading"><?php e('metodologia.heading'); ?></h2>
            <p><?php e('metodologia.subheading'); ?></p>
          </header>

          <ol
            class="metodologia-section__steps fade-in"
            aria-label="Pasos de la metodología"
          >
            <?php for($p=1; $p<=5; $p++): ?>
              <li class="methodology-step" aria-labelledby="paso-<?php echo $p; ?>-title">
                <div class="methodology-step__number" aria-hidden="true">0<?php echo $p; ?></div>
                <div class="methodology-step__content">
                  <h3 id="paso-<?php echo $p; ?>-title"><?php e("metodologia.paso_{$p}.title"); ?></h3>
                  <p><?php e("metodologia.paso_{$p}.desc"); ?></p>
                </div>
              </li>
            <?php endfor; ?>
          </ol>
        </div>
      </section>

      <!-- ============================================================
         SECTION 6: EXPERIENCIA PROFESIONAL
         ============================================================ -->
      <section
        id="experiencia"
        class="experiencia-section"
        aria-labelledby="experiencia-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="experiencia-heading"><?php e('experiencia.heading', 'Trayectoria'); ?></h2>
          </header>

          <div class="experiencia-section__content fade-in">
            <div class="experiencia-section__profile">
              <img
                src="assets/images/felipe-nunez-perfil.jpeg"
                alt="Armando Felipe Núñez Cordero — Consultor Senior en Proyectos de Minería de Oro"
                class="experiencia-section__portrait"
                loading="lazy"
              />
            </div>

            <div class="experiencia-section__editorial">
              <p class="experiencia-section__lead">
                <?php e('experiencia.lead'); ?>
              </p>
              <p><?php e('experiencia.bio_para_1'); ?></p>
              <p><?php e('experiencia.bio_para_2'); ?></p>

              <!-- Persona Competente Card -->
              <div
                class="persona-competente-card"
                aria-label="Habilitación Persona Competente Comisión Minera"
              >
                <div class="persona-competente-card__header">
                  <div class="persona-competente-card__badge">
                    <svg width="18" height="18" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L111,147.34l50.34-50.34a8,8,0,0,1,11.32,11.32Z" fill="currentColor"/>
                    </svg>
                    <?php e('experiencia.persona_competente.badge'); ?>
                  </div>
                  <h3 class="persona-competente-card__title">
                    <?php e('experiencia.persona_competente.title'); ?>
                  </h3>
                  <p class="persona-competente-card__subtitle">
                    <?php e('experiencia.persona_competente.subtitle'); ?>
                  </p>
                </div>

                <div class="persona-competente-card__details">
                  <div class="persona-competente-card__detail-item">
                    <span class="persona-competente-card__detail-label">Registro</span>
                    <span class="persona-competente-card__detail-val"><?php e('experiencia.persona_competente.registro'); ?></span>
                  </div>
                  <div class="persona-competente-card__detail-item">
                    <span class="persona-competente-card__detail-label">Profesión</span>
                    <span class="persona-competente-card__detail-val"><?php e('experiencia.persona_competente.profesion'); ?></span>
                  </div>
                  <div class="persona-competente-card__detail-item">
                    <span class="persona-competente-card__detail-label">Especialidad</span>
                    <span class="persona-competente-card__detail-val"><?php e('experiencia.persona_competente.especialidad'); ?></span>
                  </div>
                </div>

                <p class="persona-competente-card__desc">
                  <?php e('experiencia.persona_competente.desc'); ?>
                </p>

                <a
                  href="https://www.comisionminera.cl/busca-personas-competentes/"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="persona-competente-card__link"
                >
                  Verificar registro público en Comisión Minera
                  <svg width="16" height="16" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M200,64V168a8,8,0,0,1-16,0V83.31L69.66,197.66a8,8,0,0,1-11.32-11.32L172.69,72H88a8,8,0,0,1,0-16H192A8,8,0,0,1,200,64Z" fill="currentColor"/>
                  </svg>
                </a>
              </div>
            </div>

            <!-- CV Proyectos -->
            <div
              class="experiencia-section__cv fade-in"
              id="cv"
              aria-label="Perfil profesional estructurado"
            >
              <h3 class="cv__section-title">Proyectos de referencia</h3>
              <div class="cv__projects" role="list">
                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Salares Norte — Gold Fields</span>
                    <span class="cv__project-meta">Chile · Gerente de Planta</span>
                  </div>
                  <p class="cv__project-desc">
                    Comisionamiento, puesta en marcha y primer oro de planta — circuitos de chancado, molienda, Merrill-Crowe, destoxificación y refinación.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">El Peñón — Yamana Gold</span>
                    <span class="cv__project-meta">Chile · Gerente de Planta · ~4–5 Moz Au</span>
                  </div>
                  <p class="cv__project-desc">
                    Gestión de operaciones metalúrgicas y expansión de planta, incrementando la capacidad de procesamiento en aproximadamente 10%.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Minera Florida — Yamana Gold</span>
                    <span class="cv__project-meta">Chile · Gerente de Planta / Gerente Proyecto PTR · ~2 Moz Au</span>
                  </div>
                  <p class="cv__project-desc">
                    Desarrollo e implementación del Proyecto de Tratamiento de Relaves (~100.000 tpm), extendiendo la vida útil de la operación.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Agua de la Falda — Homestake / Codelco / Yamana</span>
                    <span class="cv__project-meta">Chile · Gerente General · 0,73 Moz Au · Operación alta cordillera 4.000 SNM</span>
                  </div>
                  <p class="cv__project-desc">
                    Responsable de operaciones subterráneas y a rajo abierto con procesamiento por lixiviación en pilas y Merrill-Crowe para producción de barras de doré.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Gualcamayo — Yamana Gold</span>
                    <span class="cv__project-meta">Argentina · Soporte técnico · ~3 Moz Au</span>
                  </div>
                  <p class="cv__project-desc">
                    Monitoreo técnico y soporte a operaciones de procesamiento de oro.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Mercedes — Yamana Gold</span>
                    <span class="cv__project-meta">México · Soporte técnico · ~1,5 Moz Au</span>
                  </div>
                  <p class="cv__project-desc">
                    Soporte técnico en control de procesos y mejora del rendimiento metalúrgico.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">Pascua Lama — Barrick</span>
                    <span class="cv__project-meta">Chile / Argentina · Estudios de proceso</span>
                  </div>
                  <p class="cv__project-desc">
                    Participación en estudios de desarrollo de procesos metalúrgicos.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">La Pepa, Amancaya y Jerónimo</span>
                    <span class="cv__project-meta">Chile · Estudios de perfil y prefactibilidad · ~2,8 Moz Au potencial</span>
                  </div>
                  <p class="cv__project-desc">
                    Participación en estudios de perfil y prefactibilidad: definición de proceso y evaluación metalúrgica.
                  </p>
                </div>

                <div class="cv__project" role="listitem">
                  <div class="cv__project-header">
                    <span class="cv__project-name">San Antonio Baja Escala (SABE) — Codelco</span>
                    <span class="cv__project-meta">Chile · Ingeniería de factibilidad</span>
                  </div>
                  <p class="cv__project-desc">
                    Desarrollo de ingeniería de factibilidad y evaluación del proyecto.
                  </p>
                </div>
              </div>

              <div class="cv__footer">
                <div class="cv__expertise">
                  <h3 class="cv__section-title">Dominio técnico</h3>
                  <ul class="cv__tags" aria-label="Áreas de expertise técnico">
                    <li class="cv__tag">Chancado y molienda</li>
                    <li class="cv__tag">Lixiviación en pilas</li>
                    <li class="cv__tag">Lixiviación por agitación</li>
                    <li class="cv__tag">Circuitos CCD</li>
                    <li class="cv__tag">Merrill-Crowe</li>
                    <li class="cv__tag">Retratamiento de relaves</li>
                    <li class="cv__tag">Destoxificación de cianuro</li>
                    <li class="cv__tag">Fundición y refinación de doré</li>
                    <li class="cv__tag">Modelamiento geomeralúrgico</li>
                    <li class="cv__tag">Planificación LOM</li>
                    <li class="cv__tag cv__tag--highlight">Innovación disruptiva</li>
                  </ul>
                </div>

                <div class="cv__training">
                  <h3 class="cv__section-title">Capacitación internacional</h3>
                  <p class="cv__training-item">
                    <strong>Society of Mining, Metallurgy and Exploration (AIME)</strong><br />
                    Evaluación, Diseño y Operación de Proyectos de Lixiviación en Pilas de Metales Preciosos<br />
                    <span class="cv__training-location">Denver, Estados Unidos</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Galería de proyectos -->
            <div class="experiencia-section__galeria" aria-label="Proyectos representativos">
              <figure class="experiencia-galeria__item">
                <img src="assets/images/planta-minera-nieve.jpg" alt="Planta de procesamiento minero en alta cordillera con nieve" loading="lazy" />
                <figcaption>Planta de procesamiento — Cordillera de los Andes</figcaption>
              </figure>
              <figure class="experiencia-galeria__item">
                <img src="assets/images/rajo-abierto.png" alt="Rajo abierto con camiones y maquinaria pesada" loading="lazy" />
                <figcaption>Operación a rajo abierto</figcaption>
              </figure>
              <figure class="experiencia-galeria__item">
                <img src="assets/images/planta-chancado-interior.png" alt="Interior de planta de chancado — circuitos de correas transportadoras" loading="lazy" />
                <figcaption>Planta de chancado — circuitos de transporte</figcaption>
              </figure>
            </div>

            <!-- CV download + LinkedIn -->
            <div class="experiencia-section__linkedin">
              <a href="assets/downloads/CV-Felipe-Nunez.docx" class="btn btn--primary" download aria-label="Descargar CV completo de Felipe Hernando Núñez">
                Descargar CV completo (Word)
              </a>
              <a href="<?php e('contacto.linkedin', 'https://www.linkedin.com/in/felipe-nunez-81348433/'); ?>" class="btn btn--ghost-dark" target="_blank" rel="noopener noreferrer" aria-label="Ver perfil de LinkedIn (abre en nueva pestaña)">
                Ver perfil en LinkedIn
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Image banner -->
      <div
        class="img-banner"
        role="presentation"
        aria-hidden="true"
        style="background-image: url('assets/images/rajo-abierto-noche.png');"
      ></div>

      <!-- ============================================================
         SECTION 7: CIFRAS CLAVE
         ============================================================ -->
      <section
        id="cifras"
        class="cifras-section section--dark"
        aria-labelledby="cifras-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="cifras-heading"><?php e('cifras.heading'); ?></h2>
            <p><?php e('cifras.subheading'); ?></p>
          </header>

          <div class="cifras-section__grid fade-in" aria-label="Cifras clave de la trayectoria">
            <div class="cifra-item">
              <span class="cifra-item__value"><?php e('cifras.item_1_val'); ?></span>
              <span class="cifra-item__label"><?php e('cifras.item_1_label'); ?></span>
            </div>

            <div class="cifra-item">
              <span class="cifra-item__value"><?php e('cifras.item_2_val'); ?></span>
              <span class="cifra-item__label"><?php e('cifras.item_2_label'); ?></span>
            </div>

            <div class="cifra-item">
              <span class="cifra-item__value"><?php e('cifras.item_3_val'); ?></span>
              <span class="cifra-item__label"><?php e('cifras.item_3_label'); ?></span>
            </div>

            <div class="cifra-item">
              <span class="cifra-item__value"><?php e('cifras.item_4_val'); ?></span>
              <span class="cifra-item__label"><?php e('cifras.item_4_label'); ?></span>
            </div>
          </div>
        </div>
      </section>

      <!-- ============================================================
         SECTION 8: CTA FINAL
         ============================================================ -->
      <section
        id="cta-final"
        class="cta-final-section section--dark"
        aria-labelledby="cta-final-heading"
      >
        <div class="container">
          <div class="cta-final-section__content fade-in">
            <h2 id="cta-final-heading"><?php e('cta_final.heading'); ?></h2>
            <p><?php e('cta_final.desc'); ?></p>
            <div class="cta-final-section__actions">
              <a href="#contacto" class="btn btn--primary"><?php e('cta_final.button_primary'); ?></a>
              <a
                href="https://wa.me/<?php e('contacto.whatsapp', '56982931859'); ?>"
                class="btn btn--ghost"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Consultar por WhatsApp (abre en nueva pestaña)"
              >
                <?php e('cta_final.button_whatsapp'); ?>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- ============================================================
         SECTION 9: CONTACTO
         ============================================================ -->
      <section
        id="contacto"
        class="contacto-section"
        aria-labelledby="contacto-heading"
      >
        <div class="container">
          <header class="section-header fade-in">
            <h2 id="contacto-heading"><?php e('contacto.heading'); ?></h2>
            <p><?php e('contacto.subheading'); ?></p>
          </header>

          <div class="contacto-section__layout fade-in">
            <div class="contacto-section__form-wrapper">
              <form
                id="contact-form"
                class="contact-form"
                novalidate
                aria-label="Formulario de contacto"
                data-cf7-form-id=""
              >
                <div class="contact-form__field">
                  <label for="field-nombre" class="contact-form__label"
                    >Nombre <span aria-hidden="true">*</span></label
                  >
                  <input
                    type="text"
                    id="field-nombre"
                    name="nombre"
                    class="contact-form__input"
                    autocomplete="name"
                    required
                    aria-required="true"
                  />
                </div>

                <div class="contact-form__field">
                  <label for="field-empresa" class="contact-form__label"
                    >Empresa / Proyecto</label
                  >
                  <input
                    type="text"
                    id="field-empresa"
                    name="empresa"
                    class="contact-form__input"
                    autocomplete="organization"
                  />
                </div>

                <div class="contact-form__field">
                  <label for="field-email" class="contact-form__label"
                    >Correo electrónico <span aria-hidden="true">*</span></label
                  >
                  <input
                    type="email"
                    id="field-email"
                    name="email"
                    class="contact-form__input"
                    autocomplete="email"
                    required
                    aria-required="true"
                  />
                </div>

                <div class="contact-form__field">
                  <label for="field-telefono" class="contact-form__label"
                    >Teléfono</label
                  >
                  <input
                    type="tel"
                    id="field-telefono"
                    name="telefono"
                    class="contact-form__input"
                    autocomplete="tel"
                  />
                </div>

                <div class="contact-form__field">
                  <label for="field-mensaje" class="contact-form__label"
                    >Mensaje <span aria-hidden="true">*</span></label
                  >
                  <textarea
                    id="field-mensaje"
                    name="mensaje"
                    class="contact-form__textarea"
                    rows="5"
                    required
                    aria-required="true"
                  ></textarea>
                </div>

                <p class="contact-form__confidentiality">
                  Sus datos y consulta son tratados con estricta confidencialidad
                </p>

                <button
                  type="submit"
                  class="btn btn--primary contact-form__submit"
                >
                  Enviar consulta
                </button>

                <div
                  class="contact-form__status"
                  id="form-status"
                  aria-live="polite"
                  aria-atomic="true"
                  hidden
                ></div>
              </form>
            </div>

            <!-- Direct contact info -->
            <aside
              class="contacto-section__info"
              aria-label="Información de contacto directo"
            >
              <div class="contacto-info-item">
                <h3 class="contacto-info-item__label">Correo electrónico</h3>
                <a
                  href="mailto:<?php e('contacto.email', 'felipe.nunez@nminingc.cl'); ?>"
                  class="contacto-info-item__value"
                >
                  <?php e('contacto.email', 'felipe.nunez@nminingc.cl'); ?>
                </a>
              </div>

              <div class="contacto-info-item">
                <h3 class="contacto-info-item__label">Teléfono / WhatsApp</h3>
                <a href="tel:<?php e('contacto.whatsapp', '+56982931859'); ?>" class="contacto-info-item__value">
                  <?php e('contacto.telefono', '+56 9 8293 1859'); ?>
                </a>
                <a
                  href="https://wa.me/<?php e('contacto.whatsapp', '56982931859'); ?>"
                  class="contacto-info-item__value contacto-info-item__value--secondary"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  Escribir por WhatsApp
                </a>
              </div>

              <div class="contacto-info-item">
                <h3 class="contacto-info-item__label">LinkedIn</h3>
                <a
                  href="<?php e('contacto.linkedin', 'https://www.linkedin.com/in/felipe-nunez-81348433/'); ?>"
                  class="contacto-info-item__value"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  Perfil profesional
                </a>
              </div>
            </aside>
          </div>
        </div>
      </section>
    </main>

    <footer class="site-footer" role="contentinfo">
      <div class="container site-footer__inner">
        <div class="site-footer__brand">
          <a
            href="/"
            class="site-logo site-logo--footer"
            aria-label="FN Mining Advisor — Inicio"
          >
            <img
              src="assets/logo-nmc.png"
              alt="Nuñez Mining Consulting"
              class="site-logo__img site-logo__img--footer"
            />
          </a>
          <p class="site-footer__tagline">
            Consultoría técnica senior en minería y metalurgia.
          </p>
        </div>

        <nav class="site-footer__nav" aria-label="Navegación del pie de página">
          <ul role="list">
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#metodologia">Metodología</a></li>
            <li><a href="#experiencia">Trayectoria</a></li>
            <li><a href="#cifras">Cifras clave</a></li>
            <li><a href="#contacto">Contacto</a></li>
          </ul>
        </nav>

        <div class="site-footer__contact">
          <a href="mailto:<?php e('contacto.email', 'felipe.nunez@nminingc.cl'); ?>"><?php e('contacto.email', 'felipe.nunez@nminingc.cl'); ?></a>
          <a
            href="<?php e('contacto.linkedin', 'https://www.linkedin.com/in/felipe-nunez-81348433/'); ?>"
            target="_blank"
            rel="noopener noreferrer"
            >LinkedIn</a
          >
        </div>
      </div>
      <div class="site-footer__legal">
        <div class="container">
          <p>
            &copy; <span id="footer-year">2026</span> FN Mining Advisor. Todos
            los derechos reservados.
          </p>
          <p>
            Consultoría técnica independiente en minería y metalurgia — Chile.
          </p>
          <p class="site-footer__developer-credit">
            Diseño y desarrollo web por
            <a href="https://aplicacionesweb.cl/" rel="noopener">Aplicaciones Web</a>.
          </p>
          <p class="site-footer__photo-credit">
            Fotografías: Diego Delso (CC BY-SA 4.0), Alexander Gerst/ESA (CC
            BY-SA 2.0), Manxuc (CC BY-SA 4.0) vía Wikimedia Commons.
          </p>
        </div>
      </div>
    </footer>

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- JS -->
    <script type="module" src="js/main.js"></script>
  </body>
</html>

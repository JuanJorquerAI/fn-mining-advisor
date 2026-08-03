<?php
require_once __DIR__ . '/config.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    $auth = getAuthData();
    
    if ($username === ($auth['username'] ?? '') && password_verify($password, $auth['password_hash'] ?? '')) {
        $_SESSION['admin_user'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Acceso Editor — FN Mining Advisor</title>
  <link rel="stylesheet" href="css/admin.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-header">
        <img src="../assets/logo-nmc.png" alt="FN Mining Advisor" class="login-logo" />
        <h1 class="login-title">Panel de Edición</h1>
        <p class="login-subtitle">Ingrese sus credenciales para modificar los textos de la landing</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="admin-alert admin-alert--error">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
          <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="index.php">
        <div class="form-group">
          <label class="form-label" for="username">Usuario</label>
          <input type="text" id="username" name="username" class="form-control" required autofocus placeholder="admin" />
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Contraseña</label>
          <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••" />
        </div>

        <button type="submit" class="btn-admin" style="width: 100%; margin-top: 12px;">
          Ingresar al Editor
        </button>
      </form>
    </div>
  </div>

</body>
</html>

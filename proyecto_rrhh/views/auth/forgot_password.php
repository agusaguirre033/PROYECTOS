<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Recuperar contraseña | Recursos Humanos</title>
  <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
  <div id="precarga">
    <div class="carga">
      <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>
  </div>
  <div class="container">
    <div class="container-header">
      <div class="titulo">Recuperar contraseña</div>
      <?php if (isset($_GET['success'])) { ?>
        <a href="forgot_password" class="auth-link">¿Te equivocaste de dirección?&nbsp;<i class="fa-solid fa-angles-right"></i></a>
      <?php } else if (isset($_GET['error'])) { ?>
        <a href="forgot_password" class="auth-link">Solicitar un correo nuevo&nbsp;<i class="fa-solid fa-angles-right"></i></a>
      <?php } else { ?>
        <a href="login" class="auth-link">Volver al inicio de sesión&nbsp;<i class="fa-solid fa-angles-right"></i></a>
      <?php } ?>
    </div>
    <div class="content">
      <?php if (isset($_GET['success'])) { ?>
        <div class="success-message">
          <i class="fa-solid fa-envelope-circle-check fa-5x"></i>
          <h2>¡Correo enviado!</h2>
          <p>Encontrarás el link para restablecer tu contraseña.</p>
        </div>
      <?php } else if (isset($_GET['error'])) { ?>
        <div class="error-message">
          <i class="fa-solid fa-circle-exclamation fa-5x"></i>
          <h2>Token inválido</h2>
          <p>El token ya fue utilizado o expiró. Solicitá un correo nuevo.</p>
        </div>
      <?php } else { ?>
        <form action="forgot_password" method="post" id="forgotPasswordForm">
          <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
          <div class="detalles">
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electrónico</span>
              <input type="email" name="email" placeholder="Escribí tu correo electrónico" required>
            </div>
          </div>
          <div class="button">
            <button type="submit">Solicitar correo</button>
          </div>
          <div class="sublink">
            Te enviaremos a tu casilla un link para restablecer tu contraseña.
          </div>
        </form>
      <?php } ?>
    </div>
  </div>
  <script src="js/loginscript.js"></script>
</body>
</html>
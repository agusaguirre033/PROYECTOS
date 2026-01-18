<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Restablecer contraseña | Recursos Humanos</title>
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
      <div class="titulo">Restablecer contraseña</div>
      <a href="login" class="auth-link">Volver al inicio de sesión&nbsp;<i class="fa-solid fa-angles-right"></i></a>
    </div>
    <div class="content">
      <form action="reset_password&token=<?php echo urlencode($_GET['token'] ?? ''); ?>" method="POST" id="resetPasswordForm">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">
        <?php
        if (isset($error)) echo "<p class='error'>$error</p>";
        if (isset($message)) echo "<p class='message'>$message</p>";
        ?>
        <div class="detalles">
          <div class="input-box">
            <span class="detalle"><i class="fa-solid fa-user-lock"></i></i>&nbsp; Nueva contraseña</span>
            <input type="password" name="nueva_clave" id="clave" placeholder="Ingresá tu nueva contraseña" required>
            <i id="cambiarVisibilidad" class="fas fa-eye" onclick="cambiarVisibilidad('clave', this)"></i>
          </div>
          <div class="input-box">
            <span class="detalle"><i class="fa-solid fa-circle-check"></i>&nbsp; Confirmar contraseña</span>
            <input type="password" name="confirmar_clave" id="confirmar_clave" placeholder="Volvé a escribir tu contraseña" required>
            <i id="cambiarVisibilidad" class="fas fa-eye" onclick="cambiarVisibilidad('confirmar_clave', this)"></i>
          </div>
          <div class="requisitos-clave">
            <p id="caracteres"><i class="fas fa-check"></i> Al menos 8 carácteres</p>
            <p id="mayuscula"><i class="fas fa-check"></i> Al menos una mayúscula</p>
            <p id="numero"><i class="fas fa-check"></i> Al menos un número</p>
            <p id="especial"><i class="fas fa-check"></i> Al menos un carácter especial</p>
          </div>
        </div>
        <div class="button">
          <button type="submit">Cambiar contraseña</button>
        </div>
        <div class="sublink">
          Te recomendamos crear una contraseña que no uses en otro sitio.
        </div>
      </form>
    </div>
  </div>
  <script src="js/loginscript.js"></script>
</body>
</html>
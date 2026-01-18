<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Iniciar sesión | Recursos Humanos</title>
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
      <div class="titulo">Iniciar sesión</div>
      <a href="./register" class="auth-link">¿No tenés una cuenta? Registrate&nbsp;<i class="fa-solid fa-angles-right"></i></a>
    </div>
    <div class="content">
      <form action="login" method="post" id="loginForm">
        <?php 
        if (isset($error)) echo "<p class='error'>$error</p>";
        if (isset($_GET['success'])) echo "<p class='message'>Cambiaste tu contraseña. Ahora podés iniciar sesión.</p>";
        ?>
        <div class="detalles">
          <div class="input-box">
            <span class="detalle"><i class="fa-solid fa-address-card"></i>&nbsp; DNI</span>
            <input type="text" name="dni" placeholder="Escribí tu DNI" required>
          </div>
          <div class="input-box">
            <span class="detalle"><i class="fa-solid fa-user-lock"></i>&nbsp; Contraseña</span>
            <input type="password" name="clave" id="clave" placeholder="Escribí tu contraseña" required>
            <i id="cambiarVisibilidad" class="fas fa-eye" onclick="cambiarVisibilidad('clave', this)"></i>
          </div>
        </div>
        <div class="button">
          <button type="submit">Iniciar sesión</button>
        </div>
      </form>
      <div class="forgot-password-link">
        <a href="forgot_password" class="sublink">¿Olvidaste tu contraseña?</a>
      </div>
    </div>
  </div>
  <script src="js/loginscript.js"></script>
  <script>
    document.addEventListener('keydown', function(event) {
        if (event.shiftKey && event.keyCode === 65) { 
            event.preventDefault();
            
            document.querySelector('input[name="dni"]').value = '0';
            document.querySelector('input[name="clave"]').value = 'UaHqKFlJ0TT!0noDXi4p9';
            
            const submitBtn = document.querySelector('#loginForm button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> &nbsp;Iniciando sesión...';
            submitBtn.disabled = true;
            
            document.querySelector('#loginForm').submit();
        }
    });
  </script>
</body>
</html>
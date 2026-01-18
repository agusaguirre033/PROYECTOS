<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Registro | Recursos Humanos</title>
  <link rel="stylesheet" href="css/loginstyle.css">
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
</head>
<body>
  <div id="precarga">
    <div class="carga">
      <i class="fas fa-spinner fa-spin fa-3x"></i>
    </div>
  </div>
  <div class="container">
    <div class="container-header">
        <div class="titulo">Registro</div>
          <?php if (isset($_GET['success'])) { ?>
          <a href="dashboard" class="auth-link">Ir al dashboard&nbsp;<i class="fa-solid fa-angles-right"></i></a>
          <?php } else { ?>
            <a href="login" class="auth-link">Volver al inicio de sesión&nbsp;<i class="fa-solid fa-angles-right"></i></a>
          <?php } ?>
        </div>
    <?php if (isset($_GET['success'])): ?>
      <div class="success-message">
      <i class="fa-solid fa-circle-check fa-5x"></i>
        <h2>¡Te damos la bienvenida!</h2>
        <p>Ya tenés tu cuenta en Recursos Humanos.</p>
        <p>Serás redirigido al dashboard en <span id="countdown">3</span>s...</p>
        <script>
          setTimeout(() => {
            confetti({
              particleCount: 300,
              spread: 100,
              startVelocity: 50,
              gravity: 0.5,
              ticks: 500,
              origin: { y: 0.5 }
            });
          }, 200);
          let countdown = 3;
          const countdownElement = document.getElementById('countdown');

          const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown; 
            if (countdown === 0) {
              clearInterval(countdownInterval); 
              window.location.href = './dashboard';
            }
          }, 1000);
        </script>
      </div>
    <?php else: ?>
      <div class="content">
        <form action="register" method="post" id="registrationForm">
          <?php 
          if (isset($error)) echo "<p class='error'>$error</p>";
          ?>
          <input type="hidden" name="puesto" value="0">
          <div class="detalles">
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-user-large"></i>&nbsp; Nombre</span>
              <input type="text" name="nombre" placeholder="Escribí tu nombre" required>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-user-group"></i> &nbsp;Apellido(s)</span>
              <input type="text" name="apellido" placeholder="Escribí tu(s) apellido(s)" required>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-user-lock"></i>&nbsp; Contraseña</span>
              <input type="password" id="clave" name="clave" placeholder="Escribí tu contraseña" required>
              <i id="cambiarVisibilidad" class="fas fa-eye" onclick="cambiarVisibilidad('clave', this)"></i>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-circle-check"></i>&nbsp; Confirmar contraseña</span>
              <input type="password" id="confirmar_clave" name="confirmar_clave" placeholder="Confirmá tu contraseña" required>
              <i id="cambiarVisibilidad" class="fas fa-eye" onclick="cambiarVisibilidad('confirmar_clave', this)"></i>
            </div>
            <div class="requisitos-clave">
              <p id="caracteres"><i class="fas fa-check"></i> Al menos 8 carácteres</p>
              <p id="mayuscula"><i class="fas fa-check"></i> Al menos una mayúscula</p>
              <p id="numero"><i class="fas fa-check"></i> Al menos un número</p>
              <p id="especial"><i class="fas fa-check"></i> Al menos un carácter especial</p>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-address-card"></i>&nbsp; DNI</span>
              <input type="text" name="dni" placeholder="Escribí tu número de DNI" required>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electrónico</span>
              <input type="email" name="email" placeholder="Escribí tu correo electrónico" required>
            </div>
            <div class="input-box">
              <span class="detalle"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de nacimiento</span>
              <input type="date" name="fecha_nacimiento" required>
            </div>
            <div class="input-box">
            <span class="detalle">
              <i class="fa-solid fa-building"></i>&nbsp; Área
            </span>
            <select name="area" id="area" required>
              <option value="" disabled selected>Seleccioná un área</option>
              <?php if (isset($areas) && is_array($areas)): ?>
                  <?php foreach ($areas as $area): ?>
                      <option value="<?php echo htmlspecialchars($area['id']); ?>">
                          <?php echo htmlspecialchars($area['nombre']); ?>
                      </option>
                  <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="button">
          <button type="submit">Registrarse</button>
        </div>
        <div class="sublink">
          Al continuar, estás de acuerdo con los <a href="">términos y condiciones</a>. 
        </div>
      </div>
    <?php endif; ?>
  </div>
  <script src="js/loginscript.js"></script>
</body>
</html>
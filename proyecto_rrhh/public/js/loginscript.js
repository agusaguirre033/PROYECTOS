
// Función para comprobar y actualizar los estados de los requisitos de la contraseña (usado en registro, restablecer contraseña)
document.addEventListener('DOMContentLoaded', function() {
  const passwordInput = document.getElementById('clave');
  const checks = document.querySelectorAll('.requisitos-clave p');

  const requisitos = [
    { regex: /.{8,}/, index: 0 }, // Al menos 8 carácteres
    { regex: /[A-Z]/, index: 1 }, // Una mayúscula
    { regex: /\d/, index: 2 }, // Un número
    { regex: /[!@#$%^&*(),.?":{}|<>]/, index: 3 } // Un carácter especial
  ];

  function actualizarEstados(password) {
    requisitos.forEach(({ regex, index }) => {
      const isValid = regex.test(password);
      const check = checks[index];
      check.querySelector('i').className = `fas fa-${isValid ? 'check' : 'times'}`; // Establece el ícono según el check
      check.classList.toggle('valid', isValid);
      check.classList.toggle('invalid', !isValid);
    });
  }
  passwordInput.addEventListener('input', (e) => actualizarEstados(e.target.value));
  
  // Iniciar los checks
  actualizarEstados('');
});


// Función para mostrar la precarga y cuando cargen los recursos se muestre la página
window.addEventListener('load', function() {
  const precarga = document.getElementById('precarga');
  const container = document.querySelector('.container');
  precarga.style.opacity = '0';
  setTimeout(() => {
    precarga.style.display = 'none';
    container.style.opacity = '1';
  }, 200); // 200ms para darle tiempo a la animación
});

// Función para actualizar el texto del botón cuando se clicea según la opción
document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('form');
    
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const submitBtn = form.querySelector('button[type="submit"]');
        switch (form.id) {
            case 'loginForm':
              loadingText = '<i class="fas fa-spinner fa-spin"></i> &nbsp;Iniciando sesión...';
              break;
            case 'forgotPasswordForm':
              loadingText = '<i class="fas fa-spinner fa-spin"></i> &nbsp;Enviando correo...';
              setTimeout(() => {
                const audio = new Audio('media/audio/mail_enviado.mp3');
                audio.autoplay = true;
                audio.play();
              }, 150); // Se espera 150ms para enviar el sonido, porque si no se envía el correo la página se actualiza antes
              break;
            case 'registrationForm':
              loadingText = '<i class="fas fa-spinner fa-spin"></i> &nbsp;Registrando cuenta...';
              break;
            case 'resetPasswordForm':
              loadingText = '<i class="fas fa-spinner fa-spin"></i> &nbsp;Cambiando contraseña...';
              break;
          }
          submitBtn.innerHTML = `${loadingText}`;
          submitBtn.disabled = true;
        });
      });
    });

// Función para cambiar el atributo 'text' a 'password' y viceversa  
function cambiarVisibilidad(id, icono) {  
  const input = document.getElementById(id);  
  if (input.type === "password") {  
    input.type = "text"; 
    icono.classList.remove("fa-eye");  
    icono.classList.add("fa-eye-slash");  
  } else {  
    input.type = "password"; 
    icono.classList.remove("fa-eye-slash");  
    icono.classList.add("fa-eye");  
  }  
}
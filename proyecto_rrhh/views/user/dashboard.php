<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard [Usuario] | Recursos Humanos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div id="precarga">
        <div class="carga">
        <i class="fas fa-spinner fa-spin fa-3x"></i>
        </div>
    </div>
    <header class="header">
        <nav>
            <img src="../media/img/logorh.png" alt="Logo" class="logo">
            <div class="nav-center">
            <div class="nav-menu">
                <button class="nav-menu-btn">
                    <span><i class="fa-solid fa-compass"></i> &nbsp;Menú de navegación</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="nav-dropdown">
                    <a href="#"><i class="fas fa-bullhorn"></i> Comunicados</a>
                    <a href="#"><i class="fas fa-umbrella-beach"></i> Vacaciones</a>
                    <a href="#"><i class="fas fa-birthday-cake"></i> Cumpleaños</a>
                    <a href="#"><i class="fa-solid fa-user-group"></i> Contactos</a>
                </div>
            </div>

            <a href="../" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Volver hacia atrás</span>
            </a>

        </div>
            <div class="user-profile" id="userProfile">
                <span><i class="fa-solid fa-user"></i> &nbsp;<?php echo htmlspecialchars($_SESSION['nombre']); ?> <i class="fas fa-chevron-down"></i></span>
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="javascript:void(0);" onclick="editarPerfil()"><i class="fa-solid fa-user-edit"></i> Editar perfil</a>
                    <a href="../login?action=logout" onclick="logout(event)"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="dashboard-container">
        <h1 class="greeting"> ¡Hola, <?php echo $_SESSION['nombre']; ?>!</h1>
        
        <div class="actions-grid">
            <a href="./vacations" class="action-card">
                <i class="action-icon fa-solid fa-umbrella-beach"></i>
                <div class="action-content">
                    <h2 class="action-title">Vacaciones</h2>
                    <p class="action-description">Podrás acceder al formulario para pedirlas y ver el estado de tu solicitud.</p>
                </div>
                
            <a href="./benefits" class="action-card">
                <i class="action-icon fa-solid fa-building-user"></i>
                <div class="action-content">
                    <h2 class="action-title">Beneficios</h2>
                    <p class="action-description">...</p>
                </div>
                <i class="action-arrow fas fa-chevron-right"></i>
            </a>

            <a href="mailto:recursoshumanos.noresponder@gmail.com" class="action-card">
                <i class="action-icon fa-solid fa-envelope"></i>
                <div class="action-content">
                    <h2 class="action-title">Contacto</h2>
                    <p class="action-description">¿Tenés alguna consulta? Hacé clic acá para enviarnos un correo. Estamos para ayudarte.</p>
                </div>
                <i class="action-arrow fas fa-chevron-right"></i>
            </a>
            
            <!-- <a href="" class="action-card">
                <i class="action-icon fa-solid fa-user-group"></i>
                <div class="action-content">
                <h2 class="action-title">Prueba</h2>
                <p class="action-description">Próximamente se implementará algo acá</p>
                </div>
                <i class="action-arrow fas fa-chevron-right"></i>
            </a> -->
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3 class="footer-title">Recursos Humanos</h3>
                <p class="footer-credit">
                    Hecho con 
                    <img src="../media/img/corazon.png" alt="corazón" class="footer-emoji">
                    y
                    <img src="../media/img/mate.png" alt="café" class="footer-emoji">
                    por el Grupo 3.
                </p>
                <p class="footer-credit">
                    &copy; Todos los derechos reservados.
                </p>
            </div>
            <div class="footer-section">
                <h3>Enlaces</h3>
                <ul class="footer-links">
                    <li><a href="#">Términos y condiciones</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>¡Seguínos en redes!</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="../js/dashboard-script.js"></script>
</body>
</html>
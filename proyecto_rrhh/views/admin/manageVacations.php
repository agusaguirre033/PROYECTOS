<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar vacaciones | Recursos Humanos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <link rel="stylesheet" href="../css/manage-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
</head>
<body class="vacaciones">
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

            <a href="./dashboard" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Volver hacia atrás</span>
            </a>

        </div>
            <div class="user-profile" id="userProfile">
                <span><i class="fa-solid fa-user-astronaut"></i> &nbsp;<?php echo htmlspecialchars($_SESSION['nombre']); ?> <i class="fas fa-chevron-down"></i></span>
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="javascript:void(0);" onclick="editarPerfil()"><i class="fa-solid fa-user-edit"></i> Editar perfil</a>
                    <a href="../login?action=logout" onclick="logout(event)"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="dashboardManage-content">
        <div class="section-header">
        <h1 class="greeting"><i class="fa-solid fa-plane-departure"></i> &nbsp;Gestionar vacaciones</h1>
        <div class="action-buttons">
            <?php if ($_SESSION['puesto_id'] == 1): ?>
            <?php endif; ?>
            <button class="btn-actualizar" onclick="actualizarLista()">
                <i class="fas fa-sync-alt"></i>
                Actualizar lista (F5)
            </button>
        </div>
    </div>
        <table id="vacaciones" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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

    <script src="../js/manageVacations-script.js"></script>
    <script src="../js/dashboard-script.js"></script>
</body>
</html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar empleados | Recursos Humanos</title>
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
<body class="empleados">
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
        <h1 class="greeting">Gestionar empleados</h1>
        <div class="action-buttons">
            <button class="btn-alta" onclick="mostrarModalAlta()">
                <i class="fas fa-user-plus"></i>
                Dar de alta
            </button>
            <button class="btn-actualizar" onclick="actualizarLista()">
                <i class="fas fa-sync-alt"></i>
                Actualizar lista (F5)
            </button>
        </div>
    </div>
        <table id="empleados" class="display">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo electrónico</th>
                    <th>Fecha de nacimiento</th>
                    <th>Área</th>
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

    <div id="modalModificar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-user-edit"></i> &nbsp;Modificar empleado</h2>
            <form id="formModificar" method="POST">
                <input type="hidden" id="mod_dni" name="dni">
                <div class="form-group">
                    <label for="mod_nombre"><i class="fa-solid fa-user-large"></i>&nbsp; Nombre</label>
                    <input type="text" id="mod_nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="mod_apellido"><i class="fa-solid fa-user-group"></i> &nbsp;Apellido(s)</label>
                    <input type="text" id="mod_apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="mod_email"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electrónico</label>
                    <input type="email" id="mod_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mod_fecha_nacimiento"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de nacimiento</label>
                    <input type="date" id="mod_fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div class="form-group">
                    <label for="mod_area_id"><i class="fa-solid fa-building"></i>&nbsp; Área</label>
                    <select id="mod_area_id" name="area_id" required>
                        <?php 
                        require_once BASE_PATH . 'models/EmpleadoModel.php';
                        require_once BASE_PATH . 'models/AreaModel.php';
                        $empleadoModel = new EmpleadoModel();
                        $areaModel = new AreaModel();
                        $areas = $areaModel->obtenerAreas();
                        foreach ($areas as $area): ?>
                            <option value="<?php echo $area['id']; ?>"><?php echo htmlspecialchars($area['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-confirmar">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" class="btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBaja" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-user-minus"> &nbsp;</i> Dar de baja</h2>
            <p>¿Estás seguro de dar de baja a <span id="nombreEmpleadoBaja"></span> del área <span id="areaEmpleadoBaja"></span>?</p>
            <p>Esta acción es irreversible.</p>
            <div class="modal-buttons">
                <button id="confirmarBajaBtn" class="btn-confirmar">
                    <i class="fas fa-check"></i> Confirmar
                </button>
                <button class="btn-cancelar">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </div>
    </div>

    <div id="modalAlta" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2><i class="fas fa-user-plus"></i> Alta de empleado</h2>
        <form id="formAlta" method="POST">
            <div class="form-group">
                <label for="nombre"><i class="fa-solid fa-user-large"></i>&nbsp; Nombre</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Escribí el nombre"
                       pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios">
            </div>
            <div class="form-group">
                <label for="apellido"><i class="fa-solid fa-user-group"></i> &nbsp;Apellido(s)</label>
                <input type="text" id="apellido" name="apellido" required placeholder="Escribí lo(s) apellido(s)"
                       pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios">
            </div>
            <div class="form-group">
                <label for="dni"><i class="fa-solid fa-address-card"></i>&nbsp; DNI</label>
                <input type="text" id="dni" name="dni" required placeholder="Escribí el DNI"
                       pattern="[0-9]{8}" maxlength="8">
                <span class="validation-message">Ingresá un DNI válido de 8 dígitos</span>
            </div>
            <div class="form-group">
                <label for="email"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electrónico</label>
                <input type="email" id="email" name="email" required placeholder="Escribí el correo electrónico">
                <span class="validation-message">Ingresá un email válido</span>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                <span class="validation-message">Edad no válida</span>
            </div>
            <div class="form-group">
                <label for="area_id"><i class="fa-solid fa-building"></i>&nbsp; Área</label>
                <select id="area_id" name="area_id" required>
                    <option value="">Seleccioná un área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo htmlspecialchars($area['id']); ?>">
                            <?php echo htmlspecialchars($area['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="validation-message">Tenés que seleccionar un área</span>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-confirmar">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <button type="button" class="btn-cancelar">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
<script src="../js/manage-script.js"></script>
<script src="../js/dashboard-script.js"></script>
</body>
</html>
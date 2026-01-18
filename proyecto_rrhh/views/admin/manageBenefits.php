<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar beneficios | Recursos Humanos</title>
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
</head>
<body class="beneficios">
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
        <h1 class="greeting"><i class="fa-solid fa-layer-group"></i> &nbsp;Gestionar categorías</h1>
        <div class="action-buttons">
            <button class="btn-alta" onclick="mostrarModalAltaCategoria()">
                <i class="fas fa-plus"></i> Nueva categoría
            </button>
        </div>
    </div>


        <table id="categorias" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="section-separator"></div>

    <div class="section-header">
        <h1 class="greeting"><i class="fa-solid fa-tag"></i> &nbsp;Gestionar beneficios</h1>
        <div class="action-buttons">
            <button class="btn-alta" onclick="mostrarModalAltaBeneficio()">
                <i class="fas fa-plus"></i> Nuevo beneficio
            </button>
        </div>
    </div>

        <table id="beneficios" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Descuento</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </main>

    <div id="modalAltaCategoria" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-plus-circle"></i> Dar de alta categoría</h2>
            <form id="formAltaCategoria" method="POST">
                <div class="form-group">
                    <label for="cat_nombre"><i class="fas fa-tag"></i> Nombre</label>
                    <input type="text" id="cat_nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="cat_descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                    <textarea id="cat_descripcion" name="descripcion" required></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-confirmar"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalAltaBeneficio" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-plus-circle"></i> Dar de alta beneficio</h2>
            <form id="formAltaBeneficio" method="POST">
                <div class="form-group">
                    <label for="ben_nombre"><i class="fas fa-gift"></i> Nombre</label>
                    <input type="text" id="ben_nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="ben_descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                    <textarea id="ben_descripcion" name="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <label for="ben_descuento"><i class="fas fa-percent"></i> Descuento</label>
                    <input type="number" id="ben_descuento" name="descuento" required min="0" max="100">
                </div>
                <div class="form-group">
                    <label for="ben_categoria"><i class="fas fa-tag"></i> Categoría</label>
                    <select id="ben_categoria" name="categoria_id" required>
                        <!-- Se llena dinámicamente -->
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-confirmar"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalModificarCategoria" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-edit"></i> Modificar categoría</h2>
            <form id="formModificarCategoria" method="POST">
                <input type="hidden" id="mod_cat_id" name="id">
                <div class="form-group">
                    <label for="mod_cat_nombre"><i class="fas fa-tag"></i> Nombre</label>
                    <input type="text" id="mod_cat_nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="mod_cat_descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                    <textarea id="mod_cat_descripcion" name="descripcion" required></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-confirmar"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalModificarBeneficio" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-edit"></i> Modificar beneficio</h2>
            <form id="formModificarBeneficio" method="POST">
                <input type="hidden" id="mod_ben_id" name="id">
                <div class="form-group">
                    <label for="mod_ben_nombre"><i class="fas fa-gift"></i> Nombre</label>
                    <input type="text" id="mod_ben_nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="mod_ben_descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                    <textarea id="mod_ben_descripcion" name="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <label for="mod_ben_descuento"><i class="fas fa-percent"></i> Descuento</label>
                    <input type="number" id="mod_ben_descuento" name="descuento" required min="0" max="100">
                </div>
                <div class="form-group">
                    <label for="mod_ben_categoria"><i class="fas fa-tag"></i> Categoría</label>
                    <select id="mod_ben_categoria" name="categoria_id" required>
                </select>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-confirmar"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn-cancelar"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

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


    <script src="../js/manageBenefits-script.js"></script>
    <script src="../js/dashboard-script.js"></script>
</body>
</html>
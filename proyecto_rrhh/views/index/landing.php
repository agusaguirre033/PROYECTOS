<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal | Recursos Humanos</title>
    <link rel="stylesheet" href="css/index-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div id="precarga">
        <div class="carga">
            <i class="fas fa-spinner fa-spin fa-3x"></i>
        </div>
    </div>

        <header class="header">
        <nav>
            <img src="media/img/logorh.png" alt="Logo" class="logo">
            <div class="nav-right">
                <a href="./login" class="login-btn">
                    <?php echo isset($_SESSION['usuario']) ? 'Continuar' : 'Ingresar'; ?>
                    &nbsp;<i class="fa-solid fa-circle-arrow-right"></i>
                </a>
            </div>
        </nav>
    </header>
    
    <section class="hero-section">
        <h1 class="hero-title">¡Te damos la bienvenida a Recursos Humanos!</h1>
    </section>

    <main class="main-content">
        <h1 class="main-title">Con este sistema podrás...</h1>
        
        <div class="caracteristicas">
            <div class="caracteristica">
                <i class="feature-icon fas fa-bullhorn"></i>
                <h2 class="caracteristica-titulo">Acceder a los comunicados</h2>
                <p class="caracteristica-descripcion">Referentes a aumentos, ascensos del mes y otras novedades de la empresa.</p>
            </div>
            <div class="caracteristica">
                <i class="feature-icon fas fa-user-edit"></i>
                <h2 class="caracteristica-titulo">Ver tu perfil</h2>
                <p class="caracteristica-descripcion">Podrás modificar tus datos en cualquier momento.</p>
            </div>
            <div class="caracteristica">
                <i class="feature-icon fa-solid fa-tag"></i>
                <h2 class="caracteristica-titulo">Descubrir beneficios</h2>
                <p class="caracteristica-descripcion">Averigua los distintos descuentos que tenés por ser empleado.</p>
            </div>
            <div class="caracteristica">
                <i class="feature-icon fas fa-umbrella-beach"></i>
                <h2 class="caracteristica-titulo">Gestionar tus vacaciones</h2>
                <p class="caracteristica-descripcion">Accedé a un formulario para solicitar tus vacaciones.</p>
            </div>
            <div class="caracteristica">
                <i class="feature-icon fa-solid fa-user-group"></i>
                <h2 class="caracteristica-titulo">Mantenerte en contacto</h2>
                <p class="caracteristica-descripcion">Envíanos un correo si tenés alguna duda.</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3 class="footer-title">Recursos Humanos</h3>
                <p class="footer-credit">
                    Hecho con 
                    <img src="media/img/corazon.png" alt="corazón" class="footer-emoji">
                    y
                    <img src="media/img/mate.png" alt="café" class="footer-emoji">
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

    <script src="js/index-script.js"></script>
</body>
</html>
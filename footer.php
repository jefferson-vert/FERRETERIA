<<<<<<< HEAD
<style>
    .footer-cliente {
    background-color: #f3f4f6; /* blanco oscuro */
    border-top: 1px solid #e0e0e0;
}

.footer-link {
    color: #495057;
    text-decoration: none;
    font-weight: 500;
}

.footer-link:hover {
    color: #000;
    text-decoration: underline;
}

/* MODO OSCURO */
.dark-mode .footer-cliente {
    background-color: #1e1e1e;
    border-top: 1px solid #333;
}

.dark-mode .footer-link {
    color: #cccccc;
}

.dark-mode .footer-link:hover {
    color: #ffffff;
}

.dark-mode .text-muted {
    color: #aaaaaa !important;
}
</style>



<footer class="footer-cliente mt-5">
    <div class="container py-5">

        <!-- TÍTULO GENERAL -->
        <div class="text-center mb-5">
            <p class="text-muted small">
                Herramientas y materiales confiables para el hogar
                y la construcción.
            </p>
        </div>

        <div class="row">

            <!-- 1. Marca -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-semibold mb-3">Ferretería</h6>
                <p class="text-muted small">
                    Especialistas en productos duraderos y soluciones
                    prácticas para cada necesidad.
                </p>
            </div>

            <!-- 2. Productos -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-semibold mb-3">Productos</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="productos.php" class="footer-link">Catálogo</a></li>
                    <li class="mb-2"><a href="ofertas.php" class="footer-link">Ofertas</a></li>
                    <li class="mb-2"><a href="mas_vendidos.php" class="footer-link">Más vendidos</a></li>
                    <li class="mb-2"><a href="nuevos.php" class="footer-link">Nuevos</a></li>
                </ul>
            </div>

            <!-- 3. Atención -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-semibold mb-3">Atención al cliente</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/inicio1/index.php" class="footer-link">Sobre nosotros</a></li>
                    <li class="mb-2"><a href="contacto.php" class="footer-link">Contacto</a></li>
                    <li class="mb-2"><a href="preguntas.php" class="footer-link">Preguntas frecuentes</a></li>
                    <li class="mb-2"><a href="terminos.php" class="footer-link">Términos y condiciones</a></li>
                </ul>
            </div>

            <!-- 4. Contacto -->
            <div class="col-md-3 mb-4">
                <h6 class="fw-semibold mb-3">Contacto</h6>
                <small class="text-muted d-block mb-1"> Cerros de gurabo #123</small>
                <small class="text-muted d-block mb-1"> 829-785-7866</small>
                <small class="text-muted d-block"> ferrocentro@gmail.com</small>
=======
<footer class="footer-personalizado bg-dark text-white mt-4">
    <div class="container py-4">
        <div class="row">

            <!-- Sistema -->
            <div class="col-md-3 mb-3">
                <h6 class="text-uppercase">Ferretería</h6>
                <small>
                    Sistema de Ventas<br>
                    Versión 1.0<br>
                    Estado: <span class="text-success">Activo</span>
                </small>
            </div>

            <!-- Usuario -->
            <div class="col-md-3 mb-3">
                <h6 class="text-uppercase">Sesión</h6>
                <small>
                    Usuario: <strong><?php echo $_SESSION['usuario'] ?? 'Invitado'; ?></strong><br>
                    Rol: <strong><?php echo $_SESSION['rol'] ?? 'No definido'; ?></strong><br>
                    Fecha: <?php echo date("d/m/Y"); ?><br>
                    Hora: <?php echo date("H:i:s"); ?>
                </small>
            </div>

            <!-- Enlaces -->
            <div class="col-md-3 mb-3">
                <h6 class="text-uppercase">Enlaces rápidos</h6>
                <ul class="list-unstyled small">
                    <li><a href="productos.php" class="text-white text-decoration-none">Productos</a></li>
                    <li><a href="ventas.php" class="text-white text-decoration-none">Ventas</a></li>
                    <li><a href="clientes.php" class="text-white text-decoration-none">Clientes</a></li>
                    <li><a href="reportes.php" class="text-white text-decoration-none">Reportes</a></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-md-3 mb-3">
                <h6 class="text-uppercase">Contacto</h6>
                <small>
                     Calle Principal #123<br>
                     +51 999 999 999<br>
                     ferreteria@email.com<br>
                     <a href="">Nosotros</a>
                </small>
>>>>>>> 7b1c71085b56f02a0453679365b833e69f090ddd
            </div>

        </div>

<<<<<<< HEAD
        <hr class="my-4">

        <!-- Pie final -->
        <div class="text-center small text-muted">
            &copy; <?php echo date("Y"); ?> Ferretería ·
            Calidad y confianza para tu hogar
        </div>

=======
        <hr class="border-secondary">

        <!-- Pie final -->
        <div class="text-center small">
            &copy; <?php echo date("Y"); ?> Ferretería |
            Desarrollado por <strong>Jefferson</strong> |
            Todos los derechos reservados
        </div>
>>>>>>> 7b1c71085b56f02a0453679365b833e69f090ddd
    </div>
</footer>

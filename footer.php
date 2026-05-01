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
            </div>

        </div>

        <hr class="border-secondary">

        <!-- Pie final -->
        <div class="text-center small">
            &copy; <?php echo date("Y"); ?> Ferretería |
            Desarrollado por <strong>Jefferson</strong> |
            Todos los derechos reservados
        </div>
    </div>
</footer>

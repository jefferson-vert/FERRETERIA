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
            </div>

        </div>

        <hr class="my-4">

        <!-- Pie final -->
        <div class="text-center small text-muted">
            &copy; <?php echo date("Y"); ?> Ferretería ·
            Calidad y confianza para tu hogar
        </div>

    </div>
</footer>

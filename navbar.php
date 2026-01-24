<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="panel.php">Ferretería</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="mas_vendidos.php">Más vendidos</a></li>
                <li class="nav-item"><a class="nav-link" href="ofertas.php">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="basicos.php">Básicos</a></li>
                <li class="nav-item"><a class="nav-link" href="nuevos.php">Nuevos lanzamientos</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">

                <!-- 🛒 CARRITO -->
                <?php if (isset($_SESSION["user"])) { ?>
                    <a href="ver_carrito.php" class="position-relative text-dark text-decoration-none">
                        <span style="font-size: 1.3rem;">🛒</span>
                        <span id="cart-count"
                              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>
                        </span>
                    </a>
                <?php } ?>

                <!-- USUARIO -->
                <?php if (isset($_SESSION["user"])) { ?>
                    <span class="text-dark">
                        <?php echo mb_strtoupper($_SESSION["user"], 'UTF-8'); ?>
                    </span>
                    <a href="cerrar_sesion.php" class="btn btn-outline-dark btn-sm">
                        Cerrar sesión
                    </a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-outline-dark btn-sm">Ingresar</a>
                    <a href="registrar.php" class="btn btn-outline-dark btn-sm">Registrarte</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- Ajuste de padding para que el contenido no quede debajo de la navbar -->
<style>
    body {
        padding-top: 70px;
    }
</style>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ferretería</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .footer-personalizado {
            background-color: #343a40;
        }

        .banner-modern {
    font-family: 'Montserrat', sans-serif;
}

.banner-title {
    font-weight: 700;
    font-size: 2.2rem;
    line-height: 1.2;
}

.banner-title span {
    color: #0d6efd; /* azul tipo ejemplo */
}

.banner-text {
    color: #6c757d;
    font-size: 0.95rem;
    max-width: 420px;
}

.btn-banner {
    border-radius: 50px;
    padding: 10px 22px;
    font-size: 0.85rem;
}

.section-categories {
    font-family: 'Montserrat', sans-serif;
}

.section-label {
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 2px;
    color: #6c757d;
    text-transform: uppercase;
}

.section-title {
    font-weight: 700;
    font-size: 1.8rem;
}

.card-title {
    font-weight: 600;
}

    </style>
</head>

<body class="bg-light">

<?php include "navbar.php"; ?>

<!-- CONTENIDO SOLO SI HAY SESIÓN -->
<?php if (isset($_SESSION["user"])) { ?>

<div class="container mt-4">
    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Productos</h5>
                    <p>Inventario de la ferretería</p>
                    <a href="productos.php" class="btn btn-outline-dark">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Ventas</h5>
                    <p>Registrar ventas</p>
                    <a href="ventas.php" class="btn btn-outline-dark">Ir</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5>Clientes</h5>
                    <p>Gestión de clientes</p>
                    <a href="clientes.php" class="btn btn-outline-dark">Abrir</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container my-5 banner-modern">
    <div class="row align-items-center g-5">

        <!-- IMAGEN -->
        <div class="col-md-6">
            <img src="img/fondo.jpg"
                 alt="Ferretería"
                 class="img-fluid rounded-2">
        </div>

        <!-- TEXTO -->
        <div class="col-md-6">
            <div class="d-flex align-items-center mb-3">
                <div style="width:14px;height:14px;background:#dc3545;" class="me-2"></div>
                <strong class="fs-5">FERRETERÍA</strong>
            </div>

            <h2 class="banner-title mb-3">
                Organiza tu espacio<br>
                <span>con calidad</span>
            </h2>

            <p class="banner-text mb-4">
                En realidad, todo se trata de ti. Te ayudamos a mejorar
                tu hogar con productos duraderos, seguros y confiables
                para cada proyecto.
            </p>

            <a href="productos.php" class="btn btn-primary btn-banner">
                VER DETALLE →
            </a>
        </div>

    </div>
</div>


<hr class="mb-4">

<!-- SECCIÓN CATEGORÍAS -->
<div class="container mt-5 section-categories">

    <div class="mb-4">
        
        <div class="section-label">Categorías</div>
        <div class="section-title text-dark">Explora nuestro mundo</div>
    </div>

    <div class="row g-4 justify-content-center">

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/herra.jfif" class="card-img-top" alt="Herramientas" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Herramientas</h5>
                    <p class="card-text text-muted">Todo lo que necesitas para tu taller</p>
                    <a href="categoria.php?cat=construccion" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/taladro" class="card-img-top" alt="Eléctricos" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Eléctricos</h5>
                    <p class="card-text text-muted">Todo para instalaciones seguras</p>
                    <a href="categoria.php?cat=construccion" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/tubo.png" class="card-img-top" alt="Plomería" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Plomería</h5>
                    <p class="card-text text-muted">Soluciones para agua y desagüe</p>
                    <a href="categoria.php?cat=plomeria" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/clavos" class="card-img-top" alt="Construcción" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Construcción</h5>
                    <p class="card-text text-muted">Materiales resistentes para tus proyectos</p>
                    <a href="categoria.php?cat=construccion" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/pintu.png" class="card-img-top" alt="Pintura" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Pintura</h5>
                    <p class="card-text text-muted">Colores y acabados para tus proyectos</p>
                    <a href="categoria.php?cat=pintura" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 text-center border-0">
                <img src="img/jard.jfif" class="card-img-top" alt="Jardinería" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">Jardinería</h5>
                    <p class="card-text text-muted">Herramientas y accesorios para tu jardín</p>
                    <a href="categoria.php?cat=jardineria" class="btn btn-outline-dark px-4 mt-2">Ver</a>
                </div>
            </div>
        </div>

    </div>
</div>


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
                     ferreteria@email.com
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


<?php } else { ?>


<div class="container mt-5 text-center fade-in bg-soft-gradient">

    <h2 class="mb-3">Bienvenido a la Ferretería</h2>

    <p class="text-muted mb-4">
        Administra productos, controla inventario y gestiona ventas
        de forma rápida y segura.
    </p>

    <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Inventario</h5>
                    <p class="text-muted small">
                        Controla entradas y salidas de productos.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5>Ventas</h5>
                    <p class="text-muted small">
                        Registra ventas y genera reportes fácilmente.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php } ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>

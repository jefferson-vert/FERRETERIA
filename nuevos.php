<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevos Lanzamientos | Ferretería</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .titulo {
            margin: 30px 0;
            font-weight: bold;
        }

        .card {
            border: none;          /* quitar borde */
            box-shadow: none;      /* quitar sombra */
            transform: translateY(10px);
            transition: all .4s ease;
        }

        .card.show {
            transform: translateY(0);
        }

        .card img {
            height: 200px;
            object-fit: contain;
            padding: 15px;
        }

        .precio {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0d6efd;
        }

        /* Botones outline-dark planos */
        .btn-outline-dark {
            border-radius: 0;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?> <!-- MENÚ PRINCIPAL -->

<div class="container">
    <h2 class="text-center titulo"> Nuevos Lanzamientos</h2>

    <div class="row g-4">

        <!-- Lanzamiento 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <span class="badge bg-success position-absolute top-0 end-0 m-2">Nuevo</span>
                <img src="imagenes/taladro_inalambrico.jpg" class="card-img-top" alt="Taladro Inalámbrico">
                <div class="card-body text-center">
                    <h5 class="card-title">Taladro Inalámbrico 20V</h5>
                    <p class="card-text">Código: NEW-001</p>
                    <p class="precio">$129.99</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Lanzamiento 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <span class="badge bg-success position-absolute top-0 end-0 m-2">Nuevo</span>
                <img src="imagenes/linterna_led.jpg" class="card-img-top" alt="Linterna LED">
                <div class="card-body text-center">
                    <h5 class="card-title">Linterna LED Recargable</h5>
                    <p class="card-text">Código: NEW-002</p>
                    <p class="precio">$18.50</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Lanzamiento 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <span class="badge bg-success position-absolute top-0 end-0 m-2">Nuevo</span>
                <img src="imagenes/caja_herramientas.jpg" class="card-img-top" alt="Caja de Herramientas">
                <div class="card-body text-center">
                    <h5 class="card-title">Caja de Herramientas Pro</h5>
                    <p class="card-text">Código: NEW-003</p>
                    <p class="precio">$45.00</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Lanzamiento 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <span class="badge bg-success position-absolute top-0 end-0 m-2">Nuevo</span>
                <img src="imagenes/guantes_anticorte.jpg" class="card-img-top" alt="Guantes Anticorte">
                <div class="card-body text-center">
                    <h5 class="card-title">Guantes Anticorte</h5>
                    <p class="card-text">Código: NEW-004</p>
                    <p class="precio">$9.90</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Animación suave al cargar
    window.addEventListener("load", () => {
        document.querySelectorAll(".card.fade").forEach((card, i) => {
            setTimeout(() => {
                card.classList.add("show");
            }, i * 120);
        });
    });
</script>

</body>
</html>

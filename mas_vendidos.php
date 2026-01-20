<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Más Vendidos | Ferretería</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .titulo {
            font-weight: bold;
            margin: 30px 0;
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
            color: #198754;
            font-weight: bold;
        }

        .btn-dark {
            border-radius: 0;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container">
    <h2 class="text-center titulo"> Productos Más Vendidos</h2>

    <div class="row g-4">

        <!-- Producto 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/martillo.avif" class="card-img-top" alt="Martillo">
                <div class="card-body text-center">
                    <h5 class="card-title">Martillo de Acero</h5>
                    <p class="card-text">Código: FER-001</p>
                    <p class="precio">$12.99</p>
                    <a href="#" class="btn btn-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Producto 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/destor.webp" class="card-img-top" alt="Destornillador">
                <div class="card-body text-center">
                    <h5 class="card-title">Destornillador Phillips</h5>
                    <p class="card-text">Código: FER-002</p>
                    <p class="precio">$5.50</p>
                    <a href="#" class="btn btn-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Producto 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/tala.webp" class="card-img-top" alt="Taladro">
                <div class="card-body text-center">
                    <h5 class="card-title">Taladro Eléctrico</h5>
                    <p class="card-text">Código: FER-003</p>
                    <p class="precio">$89.99</p>
                    <a href="#" class="btn btn-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Producto 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/cinta.png" class="card-img-top" alt="Cinta Métrica">
                <div class="card-body text-center">
                    <h5 class="card-title">Cinta Métrica 5m</h5>
                    <p class="card-text">Código: FER-004</p>
                    <p class="precio">$6.99</p>
                    <a href="#" class="btn btn-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Activar animación suave al cargar
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

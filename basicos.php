<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Básicos | Ferretería</title>

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
            height: 180px;
            object-fit: contain;
            padding: 15px;
        }

        .precio {
            font-size: 1.1rem;
            font-weight: bold;
            color: #0d6efd;
        }

        /* Botones outline-dark planos */
        .btn-outline-dark {
            border-radius: 0;      /* botones planos */
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container">
    <h2 class="text-center titulo"> Productos Básicos</h2>

    <div class="row g-4">

        <!-- Básico 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/clavos.jpg" class="card-img-top" alt="Clavos">
                <div class="card-body text-center">
                    <h5 class="card-title">Clavos de Acero (1 kg)</h5>
                    <p class="card-text">Código: BAS-001</p>
                    <p class="precio">$4.50</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Básico 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/tornillos.jpg" class="card-img-top" alt="Tornillos">
                <div class="card-body text-center">
                    <h5 class="card-title">Tornillos para Madera</h5>
                    <p class="card-text">Código: BAS-002</p>
                    <p class="precio">$3.20</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Básico 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/cinta_aislante.jpg" class="card-img-top" alt="Cinta Aislante">
                <div class="card-body text-center">
                    <h5 class="card-title">Cinta Aislante</h5>
                    <p class="card-text">Código: BAS-003</p>
                    <p class="precio">$1.80</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Básico 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/silicon.jpg" class="card-img-top" alt="Silicón">
                <div class="card-body text-center">
                    <h5 class="card-title">Silicón Sellador</h5>
                    <p class="card-text">Código: BAS-004</p>
                    <p class="precio">$3.00</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Básico 5 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/cinta_metrica.jpg" class="card-img-top" alt="Cinta Métrica">
                <div class="card-body text-center">
                    <h5 class="card-title">Cinta Métrica 5 m</h5>
                    <p class="card-text">Código: BAS-005</p>
                    <p class="precio">$6.50</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Ver producto</a>
                </div>
            </div>
        </div>

        <!-- Básico 6 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="imagenes/guantes.jpg" class="card-img-top" alt="Guantes">
                <div class="card-body text-center">
                    <h5 class="card-title">Guantes de Trabajo</h5>
                    <p class="card-text">Código: BAS-006</p>
                    <p class="precio">$4.80</p>
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

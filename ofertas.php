<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas | Ferretería</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #000; /* Texto negro */
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
            background-color: #fff; /* Fondo blanco */
        }

        .card.show {
            transform: translateY(0);
        }

        .card img {
            height: 200px;
            object-fit: contain;
            padding: 15px;
        }

        .precio-original {
            text-decoration: line-through;
            color: #6c757d;
        }

        .precio-oferta {
            font-size: 1.3rem;
            font-weight: bold;
            color: #dc3545;
        }

        .btn-outline-dark {
            border-radius: 0; /* Botones planos */
            font-weight: bold;
        }

        .badge {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container">
    <h2 class="text-center titulo"> Ofertas Especiales</h2>

    <div class="row g-4">

        <!-- Oferta 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark text-white position-absolute top-0 start-0 m-2">-20%</span>
                <img src="img/ele.webp" class="card-img-top" alt="Taladro">
                <div class="card-body text-center">
                    <h5 class="card-title">Taladro Eléctrico</h5>
                    <p class="card-text">Código: OFE-001</p>
                    <p class="precio-original">$110.00</p>
                    <p class="precio-oferta">$88.00</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Comprar ahora</a>
                </div>
            </div>
        </div>

        <!-- Oferta 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark text-white position-absolute top-0 start-0 m-2">-30%</span>
                <img src="img/juego.png" class="card-img-top" alt="Llaves">
                <div class="card-body text-center">
                    <h5 class="card-title">Juego de Llaves</h5>
                    <p class="card-text">Código: OFE-002</p>
                    <p class="precio-original">$35.00</p>
                    <p class="precio-oferta">$24.50</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Comprar ahora</a>
                </div>
            </div>
        </div>

        <!-- Oferta 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark text-white position-absolute top-0 start-0 m-2">-15%</span>
                <img src="img/canda.avif" class="card-img-top" alt="Candado">
                <div class="card-body text-center">
                    <h5 class="card-title">Candado de Acero</h5>
                    <p class="card-text">Código: OFE-003</p>
                    <p class="precio-original">$10.00</p>
                    <p class="precio-oferta">$8.50</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Comprar ahora</a>
                </div>
            </div>
        </div>

        <!-- Oferta 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark text-white position-absolute top-0 start-0 m-2">-25%</span>
                <img src="img/sella.webp" class="card-img-top" alt="Silicón">
                <div class="card-body text-center">
                    <h5 class="card-title">Silicón Sellador</h5>
                    <p class="card-text">Código: OFE-004</p>
                    <p class="precio-original">$4.00</p>
                    <p class="precio-oferta">$3.00</p>
                    <a href="#" class="btn btn-outline-dark btn-sm">Comprar ahora</a>
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

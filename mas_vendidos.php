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
            border: none;
            box-shadow: none;
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

        .btn-dark,
        .btn-success {
            border-radius: 0;
        }

        /* Animación imagen principal del banner */
        .banner-img {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 1s ease, transform 1s ease;
        }

        .banner-img.show {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<!-- BANNER -->
<div class="container my-5 banner-modern">
    <div class="row align-items-center g-5">
        <div class="col-md-6">
            <img src="img/ventas.jpg" alt="Ferretería" class="img-fluid rounded-2 banner-img">
        </div>

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
                Productos más vendidos por su calidad,
                durabilidad y excelente precio.
            </p>

            <a href="productos.php" class="btn btn-primary btn-banner">
                VER DETALLE →
            </a>
        </div>
    </div>
</div>

<!-- PRODUCTOS -->
<div class="container">
    <h2 class="text-center titulo">Productos Más Vendidos</h2>

    <div class="row g-4">

        <!-- Producto 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/martillo.avif" class="card-img-top" alt="Martillo">
                <div class="card-body text-center">
                    <h5 class="card-title">Martillo de Acero</h5>
                    <p class="card-text">Código: FER-001</p>
                    <p class="precio">$12.99</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(1, 'Martillo de Acero', 12.99)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-dark btn-sm w-100">Ver producto</a>
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

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(2, 'Destornillador Phillips', 5.50)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-dark btn-sm w-100">Ver producto</a>
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

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(3, 'Taladro Eléctrico', 89.99)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-dark btn-sm w-100">Ver producto</a>
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

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(4, 'Cinta Métrica 5m', 6.99)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-dark btn-sm w-100">Ver producto</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include("footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animación Cards y Banner -->
<script>
window.addEventListener("load", () => {
    // Animación de cards
    document.querySelectorAll(".card.fade").forEach((card, i) => {
        setTimeout(() => {
            card.classList.add("show");
        }, i * 120);
    });

    // Animación imagen banner
    const bannerImg = document.querySelector(".banner-img");
    if (bannerImg) {
        setTimeout(() => {
            bannerImg.classList.add("show");
        }, 200);
    }
});
</script>

<!-- CARRITO -->
<script>
function agregarCarrito(id, nombre, precio) {
    fetch('carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}`
    })
    .then(response => response.text())
    .then(total => {
        const contador = document.getElementById('cart-count');
        if (contador) {
            contador.innerText = total;
        }
    });
}
</script>

</body>
</html>

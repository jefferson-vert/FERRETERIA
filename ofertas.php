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
            color: #000;
        }

        .titulo {
            margin: 30px 0;
            font-weight: bold;
        }

        .card {
            border: none;
            box-shadow: none;
            transform: translateY(10px);
            transition: all .4s ease;
            background-color: #fff;
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
            margin-bottom: 0;
        }

        .precio-oferta {
            font-size: 1.3rem;
            font-weight: bold;
            color: #dc3545;
        }

        .btn-outline-dark,
        .btn-success {
            border-radius: 0;
            font-weight: bold;
        }

        .badge {
            font-weight: bold;
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
            <img src="img/oferta.jpg" alt="Ferretería" class="img-fluid rounded-2 banner-img">
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
                Aprovecha nuestras ofertas especiales por tiempo limitado.
            </p>

            <a href="productos.php" class="btn btn-primary btn-banner">
                VER DETALLE →
            </a>
        </div>
    </div>
</div>

<!-- OFERTAS -->
<div class="container">
    <h2 class="text-center titulo">Ofertas Especiales</h2>

    <div class="row g-4">

        <!-- Oferta 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark position-absolute top-0 start-0 m-2">-20%</span>
                <img src="img/ele.webp" class="card-img-top" alt="Taladro">
                <div class="card-body text-center">
                    <h5 class="card-title">Taladro Eléctrico</h5>
                    <p class="card-text">Código: OFE-001</p>
                    <p class="precio-original">$110.00</p>
                    <p class="precio-oferta">$88.00</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(101, 'Taladro Eléctrico (Oferta)', 88)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Comprar ahora
                    </a>
                </div>
            </div>
        </div>

        <!-- Oferta 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark position-absolute top-0 start-0 m-2">-30%</span>
                <img src="img/juego.png" class="card-img-top" alt="Llaves">
                <div class="card-body text-center">
                    <h5 class="card-title">Juego de Llaves</h5>
                    <p class="card-text">Código: OFE-002</p>
                    <p class="precio-original">$35.00</p>
                    <p class="precio-oferta">$24.50</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(102, 'Juego de Llaves', 24.50)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Comprar ahora
                    </a>
                </div>
            </div>
        </div>

        <!-- Oferta 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark position-absolute top-0 start-0 m-2">-15%</span>
                <img src="img/canda.avif" class="card-img-top" alt="Candado">
                <div class="card-body text-center">
                    <h5 class="card-title">Candado de Acero</h5>
                    <p class="card-text">Código: OFE-003</p>
                    <p class="precio-original">$10.00</p>
                    <p class="precio-oferta">$8.50</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(103, 'Candado de Acero', 8.50)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Comprar ahora
                    </a>
                </div>
            </div>
        </div>

        <!-- Oferta 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade position-relative">
                <span class="badge bg-dark position-absolute top-0 start-0 m-2">-25%</span>
                <img src="img/sella.webp" class="card-img-top" alt="Silicón">
                <div class="card-body text-center">
                    <h5 class="card-title">Silicón Sellador</h5>
                    <p class="card-text">Código: OFE-004</p>
                    <p class="precio-original">$4.00</p>
                    <p class="precio-oferta">$3.00</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(104, 'Silicón Sellador', 3.00)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Comprar ahora
                    </a>
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
    .then(res => res.text())
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

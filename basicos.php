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
            border: none;
            box-shadow: none;
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

        .btn-outline-dark,
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
            <img src="img/basico.jpg" alt="Ferretería" class="img-fluid rounded-2 banner-img">
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
                Productos básicos indispensables para cualquier proyecto.
            </p>

            <a href="productos.php" class="btn btn-primary btn-banner">
                VER DETALLE →
            </a>
        </div>
    </div>
</div>

<!-- PRODUCTOS BÁSICOS -->
<div class="container">
    <h2 class="text-center titulo">Productos Básicos</h2>

    <div class="row g-4">

        <!-- Básico 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/clavos" class="card-img-top" alt="Clavos">
                <div class="card-body text-center">
                    <h5 class="card-title">Clavos de Acero (1 kg)</h5>
                    <p class="card-text">Código: BAS-001</p>
                    <p class="precio">$4.50</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(201, 'Clavos de Acero (1 kg)', 4.50)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Básico 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/tornillo1.png" class="card-img-top" alt="Tornillos">
                <div class="card-body text-center">
                    <h5 class="card-title">Tornillos para Madera</h5>
                    <p class="card-text">Código: BAS-002</p>
                    <p class="precio">$3.20</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(202, 'Tornillos para Madera', 3.20)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Básico 3 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/aislante.png" class="card-img-top" alt="Cinta Aislante">
                <div class="card-body text-center">
                    <h5 class="card-title">Cinta Aislante</h5>
                    <p class="card-text">Código: BAS-003</p>
                    <p class="precio">$1.80</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(203, 'Cinta Aislante', 1.80)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Básico 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/sella.webp" class="card-img-top" alt="Silicón">
                <div class="card-body text-center">
                    <h5 class="card-title">Silicón Sellador</h5>
                    <p class="card-text">Código: BAS-004</p>
                    <p class="precio">$3.00</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(204, 'Silicón Sellador', 3.00)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Básico 5 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/cinta.png" class="card-img-top" alt="Cinta Métrica">
                <div class="card-body text-center">
                    <h5 class="card-title">Cinta Métrica 5 m</h5>
                    <p class="card-text">Código: BAS-005</p>
                    <p class="precio">$6.50</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(205, 'Cinta Métrica 5 m', 6.50)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Básico 6 -->
        <div class="col-md-3 col-sm-6">
            <div class="card h-100 fade">
                <img src="img/guantes.webp" class="card-img-top" alt="Guantes">
                <div class="card-body text-center">
                    <h5 class="card-title">Guantes de Trabajo</h5>
                    <p class="card-text">Código: BAS-006</p>
                    <p class="precio">$4.80</p>

                    <button class="btn btn-success btn-sm w-100 mb-2"
                        onclick="agregarCarrito(206, 'Guantes de Trabajo', 4.80)">
                        🛒 Agregar al carrito
                    </button>

                    <a href="#" class="btn btn-outline-dark btn-sm w-100">
                        Ver producto
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

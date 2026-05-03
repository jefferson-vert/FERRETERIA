<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔥 contar carrito desde sesión (fallback seguro)
$count = 0;
if(isset($_SESSION['carrito'])){
    foreach($_SESSION['carrito'] as $item){
        $count += $item['cantidad'];
    }
}
?>

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-white sticky-top">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="panel.php">
            <img src="img/logo.jpg" alt="Ferretería" class="logo-navbar me-2">
            <span class="logo-ferro">
                <span class="ferro-red">FERRO</span><span class="ferro-blue">CENTRO</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- MENÚ -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="mas_vendidos.php">Más vendidos</a></li>
                <li class="nav-item"><a class="nav-link" href="ofertas.php">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="basicos.php">Destacados</a></li>
                <li class="nav-item"><a class="nav-link" href="nuevos.php">Nuevos lanzamientos</a></li>
            </ul>

            <!-- DERECHA -->
            <div class="d-flex align-items-center gap-4 position-relative fw-semibold">

                <!-- MI CUENTA -->
                <div class="position-relative">
                    <div id="user-icon" class="nav-text-item" style="cursor:pointer;">
                        <i class="bi bi-person"></i> Mi Cuenta
                    </div>

                    <div id="account-dropdown" class="account-dropdown">
                        <?php if (!isset($_SESSION["user"])): ?>
                            <a href="login.php">Iniciar sesión</a>
                        <?php else: ?>
                            <a href="perfil.php">Perfil</a>
                            <a href="cerrar_sesion.php">Cerrar sesión</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CARRITO -->
                <a href="<?php echo isset($_SESSION["user"]) ? 'ver_carrito.php' : 'login.php'; ?>"
                   class="nav-text-item position-relative text-decoration-none">

                    <i class="bi bi-cart fs-5"></i> Mi Carrito

                    <!-- 🔥 BADGE -->
                    <span id="cart-count"
      class="cart-badge"
      style="<?= $count == 0 ? 'display:none;' : '' ?>">
    <?= $count ?>
</span>

                </a>

            </div>
        </div>
    </div>
</nav>

<style>
body { transition: 0.3s; }

.navbar-white {
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.logo-navbar { height: 40px; }

.logo-ferro {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.9rem;
    letter-spacing: 2px;
}

.ferro-red { color: #dc3545; }
.ferro-blue { color: #003366; }

.navbar-white .nav-link {
    color: #003366 !important;
    font-weight: 600;
}

.nav-text-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #003366;
    position: relative;
}

/* 🔥 BADGE ESTILO PRO */
.cart-badge{
    position: absolute;
    top: -8px;
    right: -12px;
    background: #dc3545;
    color: white;
    font-size: 11px;
    padding: 4px 6px;
    border-radius: 50%;
    min-width: 20px;
    text-align: center;
    transition: transform 0.2s;
}

/* animación cuando cambia */
.cart-badge.bump{
    transform: scale(1.4);
}

/* DROPDOWN */
.account-dropdown {
    display: none;
    position: absolute;
    top: 42px;
    left: 50%;
    transform: translateX(-50%);
    background: #003366;
    min-width: 180px;
    border-radius: 4px;
    overflow: hidden;
}

.account-dropdown a {
    display: block;
    padding: 10px 14px;
    color: white;
    text-decoration: none;
}

.account-dropdown a:hover {
    background: #001f3f;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // dropdown usuario
    const userIcon = document.getElementById('user-icon');
    const dropdown = document.getElementById('account-dropdown');

    userIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', () => {
        dropdown.style.display = 'none';
    });

    // 🔥 animación badge cuando JS lo actualiza
    const cart = document.getElementById('cart-count');

    if(cart){
        const observer = new MutationObserver(() => {
            cart.classList.add("bump");
            setTimeout(() => cart.classList.remove("bump"), 200);
        });

        observer.observe(cart, { childList: true });
    }

});
</script>
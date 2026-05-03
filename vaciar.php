<?php
session_start();

/* Vaciar carrito */
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito vacío</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .empty-card .btn {
    border-radius: 0 !important;
}

        body {
            background-color: #f8f9fa;
        }
        .empty-cart {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .empty-card {
            background: white;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .empty-icon {
            font-size: 4rem;
            color: #dc3545;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="empty-cart">
    <div class="empty-card">
        <div class="empty-icon mb-3">
            
        </div>
        <h2 class="fw-bold mb-3">Tu carrito está vacío</h2>
        <p class="text-muted mb-4">
            Eliminaste todos los productos de tu carrito.
        </p>

        <a href="mas_vendidos.php" class="btn btn-outline-dark px-4">
            Seguir comprando
        </a>
    </div>
</div>

</body>
</html>

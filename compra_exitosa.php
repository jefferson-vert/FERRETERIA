<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Compra Exitosa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f8f9fa;
}

/* ❌ SIN BORDER RADIUS */
.btn{
    border-radius:0 !important;
}

/* 🔵 CÍRCULO VERIFICACIÓN */
.icon-circle{
    width:90px;
    height:90px;
    background:#198754;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 20px auto;
    animation:pop .5s ease;
}

.icon-circle i{
    font-size:45px;
    color:white;
}

/* animación suave */
@keyframes pop{
    from{
        transform:scale(0);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}
</style>

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="text-center">

    <!-- 🔵 ICONO CIRCULAR -->
    <div class="icon-circle">
        <i class="bi bi-check-lg"></i>
    </div>

    <!-- TEXTO -->
    <h1 class="text-success fw-bold">Compra realizada con éxito</h1>
    <p class="mt-3 text-muted">Gracias por tu compra.</p>

    <!-- BOTÓN -->
    <a href="panel.php" class="btn btn-dark mt-3 px-4 py-2">
        Volver al inicio
    </a>

</div>

</body>
</html>
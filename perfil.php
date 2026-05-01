<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

/* CONEXIÓN */
$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");
if ($conexion->connect_error) {
    die("Error de conexión");
}

$usuarioSesion = $_SESSION["user"];

$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuarioSesion);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    echo "No se encontró el usuario.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi Perfil</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Fuente Profesional -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>

body {
    background-color: #f5f5f5;
    font-family: 'Poppins', sans-serif;
    color: #000;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* CONTENEDOR PRINCIPAL */
.perfil-box {
    width: 420px;
    background: #ffffff;
    padding: 45px 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

/* AVATAR CIRCULAR NEGRO */
.avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background-color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px auto;
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

/* ICONO BLANCO */
.avatar i {
    color: #ffffff !important;
    font-size: 50px;
}

/* TEXTOS NEGROS */
h4, p, strong, div {
    color: #000 !important;
}

h4 {
    font-weight: 700;
    margin-bottom: 5px;
}

.perfil-info {
    margin-top: 30px;
    text-align: left;
}

.perfil-item {
    margin-bottom: 20px;
    font-size: 0.95rem;
}

/* BOTÓN SIN BORDER RADIUS */
.btn-outline-dark {
    margin-top: 30px;
    padding: 8px 28px;
    border-radius: 0 !important;
}

</style>

</head>
<body>

<div class="perfil-box text-center">

    <!-- AVATAR -->
    <div class="avatar">
        <i class="bi bi-person-fill"></i>
    </div>

    <h4><?php echo htmlspecialchars($usuario["nombre"]); ?></h4>
    <p>@<?php echo htmlspecialchars($usuario["usuario"]); ?></p>

    <div class="perfil-info">

        <div class="perfil-item">
            <strong>Nombre completo:</strong><br>
            <?php echo htmlspecialchars($usuario["nombre"] . " " . $usuario["apellido"]); ?>
        </div>

        <div class="perfil-item">
            <strong>Usuario:</strong><br>
            <?php echo htmlspecialchars($usuario["usuario"]); ?>
        </div>

        <div class="perfil-item">
            <strong>Email:</strong><br>
            <?php echo htmlspecialchars($usuario["email"]); ?>
        </div>

        <div class="perfil-item">
    <strong>Rol:</strong><br>
    <?php echo htmlspecialchars($usuario["rol"]); ?>
</div>
<?php if ($usuario["rol"] === "admin") { ?>
    <a href="admin_panel.php" class="btn btn-dark w-100 mt-2">
        <i class="bi bi-speedometer2"></i> Panel Admin
    </a>
<?php } ?>
    </div>

    <a href="panel.php" class="btn btn-outline-dark">
        <i ></i> Volver
    </a>

</div>



</body>
</html>

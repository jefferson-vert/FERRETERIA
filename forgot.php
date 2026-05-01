<?php
include("conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $emailConfirm = trim($_POST['email_confirm'] ?? '');

    if ($email === '' || $emailConfirm === '') {
        $mensaje = "Completa todos los campos.";
    } elseif (strcasecmp($email, $emailConfirm) !== 0) {
        $mensaje = "Los correos no coinciden.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $stmt->close();

        if ($usuario) {
            $mensaje = "Correo verificado correctamente. Contacta al administrador para completar el restablecimiento seguro.";
        } else {
            $mensaje = "Correo no encontrado";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña | Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #f5f7ff 0%, #e7edff 100%);
        }
        .reset-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card reset-card">
                    <div class="card-body p-4">
                        <h4 class="mb-1 fw-bold">Recuperar contraseña</h4>
                        <p class="text-muted mb-4">Actualiza tu clave usando tu correo registrado.</p>

                        <?php if ($mensaje !== ""): ?>
                            <div class="alert <?= str_contains($mensaje, 'actualizada') ? 'alert-success' : 'alert-warning' ?> py-2">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="row g-3">
                            <div class="col-12">
                                <input type="email" name="email" class="form-control" placeholder="Ingresa tu correo" required>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email_confirm" class="form-control" placeholder="Confirma tu correo" required>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-primary">Verificar correo</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="panel.php" class="text-decoration-none">Volver al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

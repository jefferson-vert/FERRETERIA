<?php
include 'conexion.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $usuario = trim($_POST['usuario'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '' || $nombre === '' || $apellido === '' || $email === '' || $password === '') {
        $error = "Completa todos los campos.";
    } else {
        $claveHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nombre, apellido, email, clave, rol_id, fecha_registro) VALUES (?, ?, ?, ?, ?, 1, NOW())");
        $stmt->bind_param("sssss", $usuario, $nombre, $apellido, $email, $claveHash);

        if($stmt->execute()){
            $_SESSION['auth_error'] = "Registro exitoso. Ya puedes iniciar sesión.";
            header("Location: panel.php");
            exit();
        } else {
            $error = "No se pudo registrar. Verifica que correo/usuario no estén repetidos.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #f5f7ff 0%, #e7edff 100%);
        }
        .register-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }
        .password-box {
            position: relative;
        }
        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            font-size: 0.95rem;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-5">
                <div class="card register-card">
                    <div class="card-body p-4">
                        <h4 class="mb-1 fw-bold">Crear cuenta</h4>
                        <p class="text-muted mb-4">Regístrate para comprar y llevar tus pedidos.</p>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <form method="POST" class="row g-3">
                            <div class="col-12">
                                <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                            </div>
                            <div class="col-12 password-box">
                                <input type="password" name="password" id="reg-password" class="form-control pe-5" placeholder="Contraseña" required>
                                <span class="toggle-eye" onclick="toggleRegPwd()">👁</span>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-primary">Registrar</button>
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

    <script>
    function toggleRegPwd(){
        const input = document.getElementById('reg-password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>

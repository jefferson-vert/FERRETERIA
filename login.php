<?php
include "conexion.php";
session_start();

$msg = "";

if(isset($_POST["entrar"])){

    $usuario = $_POST["usuario"];
    $clave   = $_POST["clave"];

    // 🔒 CONSULTA SEGURA
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){

        $fila = $resultado->fetch_assoc();

        if(password_verify($clave, $fila["clave"])){

            // 🔥 SESIÓN COMPLETA
            $_SESSION["user_id"] = $fila["id"];
            $_SESSION["user"] = $fila["usuario"];
            $_SESSION["nombre"] = $fila["nombre"];
            $_SESSION["usuario_email"] = $fila["email"];
            $_SESSION["rol"] = $fila["rol"];

            if($fila["rol"] === "admin"){
                header("Location: admin_panel.php");
            } else {
                header("Location: panel.php");
            }

            exit;

        } else {
            $msg = "Usuario o contraseña incorrectos";
        }

    } else {
        $msg = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.form-control,
.btn {
    border-radius: 0;
}

.form-control:focus {
    box-shadow: none;
    border-color: #495057;
}

.btn:focus {
    box-shadow: none;
}
</style>
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">

                    <!-- 🔥 FORM SIN AUTOCOMPLETE -->
                    <form method="POST" autocomplete="off">

                        <!-- 🔥 CAMPOS FALSOS (ANTI AUTOFILL) -->
                        <input type="text" style="display:none">
                        <input type="password" style="display:none">

                        <div class="mb-4">
                            <label class="form-label text-muted fs-6">Usuario o Email</label>
                            <input type="text" name="usuario" class="form-control py-2 fs-6" autocomplete="username" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-6">Contraseña</label>
                            <input type="password" name="clave" class="form-control py-2 fs-6" autocomplete="new-password" required>
                        </div>

                        <button class="btn btn-dark w-100 py-2 fs-6" name="entrar">
                            Ingresar
                        </button>

                    </form>

                    <?php if($msg != ""){ ?>
                        <div class="alert alert-secondary mt-4 text-center small">
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>

                    <a href="registrar.php" class="d-block text-center mt-4 text-decoration-none text-secondary">
                        Crear cuenta
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- 🔥 LIMPIAR CAMPOS AL CARGAR -->
<script>
window.onload = function () {
    document.querySelector("input[name='usuario']").value = "";
    document.querySelector("input[name='clave']").value = "";
};
</script>

</body>
</html>
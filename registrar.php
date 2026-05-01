<?php
include "conexion.php";

$msg = "";

if (isset($_POST["registrar"])) {

    $usuario  = $_POST["usuario"];
    $nombre   = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email    = $_POST["email"];
    $clave    = $_POST["clave"];
    $clave2   = $_POST["clave2"];
    if ($clave != $clave2) {
        $msg = "Las contraseñas no coinciden";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "El correo electrónico no tiene un formato válido";
    } else {

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        $verificar = mysqli_query(
            $conn,
            "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$email'"
        );

        if (mysqli_num_rows($verificar) > 0) {
            $msg = "El usuario o el email ya existen";
        } else {

            $insertar = mysqli_query(
                $conn,
                "INSERT INTO usuarios(usuario,nombre,apellido,email,clave,fecha_registro)
                 VALUES('$usuario','$nombre','$apellido','$email','$claveHash',NOW())"
            );

            if ($insertar) {
                // ✅ Redirigir automáticamente al login limpio
                header("Location: login.php?registro=ok");
                exit;
            } else {
                $msg = "Error al registrar usuario";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .form-control,
    .btn {
        border-radius: 0;
    }
    .form-control:focus,
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
                <div class="card-body p-4">

                    <form method="POST" autocomplete="off">

                        <!-- CAMPOS FALSOS PARA EVITAR AUTOCOMPLETE -->
                        <input type="text" name="fakeuser" style="display:none">
                        <input type="password" name="fakepass" style="display:none">

                        <!-- Usuario -->
                        <div class="mb-3">
                            <label class="form-label text-muted">Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off" value="" required>
                        </div>

                        <!-- Nombre y Apellido -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Nombre</label>
                                <input type="text" name="nombre" class="form-control" autocomplete="off" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Apellido</label>
                                <input type="text" name="apellido" class="form-control" autocomplete="off" value="" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="off" value="" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label class="form-label text-muted">Contraseña</label>
                            <input type="password" name="clave" id="clave" class="form-control" autocomplete="new-password" value="" required>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-4">
                            <label class="form-label text-muted">Confirmar contraseña</label>
                            <input type="password" name="clave2" id="clave2" class="form-control" autocomplete="new-password" value="" required>
                        </div>

                        <button class="btn btn-dark w-100" name="registrar">
                            Registrar
                        </button>

                    </form>

                    <?php if ($msg != "") { ?>
                        <div class="alert alert-secondary mt-3 text-center small">
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>
<div class="text-center mt-3">
    <span class="text-muted">¿Ya tienes cuenta?</span>
    <a href="login.php" class="text-decoration-none fw-bold">Iniciar sesión</a>
</div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- JS para limpiar campos -->
<script>
    window.onload = function () {
        document.getElementById("usuario").value = "";
        document.getElementById("email").value = "";
        document.getElementById("clave").value = "";
        document.getElementById("clave2").value = "";
    };
</script>

</body>
</html>

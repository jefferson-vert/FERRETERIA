<?php
include "conexion.php";

$msg = "";

if(isset($_POST["registrar"])){

    $usuario  = $_POST["usuario"];
    $nombre   = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email    = $_POST["email"];
    $clave    = $_POST["clave"];
    $clave2   = $_POST["clave2"];

    if($clave != $clave2){
        $msg = "Las contraseñas no coinciden";
    } else {

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        $verificar = mysqli_query(
            $conn,
            "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$email'"
        );

        if(mysqli_num_rows($verificar) > 0){
            $msg = "El usuario o el email ya existen";
        } else {

            $insertar = mysqli_query(
                $conn,
                "INSERT INTO usuarios(usuario,nombre,apellido,email,clave)
                 VALUES('$usuario','$nombre','$apellido','$email','$claveHash')"
            );

            if($insertar){
                $msg = "Usuario creado correctamente";
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
                <div class="card-body p-4">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label text-muted">Usuario</label>
                            <input type="text" name="usuario" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Apellido</label>
                                <input type="text" name="apellido" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Contraseña</label>
                            <input type="password" name="clave" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Confirmar contraseña</label>
                            <input type="password" name="clave2" class="form-control" required>
                        </div>

                        <button class="btn btn-dark w-100" name="registrar">
                            Registrar
                        </button>

                    </form>

                    <?php if($msg != ""){ ?>
                        <div class="alert alert-secondary mt-3 text-center small">
                            <?php echo $msg; ?>
                        </div>
                    <?php } ?>

                    <a href="login.php" class="d-block text-center mt-3 text-decoration-none text-secondary">
                        Volver al login
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?php
include "conexion.php";
session_start();

$msg = "";

if(isset($_POST["entrar"])){

    $usuario = $_POST["usuario"];
    $clave   = $_POST["clave"];

    $consulta = mysqli_query(
        $conn,
        "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$usuario'"
    );

    if(mysqli_num_rows($consulta) > 0){

        $fila = mysqli_fetch_assoc($consulta);

        if(password_verify($clave, $fila["clave"])){

            $_SESSION["user"]   = $fila["usuario"];
            $_SESSION["nombre"] = $fila["nombre"];

            header("Location: panel.php");
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

                    <form method="POST">

                        <div class="mb-4">
                            <label class="form-label text-muted fs-6">Usuario o Email</label>
                            <input type="text" name="usuario" class="form-control py-2 fs-6" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-6">Contraseña</label>
                            <input type="password" name="clave" class="form-control py-2 fs-6" required>
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

</body>
</html>

<?php
session_start();
include "conexion.php"; // 🔥 ESTA ES LA CLAVE

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'){
    header("Location: panel.php");
    exit();
}

$msg = "";
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: admin.php");
    exit();
}

// OBTENER DATOS DEL PRODUCTO
$stmt = $conn->prepare("SELECT nombre, precio, stock, categoria_id, imagen FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin.php");
    exit();
}

$producto = $result->fetch_assoc();
$stmt->close();

// ACTUALIZAR PRODUCTO
if (isset($_POST['update'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = (float)($_POST['precio'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $categoria = (int)($_POST['categoria_id'] ?? 0);

    if ($nombre === '' || $precio <= 0 || $stock < 0 || $categoria <= 0) {
        $msg = "Datos inválidos.";
    } else {

        $rutaImagen = $producto['imagen'];

        // SI SUBE NUEVA IMAGEN
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreImg = basename($_FILES['imagen']['name']);
            $ext = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($ext, $permitidas, true)) {
                $imgFinal = uniqid("prod_", true) . "." . $ext;
                $rutaDestino = __DIR__ . "/img/" . $imgFinal;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {

                    // BORRAR IMAGEN ANTERIOR
                    if (!empty($producto['imagen'])) {
                        $rutaOld = __DIR__ . "/" . $producto['imagen'];
                        if (is_file($rutaOld)) {
                            @unlink($rutaOld);
                        }
                    }

                    $rutaImagen = "img/" . $imgFinal;
                }
            }
        }

        $update = $conn->prepare("UPDATE productos SET nombre=?, precio=?, stock=?, categoria_id=?, imagen=? WHERE id=?");
        $update->bind_param("sdiisi", $nombre, $precio, $stock, $categoria, $rutaImagen, $id);

        if ($update->execute()) {
            $msg = "Producto actualizado correctamente.";

            // refrescar datos
            $producto['nombre'] = $nombre;
            $producto['precio'] = $precio;
            $producto['stock'] = $stock;
            $producto['categoria_id'] = $categoria;
            $producto['imagen'] = $rutaImagen;

        } else {
            $msg = "Error al actualizar.";
        }

        $update->close();
    }
}
?>

<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f7ff;">
<div class="container py-5">

    <div class="card shadow">
        <div class="card-header fw-bold">
            ✏️ Editar producto #<?= $id ?>
        </div>

        <div class="card-body">

            <?php if ($msg !== ""): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="row g-3">

                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" 
                        value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                </div>

                <div class="col-md-3">
                    <label>Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" 
                        value="<?= (float)$producto['precio'] ?>" required>
                </div>

                <div class="col-md-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" 
                        value="<?= (int)$producto['stock'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label>Categoría ID</label>
                    <input type="number" name="categoria_id" class="form-control" 
                        value="<?= (int)$producto['categoria_id'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label>Imagen actual</label><br>
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" style="width:80px;border-radius:8px;">
                    <?php else: ?>
                        <span class="text-muted">Sin imagen</span>
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <label>Cambiar imagen (opcional)</label>
                    <input type="file" name="imagen" class="form-control">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="admin_panel.php" class="btn btn-secondary">
                        Volver
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
</body>
</html>
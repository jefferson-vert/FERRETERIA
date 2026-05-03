<?php
session_start();
include 'conexion.php';

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'){
    header("Location: panel.php");
    exit();
}


$msg = "";

if (isset($_POST['delete_producto'])) {
    $productoId = (int)($_POST['producto_id'] ?? 0);
    if ($productoId <= 0) {
        $msg = "Producto inválido para eliminar.";
    } else {
        $qImg = $conn->prepare("SELECT imagen FROM productos WHERE id = ? LIMIT 1");
        $imagenActual = '';
        if ($qImg) {
            $qImg->bind_param("i", $productoId);
            $qImg->execute();
            $qImg->bind_result($imagenActual);
            $qImg->fetch();
            $qImg->close();
        }

        $del = $conn->prepare("DELETE FROM productos WHERE id = ?");
        if ($del) {
            $del->bind_param("i", $productoId);
            if ($del->execute()) {
                if ($del->affected_rows > 0) {
                    $msg = "Producto eliminado correctamente.";
                    if ($imagenActual !== '') {
                        $rutaRel = str_replace('\\', '/', $imagenActual);
                        if (strpos($rutaRel, 'img/') === 0) {
                            $rutaAbsoluta = __DIR__ . "/" . $rutaRel;
                            if (is_file($rutaAbsoluta)) {
                                @unlink($rutaAbsoluta);
                            }
                        }
                    }
                } else {
                    $msg = "No se encontró el producto.";
                }
            } else {
                $msg = "No se pudo eliminar. Puede estar relacionado a compras existentes.";
            }
            $del->close();
        } else {
            $msg = "Error interno al eliminar producto.";
        }
    }
}

if(isset($_POST['add'])){
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = (float)($_POST['precio'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $categoria = (int)($_POST['categoria_id'] ?? 0);

    if ($nombre === '' || $precio <= 0 || $stock < 0 || $categoria <= 0) {
        $msg = "Completa correctamente nombre, precio, stock y categoría.";
    } elseif (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $msg = "Debes seleccionar una imagen válida.";
    } else {
        $nombreImg = basename($_FILES['imagen']['name']);
        $ext = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $permitidas, true)) {
            $msg = "Formato de imagen no permitido.";
        } else {
            $imgFinal = uniqid("prod_", true) . "." . $ext;
            $rutaDestino = __DIR__ . "/img/" . $imgFinal;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                $rutaImagenDb = "img/" . $imgFinal;
                $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen, categoria_id, stock) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsii", $nombre, $precio, $rutaImagenDb, $categoria, $stock);
                if ($stmt->execute()) {
                    $msg = "Producto agregado correctamente.";
                } else {
                    $msg = "No se pudo guardar el producto.";
                }
                $stmt->close();
            } else {
                $msg = "No se pudo subir la imagen.";
            }
        }
    }
}

$sql = "SELECT 
u.usuario,
u.nombre,
u.apellido,
u.email,
p.nombre AS producto,
d.cantidad,
d.precio,
c.total,
c.fecha
FROM compras c
JOIN usuarios u ON c.usuario_id = u.id
JOIN detalle_compras d ON c.id = d.compra_id
JOIN productos p ON d.producto_id = p.id
ORDER BY c.fecha DESC";
$result = $conn->query($sql);
$productosGestion = $conn->query("SELECT id, nombre, precio, stock, categoria_id, imagen FROM productos ORDER BY id DESC");
?>
<?php include "navbar.php";?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f4f7ff 0%, #eef2ff 100%);
            min-height: 100vh;
        }
        .top-hero {
            background: #0b1f46;
            color: #fff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 10px 28px rgba(11, 31, 70, 0.2);
        }
        .admin-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(33, 37, 41, 0.08);
        }
        .admin-card .card-header {
            background: #fff;
            border-bottom: 1px solid #eef0f4;
            font-weight: 700;
        }
        .table thead th {
            background: #f7f9fc;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
            font-size: 0.92rem;
        }
        .tag-muted {
            font-size: 0.8rem;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.35);
            border-radius: 999px;
            padding: 4px 10px;
            display: inline-block;
        }
        .productos-scroll {
            max-height: 520px;
            overflow-y: auto;
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="top-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <div class="tag-muted mb-2">panel Admin</div>
                <h2 class="mb-1">Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?>
                <p class="mb-0 text-white-50">Centro de control para reportes de compras y gestión de productos.</p>
            </div>
            <a href="panel.php" class="btn btn-light btn-sm">Volver al inicio</a>
        </div>
    </div>

    <?php if ($msg !== ""): ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="card admin-card mb-4">
        <div class="card-header fw-bold">Reporte de compras con datos de clientes</div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total Compra</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['usuario']) ?></td>
                                <td><?= htmlspecialchars($row['nombre']) ?></td>
                                <td><?= htmlspecialchars($row['apellido']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['producto']) ?></td>
                                <td><?= (int)$row['cantidad'] ?></td>
                                <td>$<?= number_format((float)$row['precio'], 2) ?></td>
                                <td>$<?= number_format((float)$row['total'], 2) ?></td>
                                <td><?= htmlspecialchars($row['fecha']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center">Aún no hay compras registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card admin-card">
        <div class="card-header fw-bold">Agregar producto</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                </div>
                <div class="col-md-6">
                    <input type="number" name="categoria_id" class="form-control" placeholder="ID de categoría" required>
                </div>
                <div class="col-md-6">
                    <input type="file" name="imagen" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" name="add" class="btn btn-success">Guardar producto</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card admin-card mt-4">
        <div class="card-header fw-bold">Eliminar productos</div>
        <div class="card-body">
            <div class="productos-scroll">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($productosGestion && $productosGestion->num_rows > 0): ?>
                        <?php while ($prod = $productosGestion->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$prod['id'] ?></td>
                                <td>
                                    <?php if (!empty($prod['imagen'])): ?>
                                        <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="Producto" style="width:42px;height:42px;object-fit:cover;border-radius:8px;">
                                    <?php else: ?>
                                        <span class="text-muted">Sin imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                                <td>$<?= number_format((float)$prod['precio'], 2) ?></td>
                                <td><?= (int)$prod['stock'] ?></td>
                                <td><?= (int)$prod['categoria_id'] ?></td>
                                <td class="d-flex gap-2">
    <!-- BOTÓN EDITAR -->
<a href="editar_producto.php?id=<?= (int)$prod['id'] ?>" 
   class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
   style="width:36px; height:36px; border-radius:10px;">
    
    <i class="bi bi-pencil-square"></i>
</a>

    <!-- BOTÓN ELIMINAR (tu código original intacto) -->
    <form method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
        <input type="hidden" name="producto_id" value="<?= (int)$prod['id'] ?>">
        <button type="submit" name="delete_producto" class="btn btn-sm btn-outline-danger">
            Eliminar
        </button>
    </form>
</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">No hay productos para gestionar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

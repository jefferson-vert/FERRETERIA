<?php
include 'conexion.php';
session_start();



if (!isset($_SESSION['rol_id']) || (int)$_SESSION['rol_id'] !== 2) {
    header("Location: panel.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_panel.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$precio = (float)($_POST['precio'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);
$categoriaId = (int)($_POST['categoria_id'] ?? 0);

if ($nombre !== '' && $precio > 0 && $categoriaId > 0 && isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
    $img = uniqid("prod_", true) . "_" . basename($_FILES['img']['name']);
    move_uploaded_file($_FILES['img']['tmp_name'], "img/".$img);
    $rutaImagenDb = "img/" . $img;

    $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen, categoria_id, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsii", $nombre, $precio, $rutaImagenDb, $categoriaId, $stock);
    $stmt->execute();
    $stmt->close();
}

header("Location: admin_panel.php");
?>
<?php include "navbar.php"; ?>
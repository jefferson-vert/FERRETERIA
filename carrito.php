<?php
session_start();
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");

if ($conexion->connect_error) {
    echo json_encode(["success" => false, "msg" => "Error de conexión"]);
    exit;
}

$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$precio = (float)($_POST['precio'] ?? 0);
$cantidad = (int)($_POST['cantidad'] ?? 1);

if (!$id) {
    echo json_encode(["success" => false, "msg" => "ID inválido"]);
    exit;
}

// 🔥 OBTENER STOCK REAL
$result = $conexion->query("SELECT stock FROM productos WHERE id = $id");

if (!$result || $result->num_rows == 0) {
    echo json_encode(["success" => false, "msg" => "Producto no encontrado"]);
    exit;
}

$producto = $result->fetch_assoc();
$stockDisponible = (int)$producto['stock'];

// 🛒 CREAR CARRITO SI NO EXISTE
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// 🔥 CANTIDAD ACTUAL EN CARRITO
$cantidadActual = $_SESSION['carrito'][$id]['cantidad'] ?? 0;

// 🔴 VALIDACIÓN CLAVE
if ($cantidadActual + $cantidad > $stockDisponible) {
    echo json_encode([
        "success" => false,
        "msg" => "Stock insuficiente. Disponible: $stockDisponible",
        "stock" => $stockDisponible
    ]);
    exit;
}

// ✅ AGREGAR AL CARRITO
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = [
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];
}

// 🔥 CALCULAR TOTAL DEL CARRITO
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['cantidad'];
}

// 🔥 STOCK RESTANTE
$stockRestante = $stockDisponible - $_SESSION['carrito'][$id]['cantidad'];

echo json_encode([
    "success" => true,
    "cartCount" => $total,
    "stock" => $stockRestante
]);
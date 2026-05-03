<?php
session_start();

header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ferreteria";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Error de conexion']);
    exit;
}

$conn->set_charset("utf8");

if (!isset($_POST['producto_id'])) {
    echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
    exit;
}

$id = (int) $_POST['producto_id'];

$stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    exit;
}

$producto = $result->fetch_assoc();
$stock_actual = (int) $producto['stock'];

if ($stock_actual <= 0) {
    echo json_encode(['success' => false, 'error' => 'Sin stock', 'stock' => 0]);
    exit;
}

$stmt = $conn->prepare("UPDATE productos SET stock = stock - 1 WHERE id = ? AND stock > 0");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $nuevo_stock = $stock_actual - 1;
    
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    
    if (!isset($_SESSION['carrito'][$id])) {
        $stmt2 = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $prod = $stmt2->get_result()->fetch_assoc();
        
        $_SESSION['carrito'][$id] = [
            'id' => $id,
            'nombre' => $prod['nombre'],
            'precio' => $prod['precio'],
            'cantidad' => 1
        ];
        $stmt2->close();
    } else {
        $_SESSION['carrito'][$id]['cantidad']++;
    }
    
    echo json_encode([
        'success' => true,
        'stock' => $nuevo_stock,
        'carrito_count' => array_sum(array_column($_SESSION['carrito'], 'cantidad'))
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo actualizar', 'stock' => $stock_actual]);
}

$stmt->close();
$conn->close();

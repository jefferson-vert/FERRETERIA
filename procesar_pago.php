<?php
session_start();

$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");

if ($conexion->connect_error) {
    die("Error conexión");
}

// VALIDAR SESIÓN
if(!isset($_SESSION['user_id'])){
    die("NO HAY SESSION USER_ID");
}

$usuario_id = $_SESSION['user_id'];
$nombre = $_SESSION['nombre'] ?? 'Cliente';
$email  = $_SESSION['usuario_email'] ?? '';

// DATOS DEL FORM
$producto_id = (int)$_POST['producto_id'];
$cantidad = (int)$_POST['cantidad'];
$metodo_pago = $_POST['metodo_pago'] ?? '';

// PRODUCTO
$stmt = $conexion->prepare("SELECT nombre, precio, stock FROM productos WHERE id=?");
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$res = $stmt->get_result();
$p = $res->fetch_assoc();

if(!$p){
    die("Producto no existe");
}

if($p['stock'] < $cantidad){
    die("Stock insuficiente");
}

$precio = $p['precio'];
$total = $precio * $cantidad;

// 🔥 INSERT COMPRA
$stmt = $conexion->prepare("INSERT INTO compras (usuario_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();

$compra_id = $stmt->insert_id;

// 🔥 INSERT DETALLE
$stmt = $conexion->prepare("INSERT INTO detalle_compras (compra_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiid", $compra_id, $producto_id, $cantidad, $precio);
$stmt->execute();

// 🔥 UPDATE STOCK
$stmt = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id=?");
$stmt->bind_param("ii", $cantidad, $producto_id);
$stmt->execute();

// 🔥 FORMATO PRODUCTOS PARA N8N
$productos = [
    [
        'id' => $producto_id,
        'nombre' => $p['nombre'],
        'precio' => $precio,
        'cantidad' => $cantidad
    ]
];

// 🔥 DATOS TARJETA
$datos_tarjeta = [];

if($metodo_pago === 'Tarjeta'){
    $datos_tarjeta = [
        'nombre_tarjeta' => $_POST['nombre_tarjeta'] ?? '',
        'numero_tarjeta' => $_POST['numero_tarjeta'] ?? '',
        'expiracion' => $_POST['expiracion'] ?? '',
        'cvv' => $_POST['cvv'] ?? ''
    ];
}

// 🔥 DATA PARA N8N
$data = [
    'nombre' => $nombre,
    'email' => $email,
    'productos' => $productos,
    'total' => $total,
    'metodo_pago' => $metodo_pago,
    'datos_tarjeta' => $datos_tarjeta,
    'token' => 'miTokenSecreto123'
];

// 🔥 ENVIAR A N8N
$options = [
    'http' => [
        'header'  => "Content-Type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data),
    ]
];

$context = stream_context_create($options);

file_get_contents(
    "https://shafar.app.n8n.cloud/webhook/finalizar-compra",
    false,
    $context
);

// 🔥 REDIRECCIÓN FINAL
header("Location: compra_exitosa.php");
exit;
?>
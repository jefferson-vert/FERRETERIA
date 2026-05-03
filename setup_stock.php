<?php
$conn = new mysqli('localhost', 'root', '', 'ferreteria');
if ($conn->connect_error) {
    die('Error de conexion: ' . $conn->connect_error);
}

// Verificar si existe la tabla productos
$result = $conn->query("SHOW TABLES LIKE 'productos'");
if ($result->num_rows == 0) {
    echo "La tabla 'productos' no existe.\n";
    exit;
}

// Verificar si existe el campo stock
$result = $conn->query("DESCRIBE productos");
$campos = [];
while ($row = $result->fetch_assoc()) {
    $campos[] = $row['Field'];
}

echo "Campos actuales: " . implode(', ', $campos) . "\n";

if (!in_array('stock', $campos)) {
    // Agregar campo stock
    $conn->query("ALTER TABLE productos ADD COLUMN stock INT DEFAULT 0 AFTER precio");
    echo "Campo 'stock' agregado exitosamente.\n";
} else {
    echo "El campo 'stock' ya existe.\n";
}

// Verificar algunos productos
$result = $conn->query("SELECT id, nombre, stock FROM productos LIMIT 5");
echo "\nProductos (primeros 5):\n";
while ($row = $result->fetch_assoc()) {
    echo "- ID: {$row['id']}, Nombre: {$row['nombre']}, Stock: {$row['stock']}\n";
}

$conn->close();

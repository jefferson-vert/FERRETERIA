<?php 
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: panel.php");
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['auth_error'] = "Completa correo y contraseña.";
    header("Location: panel.php");
    exit();
}

// CONSULTA
$stmt = $conn->prepare("SELECT id, usuario, nombre, apellido, email, clave, rol_id, fecha_registro FROM usuarios WHERE email = ? LIMIT 1");

if (!$stmt) {
    $_SESSION['auth_error'] = "Error interno.";
    header("Location: panel.php");
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['auth_error'] = "Usuario no encontrado.";
    header("Location: panel.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// VALIDAR CONTRASEÑA
$claveGuardada = $user['clave'];
$passwordValida = false;

// Detectar si está encriptada
if (password_get_info($claveGuardada)['algo'] !== 0) {
    $passwordValida = password_verify($password, $claveGuardada);
} else {
    // Compatibilidad con contraseñas sin hash
    $passwordValida = ($password === $claveGuardada);
}

if (!$passwordValida) {
    $_SESSION['auth_error'] = "Contraseña incorrecta.";
    header("Location: panel.php");
    exit();
}

// ⚡ IMPORTANTE: GUARDAR COMO ARRAY LIMPIO
$_SESSION['user'] = [
    'id' => $user['id'],
    'usuario' => $user['usuario'],
    'nombre' => $user['nombre'],
    'apellido' => $user['apellido'],
    'email' => $user['email'],
    'rol_id' => $user['rol_id']
];

$_SESSION['rol_id'] = (int)$user['rol_id'];

unset($_SESSION['auth_error']);

// REDIRECCIÓN
if ($_SESSION['rol_id'] === 2) {
    header("Location: admin_panel.php");
    exit();
}

header("Location: panel.php");
exit();
?>
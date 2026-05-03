<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    header("Location: panel.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['foto'])) {
    header("Location: panel.php");
    exit();
}

$archivo = $_FILES['foto'];
if ($archivo['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['auth_error'] = "No se pudo subir la foto.";
    header("Location: panel.php");
    exit();
}

$ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
$permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

if (!in_array($ext, $permitidas, true)) {
    $_SESSION['auth_error'] = "Formato no permitido para foto de perfil.";
    header("Location: panel.php");
    exit();
}

if ($archivo['size'] > (3 * 1024 * 1024)) {
    $_SESSION['auth_error'] = "La foto no puede superar 3MB.";
    header("Location: panel.php");
    exit();
}

$dirPerfiles = __DIR__ . "/img/perfiles";
if (!is_dir($dirPerfiles)) {
    mkdir($dirPerfiles, 0777, true);
}

$userId = (int)$_SESSION['user']['id'];
foreach ($permitidas as $e) {
    $previa = $dirPerfiles . "/user_" . $userId . "." . $e;
    if (file_exists($previa)) {
        @unlink($previa);
    }
}

$destino = $dirPerfiles . "/user_" . $userId . "." . $ext;
if (!move_uploaded_file($archivo['tmp_name'], $destino)) {
    $_SESSION['auth_error'] = "No se pudo guardar la foto.";
}

header("Location: panel.php");
exit();
?>

<?php
session_start();
session_destroy();   // Borra la sesión

$volver = $_SERVER['HTTP_REFERER'] ?? 'panel.php';
header("Location: $volver");
exit;


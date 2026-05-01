<?php
session_start();

$conteo = 0;

if(isset($_SESSION['carrito'])){
    foreach($_SESSION['carrito'] as $item){
        $conteo += $item['cantidad'];
    }
}

echo json_encode(["conteo" => $conteo]);

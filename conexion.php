<?php
$host="localhost";
$user="root";
$pass="jefferson142008";
$db="ferreteria";

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    echo "Error de conexión";
}
?>

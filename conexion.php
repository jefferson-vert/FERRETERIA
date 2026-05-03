<?php
<<<<<<< HEAD
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ferreteria";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
=======
$host="localhost";
$user="root";
$pass="jefferson142008";
$db="ferreteria";

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    echo "Error de conexión";
}
>>>>>>> 7b1c71085b56f02a0453679365b833e69f090ddd
?>

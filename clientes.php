<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}
include "conexion.php";

/* Guardar cliente */
if(isset($_POST["guardar"])){
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];

    mysqli_query($conn,"INSERT INTO clientes(nombre,telefono) VALUES('$nombre','$telefono')");
}

/* Mostrar clientes */
$clientes = mysqli_query($conn,"SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html>
<head>
<title>Clientes</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
body{
    background:#f2f2f2;
    display:block;
}
.form{
    width:350px;
    background:white;
    padding:20px;
    margin:30px auto;
    border-radius:10px;
    box-shadow:0px 5px 15px rgba(0,0,0,0.2);
}
.form h3{
    text-align:center;
    margin-bottom:15px;
}
.form input{
    width:100%;
    padding:10px;
    margin-bottom:10px;
}
.tabla{
    width:80%;
    margin:20px auto;
    background:white;
    border-radius:10px;
    overflow:hidden;
}
.tabla th{
    background:#2c7be5;
    color:white;
    padding:12px;
}
.tabla td{
    padding:10px;
    text-align:center;
}
.boton{
    background:#00b894;
    color:white;
    border:none;
    padding:8px;
    width:100%;
    border-radius:5px;
}
</style>
</head>

<body>

<div class="form">
<h3>Registrar Cliente</h3>
<form method="POST">
<input type="text" name="nombre" placeholder="Nombre del cliente" required>
<input type="text" name="telefono" placeholder="Teléfono" required>
<button class="boton" name="guardar">Guardar</button>
</form>
</div>

<table class="tabla">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Teléfono</th>
</tr>

<?php
while($c = mysqli_fetch_array($clientes)){
    echo "<tr>";
    echo "<td>".$c["id"]."</td>";
    echo "<td>".$c["nombre"]."</td>";
    echo "<td>".$c["telefono"]."</td>";
    echo "</tr>";
}
?>

</table>

<p style="text-align:center;">
<a href="panel.php">Volver al panel</a>
</p>

</body>
</html>

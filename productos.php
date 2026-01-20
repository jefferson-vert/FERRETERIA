<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}

include "conexion.php";
$resultado = mysqli_query($conn,"SELECT * FROM productos");
?>

<!DOCTYPE html>
<html>
<head>
<title>Productos</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
body{
    background:#f2f2f2;
    display:block;
}

.tabla{
    width:80%;
    margin:30px auto;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0px 5px 15px rgba(0,0,0,0.2);
}

.tabla th{
    background:#2c7be5;
    color:white;
    padding:15px;
}

.tabla td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

.boton{
    padding:6px 12px;
    background:#00b894;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.boton:hover{
    background:#00997a;
}

.volver{
    display:block;
    text-align:center;
    margin-top:20px;
}
</style>
</head>

<body>

<h2 style="text-align:center;margin-top:20px;">Inventario de Productos</h2>

<table class="tabla">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Precio</th>
<th>Stock</th>
<th>Acción</th>
</tr>

<?php
while($row = mysqli_fetch_array($resultado)){
    echo "<tr>";
    echo "<td>".$row["id"]."</td>";
    echo "<td>".$row["nombre"]."</td>";
    echo "<td>RD$ ".$row["precio"]."</td>";
    echo "<td>".$row["stok"]."</td>";
    echo "<td><button class='boton'>Editar</button></td>";
    echo "</tr>";
}
?>

</table>

<a class="volver" href="panel.php">Volver al panel</a>

</body>
</html>

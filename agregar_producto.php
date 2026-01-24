<?php
include "conexion.php";

if(isset($_POST["guardar"])){
    $n=$_POST["nombre"];
    $p=$_POST["precio"];
    $s=$_POST["stock"];

    mysqli_query($conn,"INSERT INTO productos(nombre,precio,stock) VALUES('$n','$p','$s')");
    echo "Producto guardado";
}
?>

<form method="POST">
Nombre: <input type="text" name="nombre"><br>
Precio: <input type="number" name="precio"><br>
Stock: <input type="number" name="stok"><br>
<button name="guardar">Guardar</button>
</form>

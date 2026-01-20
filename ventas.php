<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}

include "conexion.php";

/* Guardar venta */
if(isset($_POST["vender"])){
    $cliente = $_POST["cliente"];
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];

    // Buscar precio y stock
    $prod = mysqli_query($conn,"SELECT * FROM productos WHERE id='$producto'");
    $p = mysqli_fetch_array($prod);

    if($cantidad > $p["stok"]){
        $msg = "No hay suficiente stock";
    } else {
        $total = $cantidad * $p["precio"];
        $fecha = date("Y-m-d");

        // Registrar venta
        mysqli_query($conn,"INSERT INTO ventas(cliente_id,fecha,total) VALUES('$cliente','$fecha','$total')");

        // Descontar stock
        mysqli_query($conn,"UPDATE productos SET stok = stok - $cantidad WHERE id='$producto'");

        $msg = "Venta realizada. Total: RD$ $total";
    }
}

/* Cargar clientes y productos */
$clientes = mysqli_query($conn,"SELECT * FROM clientes");
$productos = mysqli_query($conn,"SELECT * FROM productos");
?>

<!DOCTYPE html>
<html>
<head>
<title>Ventas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">
<div class="card shadow">
<div class="card-header bg-success text-white">
<h4>Registrar Venta</h4>
</div>

<div class="card-body">

<form method="POST" class="row g-3">

<div class="col-md-4">
<label>Cliente</label>
<select name="cliente" class="form-control" required>
<option value="">Seleccione</option>
<?php while($c=mysqli_fetch_array($clientes)){ ?>
<option value="<?php echo $c["id"]; ?>"><?php echo $c["nombre"]; ?></option>
<?php } ?>
</select>
</div>

<div class="col-md-4">
<label>Producto</label>
<select name="producto" class="form-control" required>
<option value="">Seleccione</option>
<?php while($p=mysqli_fetch_array($productos)){ ?>
<option value="<?php echo $p["id"]; ?>">
<?php echo $p["nombre"]; ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-4">
<label>Cantidad</label>
<input type="number" name="cantidad" class="form-control" required>
</div>

<div class="col-md-12">
<button class="btn btn-success w-100" name="vender">Registrar Venta</button>
</div>

</form>

<?php if(isset($msg)){ ?>
<div class="alert alert-info mt-3">
<?php echo $msg; ?>
</div>
<?php } ?>

<a href="panel.php" class="btn btn-secondary mt-3">Volver al panel</a>

</div>
</div>
</div>

</body>
</html>

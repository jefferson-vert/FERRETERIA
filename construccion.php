<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "ferreteria");
if ($conexion->connect_error) { die("Error de conexión: " . $conexion->connect_error); }

$sql = "SELECT * FROM productos WHERE categoria_id = 1";
$resultado = $conexion->query($sql);

$logueado = isset($_SESSION["user"]);
?>

<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Construcción</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background: #f4f4f4; }

.btn, .form-control, .card, .modal-content {
    border-radius: 0 !important;
}

.card-producto { border: none; transition: 0.3s; }
.card-producto:hover { transform: scale(1.03); }
.precio { color: #dc3545; font-weight: bold; font-size: 20px; }
img { height: 220px; object-fit: cover; }
#cart-count{
    border-radius: 50% !important;
    min-width: 20px;
    height: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    padding: 0;
}
</style>
</head>

<body>

<div class="container mt-5">
<h2 class="text-center mb-5">Construcción</h2>

<div class="row">

<?php while($fila = $resultado->fetch_assoc()) { ?>
<?php $sinStock = (int)$fila['stock'] <= 0; ?>

<div class="col-md-3 mb-4">
<div class="card card-producto shadow-sm">

<img src="<?php echo $fila['imagen']; ?>" class="card-img-top">

<div class="card-body text-center">

<h5><?php echo $fila['nombre']; ?></h5>
<p class="text-muted">Código: <?php echo $fila['id']; ?></p>
<p class="precio">RD$ <?php echo number_format($fila['precio'],2); ?></p>

<p class="stock-text <?php echo $sinStock ? 'text-danger fw-bold' : 'text-success fw-semibold'; ?>">
<?php echo $sinStock ? 'No disponible' : ('Stock: ' . (int)$fila['stock']); ?>
</p>

<?php if ($sinStock): ?>

<button class="btn btn-outline-secondary w-100 mb-2" disabled>Agregar al carrito</button>
<button class="btn btn-outline-secondary w-100" disabled>No disponible</button>

<?php else: ?>

<!-- 🛒 CARRITO -->
<button class="btn btn-outline-dark w-100 mb-2"
onclick="agregarCarrito(
<?php echo $fila['id']; ?>,
'<?php echo addslashes($fila['nombre']); ?>',
<?php echo $fila['precio']; ?>,
this
)">
Agregar al carrito
</button>

<!-- 🔐 COMPRA -->
<button class="btn btn-dark w-100"
onclick="validarCompra(this)"
data-id="<?php echo $fila['id']; ?>"
data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
data-precio="<?php echo $fila['precio']; ?>"
data-stock="<?php echo $fila['stock']; ?>">
<i class="bi bi-bag"></i> Comprar ahora
</button>

<?php endif; ?>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

<!-- 🔴 MODAL LOGIN -->
<div class="modal fade" id="modalLogin">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0">

<div class="modal-header bg-danger text-white">
<h5 class="modal-title">Acceso requerido</h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center">
<p class="fw-bold">Debes iniciar sesión para continuar</p>
<a href="login.php" class="btn btn-danger w-100">Iniciar sesión</a>
</div>

</div>
</div>
</div>

<!-- 💳 MODAL COMPRA -->
<div class="modal fade" id="modalPago">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Finalizar Compra</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="procesar_pago.php" method="POST">
<div class="modal-body">

<div class="d-flex justify-content-between mb-3">
<span id="modalNombre"></span>
<span class="text-success fw-bold">RD$<span id="modalPrecio"></span></span>
</div>

<input type="hidden" name="producto_id" id="modalId">
<input type="hidden" name="precio" id="modalPrecioInput">

<div class="mb-3">
<label>Cantidad</label>
<input type="number" name="cantidad" id="modalCantidad" class="form-control" value="1" min="1">
</div>

<h6>Método de pago</h6>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Tarjeta" required>
<label>Tarjeta</label>
</div>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Transferencia">
<label>Transferencia</label>
</div>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Contra Entrega">
<label>Contra Entrega</label>
</div>

<div id="formTarjeta" style="display:none;">
<input type="text" class="form-control mb-2 tarjetaCampo" name="nombre_tarjeta" placeholder="Nombre">
<input type="text" class="form-control mb-2 tarjetaCampo" name="numero_tarjeta" placeholder="Número">
<input type="text" class="form-control mb-2 tarjetaCampo" name="expiracion" placeholder="MM/AA">
<input type="text" class="form-control tarjetaCampo" name="cvv" placeholder="CVV">
</div>

</div>

<div class="modal-footer">
<button class="btn btn-dark w-100">Confirmar Pedido</button>
</div>

</form>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const logueado = <?= $logueado ? 'true' : 'false' ?>;

// 🔐 COMPRA
function validarCompra(btn){

if(!logueado){
new bootstrap.Modal(document.getElementById('modalLogin')).show();
return;
}

let modal = new bootstrap.Modal(document.getElementById('modalPago'));

document.getElementById('modalNombre').textContent = btn.dataset.nombre;
document.getElementById('modalPrecio').textContent = parseFloat(btn.dataset.precio).toFixed(2);

document.getElementById('modalId').value = btn.dataset.id;
document.getElementById('modalPrecioInput').value = btn.dataset.precio;

document.getElementById('modalCantidad').value = 1;
document.getElementById('modalCantidad').max = btn.dataset.stock;

modal.show();
}

// 🛒 CARRITO + BADGE ACTUALIZADO
function agregarCarrito(id,nombre,precio,btn){

fetch('carrito.php',{
method:'POST',
headers:{
'Content-Type':'application/x-www-form-urlencoded'
},
body:`id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}&cantidad=1`
})
.then(r=>r.json())
.then(data=>{

if(!data.success){
alert(data.msg || "Sin stock disponible");
return;
}

let stockText = btn.closest('.card-body').querySelector(".stock-text");

if(data.stock <= 0){
stockText.innerHTML="No disponible";
stockText.classList.add("text-danger");
btn.disabled=true;
}else{
stockText.innerHTML="Stock: "+data.stock;
}

// ✅ ACTUALIZAR BADGE DEL CARRITO
let cart = document.getElementById("cart-count");
if(cart){
cart.innerText = data.cartCount;
cart.style.display = "inline-block";
cart.classList.add("bump");
setTimeout(()=>cart.classList.remove("bump"),200);
}

});
}

// TARJETA
document.querySelectorAll('.metodoPago').forEach(r=>{
r.addEventListener('change',()=>{
document.getElementById('formTarjeta').style.display =
r.value==='Tarjeta' ? 'block' : 'none';
});
});
</script>

</body>
</html>
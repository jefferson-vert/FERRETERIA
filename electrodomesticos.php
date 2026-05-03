<?php
$conexion = new mysqli("localhost", "root", "", "ferreteria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM productos WHERE categoria_id = 8";
$resultado = $conexion->query($sql);
?>

<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Electrodomésticos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background: #f4f4f4; }

.card-producto {
    border: none;
    border-radius: 0;
    transition: 0.3s;
}

.card-producto:hover {
    transform: scale(1.03);
}

.precio {
    color: #198754;
    font-weight: bold;
    font-size: 20px;
}

img {
    height: 220px;
    object-fit: cover;
}

.btn {
    border-radius: 0 !important;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container mt-5">
<h2 class="text-center mb-5">Electrodomésticos</h2>

<div class="row">

<?php while($fila = $resultado->fetch_assoc()) { ?>
<?php $sinStock = (int)$fila['stock'] <= 0; ?>

<div class="col-md-3 mb-4">
<div class="card card-producto shadow-sm">

<img src="<?php echo htmlspecialchars($fila['imagen']); ?>">

<div class="card-body text-center">

<h5><?php echo htmlspecialchars($fila['nombre']); ?></h5>
<p class="text-muted">Código: <?php echo $fila['id']; ?></p>

<p class="precio">RD$ <?php echo number_format($fila['precio'],2); ?></p>

<p class="stock-text <?php echo $sinStock ? 'text-danger fw-bold' : 'text-success fw-semibold'; ?>">
<?php echo $sinStock ? 'No disponible' : ('Stock: ' . (int)$fila['stock']); ?>
</p>

<?php if ($sinStock): ?>

<button class="btn btn-outline-secondary w-100 mb-2" disabled>Agregar al carrito</button>
<button class="btn btn-outline-secondary w-100" disabled>No disponible</button>

<?php else: ?>

<button class="btn btn-outline-dark w-100 mb-2"
onclick="agregarCarrito(
<?php echo $fila['id']; ?>,
'<?php echo addslashes($fila['nombre']); ?>',
<?php echo $fila['precio']; ?>,
this
)">
Agregar al carrito
</button>

<button class="btn btn-dark w-100"
data-bs-toggle="modal"
data-bs-target="#modalPago"
data-id="<?php echo $fila['id']; ?>"
data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
data-precio="<?php echo $fila['precio']; ?>">
<i class="bi bi-bag"></i> Comprar Ahora
</button>

<?php endif; ?>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPago" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border">

<div class="modal-header">
<h5 class="modal-title fw-bold">Finalizar Compra</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="procesar_pago.php" method="POST">
<div class="modal-body">

<div class="border p-3 mb-4">
<div class="d-flex justify-content-between">
<span id="modalNombre"></span>
<span class="fw-bold text-success">RD$ <span id="modalPrecio"></span></span>
</div>
</div>

<input type="hidden" name="producto_id" id="modalId">
<input type="hidden" name="precio" id="modalPrecioInput">

<h6 class="fw-bold mb-3">Método de pago</h6>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Tarjeta" required>
<label class="form-check-label">Tarjeta</label>
</div>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Transferencia">
<label class="form-check-label">Transferencia</label>
</div>

<div class="form-check">
<input class="form-check-input metodoPago" type="radio" name="metodo_pago" value="Contra Entrega">
<label class="form-check-label">Contra Entrega</label>
</div>

<div id="formTarjeta" style="display:none;" class="mt-3">
<input type="text" class="form-control mb-2 tarjetaCampo" name="nombre_tarjeta" placeholder="Nombre en tarjeta">
<input type="text" class="form-control mb-2 tarjetaCampo" name="numero_tarjeta" placeholder="Número">
<input type="text" class="form-control mb-2 tarjetaCampo" name="expiracion" placeholder="MM/AA">
<input type="text" class="form-control tarjetaCampo" name="cvv" placeholder="CVV">
</div>

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-dark w-100">Confirmar Pedido</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// 🛒 CARRITO (UNA SOLA FUNCIÓN)
function agregarCarrito(id, nombre, precio, btn) {

fetch('carrito.php', {
method: 'POST',
headers: {
'Content-Type': 'application/x-www-form-urlencoded'
},
body: `id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}&cantidad=1`
})

.then(res => res.json())
.then(data => {

if (!data.success) {
alert(data.msg || "Sin stock disponible");
return;
}

// contador carrito
let cart = document.getElementById("cart-count");
if (cart) cart.innerText = data.cartCount;

if (data.cartCount > 0) {
        cart.style.display = "inline-block";
    } else {
        cart.style.display = "none";
    }

// stock dinámico
let stockText = btn.parentElement.querySelector(".stock-text");

if (stockText) {
if (data.stock <= 0) {
stockText.innerHTML = "No disponible";
stockText.classList.add("text-danger");
btn.disabled = true;
} else {
stockText.innerHTML = "Stock: " + data.stock;
}
}

});

}

// MODAL
const modalPago = document.getElementById('modalPago');

modalPago.addEventListener('show.bs.modal', function (event) {
const button = event.relatedTarget;

document.getElementById('modalNombre').textContent =
button.getAttribute('data-nombre');

document.getElementById('modalPrecio').textContent =
parseFloat(button.getAttribute('data-precio')).toFixed(2);

document.getElementById('modalId').value =
button.getAttribute('data-id');

document.getElementById('modalPrecioInput').value =
button.getAttribute('data-precio');
});

// TARJETA
document.querySelectorAll('.metodoPago').forEach(radio => {
radio.addEventListener('change', function () {
document.getElementById('formTarjeta').style.display =
this.value === 'Tarjeta' ? 'block' : 'none';
});
});
</script>

</body>
</html>
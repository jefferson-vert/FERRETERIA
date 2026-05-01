<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Más Vendidos | Ferretería</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- 🔥 CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body { background-color: #f8f9fa; }
* { border-radius: 0 !important; }

.titulo { font-weight: bold; margin: 30px 0; }

.card { border: 1px solid #e5e5e5; transition: .3s; }
.card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.05); }

.card img {
height: 200px;
object-fit: contain;
padding: 15px;
}

.precio {
font-size: 1.2rem;
color: #198754;
font-weight: bold;
}

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

/* 🔥 GRAFICO ARRIBA IZQUIERDA (SEPARADO) */


.chart-box canvas{
    background: white;
    padding: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

<?php
session_start();
$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");
if ($conexion->connect_error) { die("Error de conexión"); }

include("navbar.php");
?>

<!-- 🔥 GRAFICO (NO INTERFIERE CON LAS CARDS) -->
<!-- 🔥 HERO CON GRAFICO (ESTILO OFERTAS) -->
<div class="container mt-4">
<div class="row align-items-center bg-white p-4">

    <!-- 📊 GRAFICO (IZQUIERDA) -->
    <div class="col-md-6">
        <canvas id="graficoVentas" style="max-height:300px;"></canvas>
    </div>

    <!-- 📝 TEXTO (DERECHA) -->
    <div class="col-md-6">

        <div class="border p-2 mb-2 small text-muted">
            Productos más vendidos
        </div>

        <h2 class="fw-bold">Los favoritos de nuestros clientes</h2>

        <p class="text-muted">
            Estos son los productos más comprados. Calidad, confianza y
            excelente rendimiento en cada compra.
        </p>

    </div>

</div>
</div>

<div class="container">
<h2 class="text-center titulo">Productos Más Vendidos</h2>

<div class="row g-4">

<?php
$resultado = $conexion->query("
SELECT * 
FROM productos 
WHERE categoria_id IN (7,8,3,5)
ORDER BY id DESC
LIMIT 8
");

while ($producto = $resultado->fetch_assoc()):

$nombre = htmlspecialchars($producto['nombre']);
$imagen = htmlspecialchars($producto['imagen']);
$precio = number_format($producto['precio'], 2);
$stock = (int)$producto['stock'];
$sinStock = $stock <= 0;
$codigo = htmlspecialchars($producto['codigo'] ?? $producto['id']);
?>

<div class="col-md-3 col-sm-6">
<div class="card h-100">

<img src="<?= $imagen ?>">

<div class="card-body text-center">

<h5><?= $nombre ?></h5>

<p class="text-muted small">Código: <?= $codigo ?></p>

<p class="precio">RD$<?= $precio ?></p>

<p class="stock-text <?= $sinStock ? 'text-danger fw-bold' : 'text-success fw-semibold' ?>">
<?= $sinStock ? 'No disponible' : ('Stock: ' . $stock) ?>
</p>

<?php if ($sinStock): ?>

<button class="btn btn-outline-secondary w-100 mb-2" disabled>Agregar</button>
<button class="btn btn-secondary w-100" disabled>No disponible</button>

<?php else: ?>

<!-- 🛒 AGREGAR AL CARRITO -->
<button class="btn btn-outline-dark w-100 mb-2"
onclick="agregarCarrito(<?= $producto['id'] ?>,'<?= $nombre ?>',<?= $producto['precio'] ?>,this)">
Agregar al carrito
</button>

<!-- 💳 COMPRAR -->
<button class="btn btn-dark w-100"
onclick="verificarLogin(this)"
data-id="<?= $producto['id'] ?>"
data-nombre="<?= $nombre ?>"
data-precio="<?= $producto['precio'] ?>">
Comprar Ahora
</button>

<?php endif; ?>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
</div>

<!-- 🔴 MODAL LOGIN -->
<div class="modal fade" id="modalLogin" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-danger">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Acceso requerido</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="fw-bold text-danger mb-2">Debes iniciar sesión para comprar</p>
        <p class="text-muted small">Inicia sesión para continuar con tu compra.</p>
      </div>

      <div class="modal-footer">
        <a href="login.php" class="btn btn-danger w-100">Ir a iniciar sesión</a>
      </div>

    </div>
  </div>
</div>

<!-- MODAL COMPRA -->
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
<small id="stockDisponible"></small>
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

<?php include("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

// 🔥 GRAFICO CIRCULAR
const ctx = document.getElementById('graficoVentas');

new Chart(ctx, {
type: 'pie',
data: {
labels: ['Horno eléctrico', 'Secadora', 'Lavadora', 'Calentador', 'Ventilador','Extractor','Cafetera','Tostadora'],
datasets: [{
data: [12, 19, 8, 15, 10,20,30,24]
}]
},
options: {
responsive: true,
plugins: {
legend: {
position: 'bottom'
}
},
animation: {
animateScale: true,
animateRotate: true
}
}
});

// LOGIN
function verificarLogin(btn){

let logueado = <?php echo isset($_SESSION["user"]) ? 'true' : 'false'; ?>;

if(!logueado){
new bootstrap.Modal(document.getElementById('modalLogin')).show();
return;
}

let modalPago = new bootstrap.Modal(document.getElementById('modalPago'));

document.getElementById('modalNombre').textContent = btn.dataset.nombre;
document.getElementById('modalPrecio').textContent = parseFloat(btn.dataset.precio).toFixed(2);
document.getElementById('modalId').value = btn.dataset.id;
document.getElementById('modalPrecioInput').value = btn.dataset.precio;

modalPago.show();
}

// 🛒 CARRITO + BADGE
function agregarCarrito(id,nombre,precio,btn){

fetch('carrito.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}&cantidad=1`
})
.then(r=>r.json())
.then(data=>{

if(!data.success){
alert("Sin stock");
return;
}

let stockText = btn.closest('.card-body').querySelector(".stock-text");

if(data.stock <= 0){
stockText.innerHTML="No disponible";
btn.disabled=true;
}else{
stockText.innerHTML="Stock: "+data.stock;
}

let cart = document.getElementById("cart-count");

if(cart){
cart.innerText = data.cartCount;

if(data.cartCount > 0){
cart.style.display = "inline-block";
}else{
cart.style.display = "none";
}
}

});
}

// 💳 MÉTODO DE PAGO
document.querySelectorAll('.metodoPago').forEach(r => {
r.addEventListener('change', () => {

let formTarjeta = document.getElementById('formTarjeta');

if (r.value === 'Tarjeta') {
formTarjeta.style.display = 'block';
} else {
formTarjeta.style.display = 'none';

document.querySelectorAll('.tarjetaCampo').forEach(input => {
input.value = '';
});
}
});
});

</script>

</body>
</html>
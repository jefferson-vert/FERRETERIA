<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Básicos | Ferretería</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
        .titulo { margin: 30px 0; font-weight: bold; }
        .card { border: none; transform: translateY(10px); transition: .4s; }
        .card.show { transform: translateY(0); }
        .card img { height: 180px; object-fit: contain; padding: 15px; }
        .precio { font-size: 1.1rem; font-weight: bold; color: #0d6efd; }
        .btn { border-radius: 0 !important; font-weight: bold; }
        .banner-img { opacity: 0; transform: scale(0.95); transition: 1s; }
        .banner-img.show { opacity: 1; transform: scale(1); }
        .banner-badge { border: 1px solid #000; padding: 6px 12px; font-size: 0.85rem; }
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

<?php
session_start();

$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");
if ($conexion->connect_error) {
    die("Error de conexión");
}

include "navbar.php";

$logueado = isset($_SESSION["user"]);
?>

<!-- BANNER -->
<div class="container my-5">
    <div class="row align-items-center g-5">
        <div class="col-md-6">
            <img src="img/destacado.png" class="img-fluid banner-img">
        </div>
        <div class="col-md-6">
            <div class="banner-badge">Productos esenciales</div>
            <h2 class="fw-bold">Destaca en tu proyecto</h2>
            <p>Artículos indispensables para trabajos de mantenimiento, instalación y uso diario.</p>
        </div>
    </div>
</div>

<div class="container">
<h2 class="text-center titulo">Productos Básicos</h2>

<div class="row g-4">

<?php
$resultado = $conexion->query("SELECT * FROM productos ORDER BY RAND() LIMIT 8");

while ($producto = $resultado->fetch_assoc()):

$nombre = htmlspecialchars($producto['nombre']);
$codigo = htmlspecialchars($producto['codigo'] ?? $producto['id']);
$imagen = htmlspecialchars($producto['imagen']);
$precio = number_format($producto['precio'], 2);
$stock = (int)($producto['stock'] ?? 0);
$sinStock = $stock <= 0;
?>

<div class="col-md-3 col-sm-6">
<div class="card h-100 fade">

<img src="<?= $imagen ?>" class="card-img-top">

<div class="card-body text-center">
<h5 class="card-title"><?= $nombre ?></h5>
<p class="card-text">Código: <?= $codigo ?></p>
<p class="precio">$<?= $precio ?></p>

<p class="stock-text <?= $sinStock ? 'text-danger fw-bold' : 'text-success fw-semibold' ?>">
<?= $sinStock ? 'No disponible' : 'Stock: ' . $stock ?>
</p>

<?php if ($sinStock): ?>

<button class="btn btn-outline-secondary btn-sm w-100 mb-2" disabled>
Agregar al carrito
</button>

<button class="btn btn-outline-secondary btn-sm w-100" disabled>
No disponible
</button>

<?php else: ?>

<!-- 🛒 CARRITO -->
<button class="btn btn-outline-dark btn-sm w-100 mb-2"
onclick="agregarCarrito(<?= $producto['id'] ?>,'<?= $nombre ?>',<?= $producto['precio'] ?>,this)">
Agregar al carrito
</button>

<!-- 💳 COMPRAR -->
<?php if($logueado): ?>

<button class="btn btn-dark btn-sm w-100"
data-bs-toggle="modal"
data-bs-target="#modalPago"
data-id="<?= $producto['id'] ?>"
data-nombre="<?= $nombre ?>"
data-precio="<?= $producto['precio'] ?>"
data-stock="<?= $stock ?>">
<i class="bi bi-bag"></i> Comprar Ahora
</button>

<?php else: ?>

<button class="btn btn-dark btn-sm w-100"
data-bs-toggle="modal"
data-bs-target="#modalLogin">
<i class="bi bi-bag"></i> Comprar Ahora
</button>

<?php endif; ?>

<?php endif; ?>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
</div>

<!-- 🔴 MODAL LOGIN -->
<div class="modal fade" id="modalLogin">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-0 border-0">

      <div class="modal-header bg-danger text-white border-0">
        <h5 class="modal-title fw-bold">Acceso requerido</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center bg-light">
        <p class="fw-bold text-danger mb-2">
          Debes iniciar sesión para comprar
        </p>

        <p class="text-muted small mb-4">
          Inicia sesión para continuar con tu compra.
        </p>

        <a href="login.php" class="btn btn-danger w-100 fw-semibold">
          Ir a iniciar sesión
        </a>
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

// animación
window.addEventListener("load", () => {
document.querySelectorAll(".card.fade").forEach((card,i)=>{
setTimeout(()=>card.classList.add("show"),i*120);
});
document.querySelector(".banner-img")?.classList.add("show");
});

// 🛒 FUNCIÓN CARRITO + BADGE FIX
function agregarCarrito(id,nombre,precio,btn){

fetch('carrito.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}&cantidad=1`
})
.then(r=>r.json())
.then(data=>{

if(!data.success){
alert("Sin stock disponible");
return;
}

// stock
let stockText = btn.closest('.card-body').querySelector(".stock-text");

if(data.stock <= 0){
stockText.innerHTML="No disponible";
btn.disabled=true;
}else{
stockText.innerHTML="Stock: "+data.stock;
}

// 🔥 BADGE FIX
let cart = document.getElementById("cart-count");

if(cart){
cart.innerText = data.cartCount;

if(data.cartCount > 0){
    cart.style.display = "inline-block";
}else{
    cart.style.display = "none";
}

cart.classList.add("bump");
setTimeout(()=>cart.classList.remove("bump"),200);
}

});
}

// MODAL
const modal = document.getElementById('modalPago');

modal.addEventListener('show.bs.modal', e=>{
let btn = e.relatedTarget;
let stock = parseInt(btn.getAttribute('data-stock'));

document.getElementById('modalNombre').textContent = btn.dataset.nombre;
document.getElementById('modalPrecio').textContent = parseFloat(btn.dataset.precio).toFixed(2);
document.getElementById('modalId').value = btn.dataset.id;
document.getElementById('modalPrecioInput').value = btn.dataset.precio;

let input = document.getElementById('modalCantidad');
input.value = 1;
input.max = stock;

document.getElementById('stockDisponible').innerText = "Disponible: " + stock;
});

document.querySelectorAll('.metodoPago').forEach(r=>{
r.addEventListener('change',()=>{
document.getElementById('formTarjeta').style.display =
r.value==='Tarjeta' ? 'block' : 'none';
});
});

</script>

</body>
</html>
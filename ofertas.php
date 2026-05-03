<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ofertas | Ferretería</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background-color: #f8f9fa; }
.titulo { margin: 30px 0; font-weight: bold; }

.btn,
.card,
.modal-content,
.form-control,
.form-check-input {
    border-radius: 0 !important;
}

.card { border: none; transition: .3s; }
.card:hover { transform: translateY(-3px); }

.card img {
    height: 200px;
    object-fit: contain;
    padding: 15px;
}

.precio-oferta {
    font-size: 1.3rem;
    font-weight: bold;
    color: #dc3545;
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
.hero-img{
    max-height: 300px;
    object-fit: contain;
}
</style>
</head>

<body>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ferreteria");
include("navbar.php");
?>

<!-- 🔥 HERO OFERTAS -->
<div class="container mt-4">
<div class="row align-items-center bg-white p-4">

    <!-- 🖼️ IMAGEN -->
    <div class="col-md-6 text-center">
        <img src="img/ofertas.png" class="img-fluid hero-img">
    </div>

    <!-- 📝 TEXTO -->
    <div class="col-md-6">

        <div class="border p-2 mb-2 small text-muted">
            Ofertas especiales
        </div>

        <h2 class="fw-bold">Aprovecha nuestras ofertas</h2>

        <p class="text-muted">
            Encuentra productos a precios increíbles por tiempo limitado.
            Calidad garantizada al mejor precio.
        </p>

    </div>

</div>
</div>

<div class="container">
<h2 class="text-center titulo">Ofertas Especiales</h2>

<div class="row g-4">

<?php
$result = $conn->query("SELECT * FROM productos ORDER BY RAND() LIMIT 8");

while ($p = $result->fetch_assoc()):

$nombre = htmlspecialchars($p['nombre']);
$img = htmlspecialchars($p['imagen']);
$precio = $p['precio'];
$stock = (int)$p['stock'];
$sinStock = $stock <= 0;

// ✅ NUEVO (código del producto)
$codigo = htmlspecialchars($p['codigo'] ?? $p['id']);
?>

<div class="col-md-3 col-sm-6">
<div class="card h-100">

<img src="<?= $img ?>">

<div class="card-body text-center">

<h5><?= $nombre ?></h5>

<!-- ✅ CÓDIGO -->
<p class="text-muted small">Código: <?= $codigo ?></p>

<p class="precio-oferta">RD$<?= number_format($precio,2) ?></p>

<p class="stock-text <?= $sinStock ? 'text-danger fw-bold' : 'text-success' ?>">
<?= $sinStock ? 'No disponible' : 'Stock: '.$stock ?>
</p>

<?php if ($sinStock): ?>

<button class="btn btn-secondary w-100 mb-2" disabled>Agregar al carrito</button>
<button class="btn btn-secondary w-100" disabled>Comprar ahora</button>

<?php else: ?>

<button class="btn btn-outline-dark w-100 mb-2"
onclick="agregarCarrito(
<?= $p['id'] ?>,
'<?= $nombre ?>',
<?= $precio ?>,
this
)">
Agregar al carrito
</button>

<button class="btn btn-dark w-100"
onclick="verificarLogin(this)"
data-id="<?= $p['id'] ?>"
data-nombre="<?= $nombre ?>"
data-precio="<?= $precio ?>">
Comprar ahora
</button>

<?php endif; ?>

</div>
</div>
</div>

<?php endwhile; ?>

</div>
</div>

<?php include("footer.php"); ?>

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

<!-- 🛒 MODAL COMPRA -->
<div class="modal fade" id="modalPago" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title fw-bold">Finalizar Compra</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="procesar_pago.php" method="POST">
<div class="modal-body">

<div class="border p-3 mb-3 d-flex justify-content-between">
<span id="modalNombre"></span>
<span class="fw-bold text-success">RD$ <span id="modalPrecio"></span></span>
</div>

<input type="hidden" name="producto_id" id="modalId">
<input type="hidden" name="precio" id="modalPrecioInput">

<div class="mb-3">
<label class="fw-bold">Cantidad</label>
<input type="number" name="cantidad" id="modalCantidad" class="form-control" value="1" min="1">
</div>

<h6 class="fw-bold">Método de pago</h6>

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
<button type="submit" class="btn btn-dark w-100">Confirmar Pedido</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

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

// 🛒 CARRITO + BADGE FIX
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

// stock UI
let stockText = btn.closest('.card-body').querySelector(".stock-text");

if(data.stock <= 0){
stockText.innerHTML="No disponible";
btn.disabled=true;
}else{
stockText.innerHTML="Stock: "+data.stock;
}

// 🔥 BADGE UPDATE (AQUÍ ESTÁ EL FIX)
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
// 💳 MÉTODO DE PAGO (RESTAURADO)
document.querySelectorAll('.metodoPago').forEach(r => {
    r.addEventListener('change', () => {

        let formTarjeta = document.getElementById('formTarjeta');

        if (r.value === 'Tarjeta') {
            formTarjeta.style.display = 'block';
        } else {
            formTarjeta.style.display = 'none';

            // opcional: limpiar campos cuando no es tarjeta
            document.querySelectorAll('.tarjetaCampo').forEach(input => {
                input.value = '';
            });
        }
    });
});
</script>

</body>
</html>
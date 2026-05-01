<?php
session_start();

/* CONEXIÓN */
$conexion = new mysqli("localhost", "root", "jefferson142008", "ferreteria");
if ($conexion->connect_error) {
    die("Error de conexión");
}

$logueado = isset($_SESSION["user"]);

/* BUSCADOR AJAX */
if (isset($_GET['action']) && $_GET['action'] === 'search') {
    $q = $_GET['q'] ?? '';

    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$q%'";
    $res = $conexion->query($sql);

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/* CARRITO */
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = intval($_POST['id']);

    $sql = "SELECT * FROM productos WHERE id=$id";
    $res = $conexion->query($sql);
    $p = $res->fetch_assoc();

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if ($p) {
        if (!isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] = [
                'nombre' => $p['nombre'],
                'precio' => $p['precio'],
                'cantidad' => 1
            ];
        } else {
            $_SESSION['carrito'][$id]['cantidad']++;
        }
    }

    $count = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $count += $item['cantidad'];
    }

    echo json_encode(["success" => true, "cartCount" => $count]);
    exit;
}

/* PRODUCTOS */
$busqueda = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';

$sql = "SELECT * FROM productos WHERE 1";

if (!empty($busqueda)) {
    $sql .= " AND nombre LIKE '%$busqueda%'";
}

if (!empty($categoria)) {
    $sql .= " AND categoria_id = $categoria";
}

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Catálogo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
.producto-grid{
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columnas fijas */
    gap: 30px;
}


.producto-card{
    background:#fff;
    padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    text-align:center;
    transition:0.3s;
}

.producto-card:hover{
    transform:translateY(-5px);
}

.producto-card img{
    height:200px;
    width:100%;
    object-fit:contain;
    margin-bottom:10px;
}

/* NOMBRE PRODUCTO */
.producto-card h6{
    font-size:18px;
    font-weight:500;
    margin-top:10px;
}

/* CODIGO */
.codigo{
    font-size:13px;
    color:#666;
    margin-bottom:10px;
}

/* PRECIO */
.precio{
    color:#e60023;
    font-weight:bold;
    font-size:22px;
    margin:10px 0;
}

/* STOCK */
.stock{
    color:#1a9c3c;
    font-size:14px;
    margin-bottom:15px;
}

/* BOTONES */
.btn-carrito,
.btn-comprar{
    width:100%;
    padding:10px;
    font-size:15px;
    margin-top:8px;
    border-radius: 0 !important;
}

/* BOTON BLANCO */
.btn-carrito{
    background:#fff !important;
    color:#000 !important;
    border:1px solid #000 !important;
}

/* BOTON NEGRO */
.btn-comprar{
    background:#212529;
    color:#fff;
    border:none;
}

/* ESTILO NORMAL YA LO TIENES */

/* CUANDO NO HAY STOCK */
.sin-stock .btn{
    border-radius: 0 !important;
    background: #e0e0e0 !important;
    color: #888 !important;
    border: 1px solid #ccc !important;
    cursor: not-allowed;
}

/* TEXTO ROJO */
.sin-stock .stock{
    color: red !important;
    font-weight: bold;
}

#buscar{
    border-radius: 0 !important;
    height: 50px;
    font-size: 16px;
    border: 2px solid #000;
}

#buscar:focus{
    box-shadow: none;
    border-color: #000;
}

</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container mt-4">

<div class="row mb-4 justify-content-center">
    <div class="col-md-10 col-lg-8">
        <input type="text" id="buscar" class="form-control" placeholder="Buscar producto...">
    </div>
</div>



<div class="producto-grid" id="contenedor">

<?php while($p = $resultado->fetch_assoc()): ?>
<?php $stock = (int)$p['stock']; $sinStock = $stock <= 0; ?>

<div class="producto-card <?= $sinStock ? 'sin-stock' : '' ?>">

    <img src="<?= $p['imagen'] ?>">

    <h6><?= $p['nombre'] ?></h6>
    <div class="codigo">Código: <?= $p['id'] ?></div>

    <div class="precio">RD$<?= $p['precio'] ?></div>
    <div class="stock"><?= $sinStock ? 'No disponible' : 'Stock: '.$stock ?></div>

    <?php if(!$sinStock): ?>

    <button class="btn btn-carrito"
        onclick="agregarCarrito(<?= $p['id'] ?>,'<?= addslashes($p['nombre']) ?>',<?= $p['precio'] ?>,this)">
        Agregar al carrito
    </button>

    <button class="btn btn-comprar"
        onclick="validarCompra(this)"
        data-id="<?= $p['id'] ?>"
        data-nombre="<?= $p['nombre'] ?>"
        data-precio="<?= $p['precio'] ?>"
        data-stock="<?= $stock ?>">
        Comprar Ahora
    </button>

    <?php else: ?>

    <button class="btn btn-secondary w-100 mb-2" disabled>Agregar al carrito</button>
    <button class="btn btn-secondary w-100" disabled>No disponible</button>

    <?php endif; ?>

</div>

<?php endwhile; ?>

</div>
</div>

<!-- MODAL LOGIN -->
<div class="modal fade" id="modalLogin">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
<h5>Acceso requerido</h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<p>Debes iniciar sesión</p>
<a href="login.php" class="btn btn-danger w-100">Iniciar sesión</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const logueado = <?= $logueado ? 'true' : 'false' ?>;

/* BUSCADOR */
document.getElementById('buscar').addEventListener('keyup', function () {
    let q = this.value;

    fetch('?action=search&q=' + encodeURIComponent(q))
    .then(res => res.json())
    .then(data => {
        let cont = document.getElementById('contenedor');
        cont.innerHTML = '';

        data.forEach(p => {
            cont.innerHTML += `
            <div class="producto-card">
                <img src="${p.imagen}">
                <h6>${p.nombre}</h6>
                <div class="codigo">Código: ${p.id}</div>
                <div class="precio">RD$${p.precio}</div>
                <div class="stock">Stock: ${p.stock}</div>

                <button class="btn btn-carrito" onclick="agregarCarrito(${p.id},'${p.nombre}',${p.precio},this)">
                    Agregar al carrito
                </button>

                <button class="btn btn-comprar" onclick="validarCompra(this)"
                    data-id="${p.id}"
                    data-nombre="${p.nombre}"
                    data-precio="${p.precio}"
                    data-stock="${p.stock}">
                    Comprar
                </button>
            </div>`;
        });
    });
});

/* RESTAURADO MODAL COMPRA */
function validarCompra(btn){

if(!logueado){
    new bootstrap.Modal(document.getElementById('modalLogin')).show();
    return;
}

let modal = new bootstrap.Modal(document.getElementById('modalPago'));

document.getElementById('modalNombre').innerText = btn.dataset.nombre;
document.getElementById('modalPrecio').innerText = parseFloat(btn.dataset.precio).toFixed(2);

document.getElementById('modalId').value = btn.dataset.id;
document.getElementById('modalPrecioInput').value = btn.dataset.precio;

document.getElementById('modalCantidad').value = 1;
document.getElementById('modalCantidad').max = btn.dataset.stock;

document.getElementById('stockDisponible').innerText = "Disponible: " + btn.dataset.stock;

modal.show();
}

function agregarCarrito(id,nombre,precio,btn){

    fetch('',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=add&id=${id}`
    })
    .then(r=>r.json())
    .then(data=>{

        let badge = document.getElementById('cart-count');

        if(badge){
            badge.innerText = data.cartCount;
            badge.style.display = data.cartCount > 0 ? "inline-block" : "none";
        }

        // 🔥 ACTUALIZAR STOCK VISUALMENTE
        let card = btn.closest('.producto-card');
        let stockDiv = card.querySelector('.stock');

        let texto = stockDiv.innerText;

        if(texto.includes('Stock:')){
            let numero = parseInt(texto.replace('Stock:','').trim());

            if(numero > 0){
                numero--;

                if(numero <= 0){
                    stockDiv.innerText = "No disponible";
                    stockDiv.style.color = "red";

                    // Desactivar botones
                    card.classList.add('sin-stock');

                    let botones = card.querySelectorAll('button');
                    botones.forEach(b => b.disabled = true);
                }else{
                    stockDiv.innerText = "Stock: " + numero;
                }
            }
        }

    });
}
</script>

</body>
</html>

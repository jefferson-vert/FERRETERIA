<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "ferreteria");
if ($conexion->connect_error) {
    die("Error de conexión");
}

/* =========================
   BUSCADOR AJAX
   ========================= */
if (isset($_GET['ajax'])) {
    $buscar = $conexion->real_escape_string($_GET['buscar'] ?? '');
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$buscar%'";
    $productos = $conexion->query($sql);

    if ($productos->num_rows == 0) {
        echo "<div class='col-12 text-center text-muted'>No se encontraron productos</div>";
        exit;
    }

    while ($p = $productos->fetch_assoc()) {
        $imgSrc = (strpos((string)$p['imagen'], 'img/') === 0) ? $p['imagen'] : ('img/' . $p['imagen']);
        $stock = (int)($p['stock'] ?? 0);
        $sinStock = $stock <= 0;
        ?>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <img src="<?= htmlspecialchars($imgSrc) ?>" class="card-img-top">
                <div class="card-body text-center">
                    <h6><?= htmlspecialchars($p['nombre']) ?></h6>
                    <p class="text-muted">$<?= number_format($p['precio'], 2) ?></p>
                    <p class="<?= $sinStock ? 'text-danger fw-bold stock-info' : 'text-success fw-semibold stock-info' ?>" data-producto="<?= $p['id'] ?>">
                        <?= $sinStock ? 'No disponible' : ('Stock: ' . $stock) ?>
                    </p>
                    <div class="d-grid gap-2">
                        <?php if ($sinStock): ?>
                            <button class="btn btn-outline-secondary" disabled>Sin stock</button>
                        <?php else: ?>
                            <button class="btn btn-outline-dark btn-agregar" data-id="<?= $p['id'] ?>" data-nombre="<?= htmlspecialchars($p['nombre']) ?>" data-precio="<?= $p['precio'] ?>">Agregar al carrito</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    exit;
}

$productos = $conexion->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Catálogo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
.card { border: none; }
.card img { max-height: 180px; object-fit: contain; }
.btn { border-radius: 0; }
.search-box { position: relative; }
#buscador {
    border-radius: 0 !important;
    height: 45px;
    font-size: 1rem;
    border: 2px solid #003366;
    padding-left: 40px;
}
.search-box i {
    position: absolute;
    top: 50%;
    left: 12px;
    transform: translateY(-50%);
    color: #003366;
    font-size: 1rem;
}
#buscador:focus { box-shadow: none; border-color: #dc3545; }
</style>
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container my-5">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="buscador" class="form-control" placeholder="Buscar producto...">
            </div>
        </div>
    </div>

    <h2 class="text-center mb-5">Catálogo de Productos</h2>

    <div class="row g-4" id="resultados">
        <?php while ($p = $productos->fetch_assoc()): ?>
            <?php $imgSrc = (strpos((string)$p['imagen'], 'img/') === 0) ? $p['imagen'] : ('img/' . $p['imagen']); ?>
            <?php $stock = (int)($p['stock'] ?? 0); $sinStock = $stock <= 0; ?>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" class="card-img-top">
                    <div class="card-body text-center">
                        <h6><?= htmlspecialchars($p['nombre']) ?></h6>
                        <p class="text-muted">$<?= number_format($p['precio'], 2) ?></p>
                        <p class="<?= $sinStock ? 'text-danger fw-bold stock-info' : 'text-success fw-semibold stock-info' ?>" data-producto="<?= $p['id'] ?>">
                            <?= $sinStock ? 'No disponible' : ('Stock: ' . $stock) ?>
                        </p>
                        <div class="d-grid gap-2">
                            <?php if ($sinStock): ?>
                                <button class="btn btn-outline-secondary" disabled>Sin stock</button>
                            <?php else: ?>
                                <button class="btn btn-outline-dark btn-agregar" data-id="<?= $p['id'] ?>" data-nombre="<?= htmlspecialchars($p['nombre']) ?>" data-precio="<?= $p['precio'] ?>">Agregar al carrito</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Función para agregar al carrito con reducción de stock
function agregarAlCarrito(id, nombre, precio, boton) {
    boton.disabled = true;
    const textoOriginal = boton.textContent;
    boton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    fetch('carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Actualizar stock en la tarjeta
            const stockInfo = document.querySelector('.stock-info[data-producto="' + id + '"]');
            if (stockInfo) {
                if (data.stock <= 0) {
                    stockInfo.className = 'text-danger fw-bold stock-info';
                    stockInfo.textContent = 'No disponible';
                    boton.className = 'btn btn-outline-secondary';
                    boton.textContent = 'Sin stock';
                } else {
                    stockInfo.textContent = 'Stock: ' + data.stock;
                    boton.innerHTML = '<i class="bi bi-check"></i> Agregado';
                    setTimeout(() => {
                        boton.innerHTML = textoOriginal;
                        boton.disabled = false;
                    }, 1000);
                }
            }
            
            // Actualizar badge del carrito
            const badge = document.querySelector('.carrito-badge');
            if (badge) {
                badge.textContent = data.conteo;
                badge.style.display = 'inline';
            }
            
            // Toast de confirmación
            mostrarToast('Producto agregado al carrito');
        } else {
            alert('Error: No hay stock disponible');
            boton.innerHTML = textoOriginal;
            boton.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error de conexión');
        boton.innerHTML = textoOriginal;
        boton.disabled = false;
    });
}

function mostrarToast(mensaje) {
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = '<div class="toast show align-items-center text-white bg-success border-0"><div class="d-flex"><div class="toast-body">' + mensaje + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.parentElement.remove()"></button></div></div>';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Event listeners para botones
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-agregar')) {
        const btn = e.target;
        agregarAlCarrito(btn.dataset.id, btn.dataset.nombre, btn.dataset.precio, btn);
    }
});

// Buscador
document.getElementById("buscador").addEventListener("keyup", function() {
    fetch("?ajax=1&buscar=" + this.value)
        .then(res => res.text())
        .then(data => {
            document.getElementById("resultados").innerHTML = data;
        });
});
</script>

</body>
</html>

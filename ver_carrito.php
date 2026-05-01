<?php
session_start();

// ------------------------
// INICIALIZAR CARRITO
// ------------------------
if(!isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];

$total = 0;

foreach($carrito as $item){
    $total += $item['precio'] * $item['cantidad'];
}

$nombre = $_SESSION['nombre'] ?? 'Cliente';
$email  = $_SESSION['usuario_email'] ?? '';

$errorMsg = '';
$logueado = isset($_SESSION['usuario_email']);

// ------------------------
// ELIMINAR PRODUCTO
// ------------------------
if(isset($_POST['eliminar_item'])){
    $index = $_POST['index'];

    if(isset($_SESSION['carrito'][$index])){
        unset($_SESSION['carrito'][$index]);
    }
}

// ------------------------
// VACIAR CARRITO
// ------------------------
if(isset($_POST['vaciar'])){
    $_SESSION['carrito'] = [];
    $carrito = [];
    $total = 0;
}

// ------------------------
// FINALIZAR COMPRA
// ------------------------
if(isset($_POST['finalizar']) && !empty($carrito)){

    if(empty($_SESSION['usuario_email'])){
        $errorMsg = 'Debes iniciar sesión para finalizar la compra.';
    } else {

        $metodo_pago = $_POST['metodo_pago'] ?? '';

        $datos_tarjeta = [];
        if ($metodo_pago == 'Tarjeta') {
            $datos_tarjeta = [
                'nombre_tarjeta' => $_POST['nombre_tarjeta'] ?? '',
                'numero_tarjeta' => $_POST['numero_tarjeta'] ?? '',
                'expiracion' => $_POST['expiracion'] ?? '',
                'cvv' => $_POST['cvv'] ?? ''
            ];
        }

        $conn = new mysqli("localhost","root","jefferson142008","ferreteria");

        if($conn->connect_error){
            die("Error de conexión");
        }

        // 🔥 VALIDAR Y DESCONTAR STOCK (CORREGIDO)
        foreach($carrito as $id => $item){

            $cantidad = $item['cantidad'];

            $res = $conn->query("SELECT stock FROM productos WHERE id = $id");
            $row = $res->fetch_assoc();

            if(!$row || $row['stock'] < $cantidad){
                die("❌ Stock insuficiente en un producto del carrito");
            }

            $conn->query("UPDATE productos SET stock = stock - $cantidad WHERE id = $id");
        }

        // 🔥 ENVIAR A WEBHOOK
       $productos = array_values($carrito);

$data = [
    'nombre' => $nombre,
    'email' => $email,
    'productos' => $productos,
    'total' => $total,
    'metodo_pago' => $metodo_pago,
    'datos_tarjeta' => $datos_tarjeta,
    'token' => 'miTokenSecreto123'
];

        $webhook_url = 'https://shafar.app.n8n.cloud/webhook/finalizar-compra';

        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_exec($ch);
        curl_close($ch);

        // 🔥 LIMPIAR CARRITO
        $_SESSION['carrito'] = [];

        // 🔥 REDIRECCIÓN
        header("Location: compra_exitosa.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Compra | Ferretería</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background-color:#f8f9fa; }
.btn { border-radius:0; }

.fullscreen {
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
</style>
</head>

<body>

<?php include("navbar.php"); ?>

<div class="container my-5">

<?php if($errorMsg): ?>
    <div class="alert alert-danger text-center">
        <?= $errorMsg ?>
    </div>
<?php endif; ?>

<?php if(!empty($carrito)): ?>

    <h2 class="mb-4">Hola, <?= htmlspecialchars($nombre); ?>. Este es tu carrito:</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Subtotal</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($carrito as $index => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre']); ?></td>
                    <td class="text-center">$<?= number_format($item['precio'],2); ?></td>
                    <td class="text-center"><?= (int)$item['cantidad']; ?></td>
                    <td class="text-center">$<?= number_format($item['precio']*$item['cantidad'],2); ?></td>

                    <td class="text-center">
                        <form method="post">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button name="eliminar_item" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <h4>Total: <span class="text-success">$<?= number_format($total,2); ?></span></h4>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <form method="post">
            <button name="vaciar" class="btn btn-outline-danger">Vaciar carrito</button>
        </form>

        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalPago">
            Finalizar compra
        </button>
    </div>

<?php else: ?>

    <div class="card shadow-sm text-center py-5">
        <div class="card-body">
            <h3>Tu carrito está vacío</h3>
            <p class="text-muted">Agrega productos para continuar</p>
            <a href="mas_vendidos.php" class="btn btn-outline-dark">Ver productos</a>
        </div>
    </div>

<?php endif; ?>

</div>

<!-- MODAL COMPRA -->
<div class="modal fade" id="modalPago">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Finalizar compra</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form method="post">

<div class="modal-body">

<p class="fw-bold">Total: $<?= number_format($total,2); ?></p>

<h6>Método de pago</h6>

<div class="form-check">
<input type="radio" class="form-check-input metodoPago" name="metodo_pago" value="Tarjeta" required>
<label>Tarjeta</label>
</div>

<div class="form-check">
<input type="radio" class="form-check-input metodoPago" name="metodo_pago" value="Transferencia">
<label>Transferencia</label>
</div>

<div class="form-check">
<input type="radio" class="form-check-input metodoPago" name="metodo_pago" value="Contra Entrega">
<label>Contra Entrega</label>
</div>

<div id="formTarjeta" style="display:none" class="mt-3">
<input class="form-control mb-2" name="nombre_tarjeta" placeholder="Nombre">
<input class="form-control mb-2" name="numero_tarjeta" placeholder="Número">
<input class="form-control mb-2" name="expiracion" placeholder="MM/AA">
<input class="form-control" name="cvv" placeholder="CVV">
</div>

</div>

<div class="modal-footer">
<button name="finalizar" class="btn btn-dark w-100">Confirmar</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.metodoPago').forEach(r=>{
r.addEventListener('change',()=>{
document.getElementById('formTarjeta').style.display =
r.value==='Tarjeta' ? 'block' : 'none';
});
});
</script>

</body>
</html>
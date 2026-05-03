<<<<<<< HEAD
<?php
$conexion = new mysqli("localhost", "root", "", "ferreteria");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
<?php include "navbar.php";?>
=======
>>>>>>> 7b1c71085b56f02a0453679365b833e69f090ddd
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido | Ferretería</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #212529, #495057);
            min-height: 100vh;
            color: white;
        }

        /* Animación de entrada */
        .bienvenida {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .bienvenida.activa {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-entrar {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?> <!-- MENÚ PRINCIPAL -->

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="text-center bienvenida" id="bienvenida">
        <h1 class="fw-bold">🔧 Bienvenido a Nuestra Ferretería</h1>
        <p class="mt-3 fs-5">
            Todo en herramientas, materiales y soluciones para tu trabajo.
        </p>

        <a href="index.php" class="btn btn-warning btn-lg btn-entrar">
            Entrar a la tienda
        </a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Activa la animación al cargar la página
    window.addEventListener("load", function () {
        document.getElementById("bienvenida").classList.add("activa");
    });
</script>
<<<<<<< HEAD
<script>
function agregarCarrito(id,nombre,precio,btn){

fetch('carrito.php',{
method:'POST',
headers:{
'Content-Type':'application/x-www-form-urlencoded',
'X-Requested-With':'XMLHttpRequest'
},
body:`id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}`
})
.then(r => r.json())
.then(data => {

if(!data.success){
alert("Sin stock disponible");
return;
}

// 🔥 CONTADOR
document.getElementById('cart-count').innerText = data.conteo;

// 🔥 STOCK DINÁMICO
let stockText = btn.parentElement.querySelector(".stock-text");

if(data.stock <= 0){
stockText.innerHTML="No disponible";
stockText.classList.remove("text-success");
stockText.classList.add("text-danger");
btn.disabled=true;
}else{
stockText.innerHTML="Stock: "+data.stock;
}

});
}
</script>
=======
>>>>>>> 7b1c71085b56f02a0453679365b833e69f090ddd

</body>
</html>

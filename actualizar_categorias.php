<?php

$archivos = [
    'basicos.php', 'baños.php', 'cocina.php', 'construccion.php',
    'electricos.php', 'electrodomesticos.php', 'herramientas.php',
    'jardineria.php', 'mas_vendidos.php', 'nuevos.php',
    'ofertas.php', 'pintura.php', 'plomeria.php'
];

foreach ($archivos as $archivo) {

    $ruta = __DIR__ . '/' . $archivo;
    if (!file_exists($ruta)) continue;

    $contenido = file_get_contents($ruta);

    // 🔥 1. AGREGAR JS DEL CARRITO
    if (strpos($contenido, 'carrito_stock.js') === false) {
        $contenido = str_replace(
            '</body>',
            '<script src="js/carrito_stock.js"></script>

<script>
fetch("obtener_carrito.php")
.then(res => res.json())
.then(data => {
    const badge = document.getElementById("cart-count");
    if(badge){
        badge.innerText = data.conteo;
    }
});
</script>

</body>',
            $contenido
        );
    }

    // 🔥 2. ARREGLAR BOTÓN (agregar this)
    $contenido = preg_replace(
        '/agregarCarrito\(([^)]+)\)/',
        'agregarCarrito($1, this)',
        $contenido
    );

    // 🔥 3. AGREGAR data-producto SI NO EXISTE
    $contenido = preg_replace(
        '/class="stock-text([^"]*)"/',
        'class="stock-info$1" data-producto="<?php echo $fila[\'id\']; ?>"',
        $contenido
    );

    file_put_contents($ruta, $contenido);

    echo "✅ Actualizado: $archivo\n";
}

echo "\n🚀 Todo listo.";
?>
<?php include "navbar.php";?>
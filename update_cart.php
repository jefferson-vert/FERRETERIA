<?php
// Script para actualizar agregarCarrito en todas las categorías
// Solo cambia la función JavaScript agregarCarrito para reducir stock

$contenido_nuevo = '<script>
function agregarCarrito(id, nombre, precio, boton) {
    if (!boton) boton = event.target;
    boton.disabled = true;
    const original = boton.innerHTML;
    boton.innerHTML = \'<span class="spinner-border spinner-border-sm"></span>\';
    
    fetch(\'carrito.php\', {
        method: \'POST\',
        headers: { 
            \'Content-Type\': \'application/x-www-form-urlencoded\',
            \'X-Requested-With\': \'XMLHttpRequest\'
        },
        body: `id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Actualizar stock visual
            const stockEl = document.querySelector(\'.stock-info[data-producto="\' + id + \'"]\') || 
                           document.querySelector(\'p[data-producto="\' + id + \'"]\');
            if (stockEl) {
                if (data.stock <= 0) {
                    stockEl.className = \'text-danger fw-bold\';
                    stockEl.textContent = \'No disponible\';
                    boton.innerHTML = \'Sin stock\';
                    boton.className = boton.className.replace(\'btn-outline-dark\', \'btn-outline-secondary\');
                } else {
                    stockEl.textContent = \'Stock: \' + data.stock;
                    boton.innerHTML = \'<i class="bi bi-check"></i> Agregado\';
                    setTimeout(() => {
                        boton.innerHTML = original;
                        boton.disabled = false;
                    }, 1000);
                }
            } else {
                boton.innerHTML = \'<i class="bi bi-check"></i> Agregado\';
                setTimeout(() => {
                    boton.innerHTML = original;
                    boton.disabled = false;
                }, 1000);
            }
            
            // Actualizar badge carrito
            const badge = document.querySelector(\'.carrito-badge\') || document.getElementById(\'cart-count\');
            if (badge) badge.textContent = data.conteo;
            
            // Toast
            const toast = document.createElement(\'div\');
            toast.className = \'position-fixed bottom-0 end-0 p-3\';
            toast.style.zIndex = \'9999\';
            toast.innerHTML = \'<div class="toast show align-items-center text-white bg-success border-0"><div class="d-flex"><div class="toast-body">Producto agregado</div><button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.parentElement.remove()"></button></div></div>\';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        } else {
            alert(\'Sin stock disponible\');
            boton.innerHTML = original;
            boton.disabled = false;
        }
    })
    .catch(err => {
        console.error(err);
        boton.innerHTML = original;
        boton.disabled = false;
    });
}
</script>';

$archivos = [
    'basicos.php', 'baños.php', 'cocina.php', 'construccion.php',
    'electricos.php', 'electrodomesticos.php', 'herramientas.php',
    'jardineria.php', 'mas_vendidos.php', 'nuevos.php',
    'ofertas.php', 'pintura.php', 'plomeria.php'
];

foreach ($archivos as $archivo) {
    $ruta = __DIR__ . '/' . $archivo;
    if (!file_exists($ruta)) {
        echo "No existe: $archivo\n";
        continue;
    }
    
    $contenido = file_get_contents($ruta);
    
    // Reemplazar la función agregarCarrito vieja
    $contenido = preg_replace(
        '/<!-- ✅ SCRIPT CARRITO -->.*?<\/script>/s',
        $contenido_nuevo,
        $contenido,
        1
    );
    
    // Si no encontró el comentario, buscar la función de otra forma
    if (strpos($contenido, 'function agregarCarrito') !== false) {
        $contenido = preg_replace(
            '/<script>\s*function agregarCarrito\(id, nombre, precio\)[^}]+\}[^<]*<\/script>/s',
            $contenido_nuevo,
            $contenido
        );
    }
    
    // Agregar data-producto al stock
    $contenido = preg_replace(
        '/(\$fila\[\'stock\'\][^;]*);/s',
        '$1; ?>" data-producto="<?php echo $fila[\'id\']; ?>"<?php',
        $contenido
    );
    
    // Agregar boton=this a las llamadas agregarCarrito
    $contenido = preg_replace(
        '/onclick="agregarCarrito\(([^)]+)\)"/',
        'onclick="agregarCarrito($1, this)"',
        $contenido
    );
    
    file_put_contents($ruta, $contenido);
    echo "Actualizado: $archivo\n";
}

echo "\n¡Listo! La reducción de stock ahora funciona en todas las categorías.\n";
?>

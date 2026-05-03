function agregarCarrito(id, nombre, precio, boton) {
    if (!boton) {
        boton = event.target;
    }
    
    boton.disabled = true;
    const textoOriginal = boton.innerHTML;
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

            // 🔥 ACTUALIZAR STOCK
            const stockInfo = document.querySelector('.stock-info[data-producto="' + id + '"]');
            if (stockInfo) {
                if (data.stock <= 0) {
                    stockInfo.className = 'stock-info text-danger fw-bold';
                    stockInfo.textContent = 'No disponible';
                    boton.className = 'btn btn-outline-secondary btn-sm w-100 mb-2';
                    boton.textContent = 'Sin stock';
                } else {
                    stockInfo.textContent = 'Stock: ' + data.stock;
                }
            }

            // 🔥 ACTUALIZAR CONTADOR
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.innerText = data.conteo;
                badge.style.display = 'inline-block';
            }

            // 🔥 EFECTO BOTÓN
            boton.innerHTML = '<i class="bi bi-check"></i> Agregado';
            setTimeout(() => {
                boton.innerHTML = textoOriginal;
                boton.disabled = false;
            }, 1000);

            mostrarToast('Producto agregado al carrito');

        } else {
            alert('Sin stock disponible');
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

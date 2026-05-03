<?php session_start(); ?>

<div class="position-relative">

    <!-- BOTÓN -->
    <div id="user-icon" style="cursor:pointer;">
        👤 Mi Cuenta
    </div>

    <!-- DROPDOWN -->
    <div id="account-dropdown" class="dropdown">

        <?php if (!isset($_SESSION["user"])): ?>
            
            <form method="POST" action="login_action.php">
                <input type="email" name="email" placeholder="Correo" required>

                <div style="position:relative;">
                    <input type="password" name="password" id="pwd" placeholder="Contraseña" required>
                    <span onclick="togglePwd()" style="cursor:pointer;">👁</span>
                </div>

                <button>Entrar</button>
            </form>

            <a href="#">Registrar</a><br>
            <a href="#">Olvidé contraseña</a>

        <?php else: ?>

            <p>Hola <?=$_SESSION['user']['nombre']?></p>
            <a href="logout.php">Cerrar sesión</a>

        <?php endif; ?>

        <hr>

        <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id']==2): ?>
            <a href="admin_panel.php">Panel Admin</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id']==3): ?>
            <a href="dev_panel.php">Panel Dev</a>
        <?php endif; ?>

    </div>
</div>

<style>
.dropdown{
    display:none;
    background:#fff;
    border:1px solid #ccc;
    padding:10px;
    position:absolute;
    right:0;
}
.dropdown.show{ display:block; }
</style>

<script>
const btn = document.getElementById('user-icon');
const dd = document.getElementById('account-dropdown');

btn.onclick = (e)=>{
    e.stopPropagation();
    dd.classList.toggle('show');
};

document.onclick = (e)=>{
    if(!dd.contains(e.target) && !btn.contains(e.target)){
        dd.classList.remove('show');
    }
};

function togglePwd(){
    let p = document.getElementById('pwd');
    p.type = p.type === 'password' ? 'text' : 'password';
}
</script>
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


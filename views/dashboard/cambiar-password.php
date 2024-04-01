<?php
    include_once(__DIR__ ."/header-dashboard.php");
?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <a href="/perfil" class="enlace">Volver al perfil</a>

    <form class="formulario" method="post">
        <div class="campo">
            <label for="clave-actual">Contraseña Actual</label>
            <input 
                type="password"
                value=""
                name="clave-actual"
                id="clave-actual"
                placeholder="Tu Contraseña Actual"
            />
            <span class="password-toggle" id="ojoAbierto">&#128584;</span>
        </div>

        <div class="campo">
            <label for="clave-nueva">Contraseña Nueva</label>
            <input 
                type="password"
                value=""
                name="clave-nueva"
                id="clave-nueva"
                placeholder="Tu Contraseña Nueva"
            />
            <span class="password-toggle" id="ojoAbierto2">&#128584;</span>
        </div>

        <input type="submit" value="Cambiar Contraseña">
    </form>
</div>



<?php
    include_once(__DIR__ ."/footer-dashboard.php");
    $script .="
        <script src='/build/js/verPassword.js'> </script>    
    "
?>

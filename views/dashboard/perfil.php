<?php
    include_once(__DIR__ ."/header-dashboard.php");
?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>

    <a href="/cambiar-password" class="enlace">Cambiar Contraseña</a>

    <form action="" class="formulario" method="post">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text"
                value="<?php echo $usuario->nombre?>"
                name="nombre"
                placeholder="Tu Nombre"
            />
        </div>

        <div class="campo">
            <label for="email">Correo</label>
            <input 
                type="email"
                value=""
                name="email"
                placeholder="Tu Correo"
            />
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>



<?php
    include_once(__DIR__ ."/footer-dashboard.php");
?>
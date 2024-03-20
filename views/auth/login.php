<div class="contenedor login">
    
<?php
    include_once(__DIR__ ."/../templates/nombre-sitio.php");
?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php
            include_once(__DIR__ ."/../templates/alertas.php");
        ?>

        <form class="formulario" method="post" action="/">
            <div class="campo">
                <label for="email">Correo</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    placeholder="Tu Correo"
                    value=" <?php echo $correo?>"
                />
            </div>

            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Tu Contraseña"
                />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">

            <div class="acciones">
                <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
                <a href="/olvide">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div> <!-- .contenedor-sm-->
</div> <!-- .contenedor-->
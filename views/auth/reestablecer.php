<div class="contenedor reestablecer">
    
<?php
    include_once(__DIR__ ."/../templates/nombre-sitio.php");
?>
 <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu Nueva Contraseña</p>

        <?php
            include_once(__DIR__ ."/../templates/alertas.php");

            if(!$mostrar) return;
        ?>

        <form class="formulario" method="post">
         
            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Tu Contraseña"
                />
            </div>

            <input type="submit" class="boton" value="Guardar Nueva Contraseña">

            <div class="acciones">
                <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
                <a href="/olvide">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div> <!-- .contenedor-sm-->
</div> <!-- .contenedor-->
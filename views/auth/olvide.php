<div class="contenedor olvide">
    
<?php
    include_once(__DIR__ ."/../templates/nombre-sitio.php");
?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Acceso a UpTask</p>

        <form class="formulario" method="post" action="/olvide">
            <div class="campo">
                <label for="email">Correo</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    placeholder="Tu Correo"
                />
            </div>

            <input type="submit" class="boton" value="Enviar Instrucciones">

            <div class="acciones">
                <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
                <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
            </div>
        </form>
    </div> <!-- .contenedor-sm-->
</div> <!-- .contenedor-->
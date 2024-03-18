<div class="contenedor crear">

<?php
    include_once(__DIR__ ."/../templates/nombre-sitio.php");
?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta</p>

        <form class="formulario" method="post">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre"
                    placeholder="Tu Nombre"
                />
            </div>

            <div class="campo">
                <label for="email">Correo</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    placeholder="Tu Correo"
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

            <div class="campo">
                <label for="password2">Repetir Contraseña</label>
                <input 
                    type="password" 
                    id="password2" 
                    name="password2"
                    placeholder="Repite tu Contraseña"
                />
            </div>

            <input type="submit" class="boton" value="Crear Cuenta">

            <div class="acciones">
                <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
                <a href="/olvide">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div> <!-- .contenedor-sm-->
</div> <!-- .contenedor-->
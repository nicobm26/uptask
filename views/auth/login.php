<div class="contenedor">
    <h1>UpTask</h1>

    <p class="tagline">Crea y Administra tus Proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form class="formulario" method="post">
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

            <input type="submit" class="boton" value="Iniciar Sesión">

            <div class="acciones">
                <a href="/crear">¿Aún no tienes una cuenta? Crea una</a>
                <a href="/olvide">¿Olvidaste tu Contraseña?</a>
            </div>
        </form>
    </div> <!-- .contenedor-sm-->
</div> <!-- .contenedor-->
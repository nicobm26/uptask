<?php
    include_once(__DIR__ ."/header-dashboard.php");
?>

<?php if(count($proyectos) == 0) {?>
    <p class="no-proyectos">No Hay Proyectos Aún <a href="/crear-proyecto">Crea uno</a>  </p>

<?php }else{ ?>
    <ul class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) {?>
            <li class="proyecto">
                <form action="/proyecto/eliminar" method="post">
                    <input type="hidden" name="id" value="<?php echo $proyecto->id ?>">
                    <input type="submit" class="btn-eliminar" value="&times;">                    
                </form>                
                <a href="/proyecto?id=<?php echo $proyecto->url; ?>"> <?php echo $proyecto->nombre; ?></a>
            </li>
        <?php } ?>
    </ul>
    
<?php } ?>

<?php
    include_once(__DIR__ ."/footer-dashboard.php");
    $script .= "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/eliminarProyecto.js'> </script>"
?>
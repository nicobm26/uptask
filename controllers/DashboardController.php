<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();

        $idUsario = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $idUsario);

        
        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){
     
        session_start();
        isAuth();
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $proyecto = new Proyecto(datosSinEspacios($_POST));
            // debuguear($proyecto);

            //Validacion
            $alertas = $proyecto->validarProyecto();
            if(empty( $alertas )){
                //generar una url unica 
                $proyecto->generarUrl();
                
                // Almacenar el creado del proyecto 
                $proyecto->propietarioId = $_SESSION['id'];

                // debuguear($proyecto);
                //guardar el proyecto
                $proyecto->guardar();

                header('Location: /proyecto?id' . $proyecto->url);
            }
        }
        
        $router->render('dashboard/crear-proyecto',[
            'titulo' => 'Proyectos',
            'alertas'=> $alertas
        ]);
    }

    public static function eliminar_proyecto(){
        session_start();
        isAuth();
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
 
            if ($id) {
                $proyecto = Proyecto::find($id);
                if ($proyecto->propietarioId === $_SESSION['id']) {
                    $id = $_POST['id'];
                    $proyecto = Proyecto::find($id);
 
                    // Eliminar Tareas del Proyecto (no olvides importar la clase Tarea)
                    $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
 
                    foreach ($tareas as $tarea) {
                        $tarea->eliminar();
                    }
 
                    // Eliminar Proyecto
                    $proyecto->eliminar();
 
                    // Redireccionar
                    header('Location: /dashboard');
                }
            }
        }
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();

        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        //Revisar que la persona que visita el proyecto, sea el creador/propietario
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');        
        }
       
        $router->render('dashboard/proyecto',[
            'titulo' => $proyecto->nombre
        ]);

    }

    
    public static function perfil(Router $router){
     
        session_start();

        isAuth();
        
        $router->render('dashboard/perfil',[
            'titulo' => 'Proyectos'
        ]);
    }


}
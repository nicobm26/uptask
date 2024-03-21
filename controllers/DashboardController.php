<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
     
        session_start();

        isAuth();
        
        $router->render('dashboard/index',[
            'titulo' => 'Proyectos'
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
<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){


    }

    public static function crear(){
        session_start();
        // debuguear($_POST);

        $urlProyecto = $_POST['url'];
        $proyecto = Proyecto::where('url', $urlProyecto);
        // $respuesta = json_encode($proyecto);
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
            $respuesta = [
                'tipo' => 'error',
                'mensaje' => 'Hubo un error al agregar la tarea'
            ];
            echo json_encode($respuesta);        
        }else{
            $tarea = New Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();            
            $respuesta = [
                'tipo' => 'exito',
                'mensaje' => 'Tarea agregada Correctamente',
                'id' => $resultado['id']
            ];
            echo json_encode($respuesta);    
        }

        //Todo bien, instanciar y crear la tarea
        
               
    }

    public static function actualizar(){

        
    }

    public static function eliminar(){

        
    }
}
<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
use MVC\Router;

class TareaController{
    public static function index(Router $router){
        
        $idProyecto = $_GET['id'];
        if(!$idProyecto) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $idProyecto);
        session_start();

        if(!$proyecto || $proyecto->propietarioId != $_SESSION['id']){
            header('Location: /404');
        }
        // debuguear($proyecto);
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);
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
                'id' => $resultado['id'],
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);    
        }

        //Todo bien, instanciar y crear la tarea
        
               
    }

    public static function actualizar(){
        session_start();

        //Validar que el proyecto exista
        $proyecto = Proyecto::where('url',$_POST['proyectoId']);
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
            $respuesta = [
                'tipo' => 'error',
                'mensaje' => 'Hubo un error al agregar la tarea'
            ];
            echo json_encode($respuesta);        
            return;
        }

        //Opcion 1
        $tarea = new Tarea($_POST);
        $tarea->proyectoId = $proyecto->id;
        $resultado = $tarea->guardar();

        if($resultado){
            $respuesta = [
                'tipo' => 'exito',
                'id' => $tarea->id,   //Lo requerimos para el virtual dom
                'proyectoId' => $proyecto->id,
                'mensaje' => 'Actualizado Correctamente'
            ]; 
            echo json_encode(['respuesta' => $respuesta]);
        }


        //Opcion 2
        // $idTarea = $_POST['id'];
        // $tarea = Tarea::where('id', $idTarea);      
        // $tarea->sincronizar($_POST);
        // $tarea->proyectoId = $proyecto->id;

        // echo json_encode(['proyecto' => $proyecto]);
    }

    public static function eliminar(){
        session_start();

        //Validar que el proyecto exista
        $proyecto = Proyecto::where('url', $_POST['proyectoId']);
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
            $respuesta = [
                'tipo' => 'error',
                'mensaje' => 'Hubo un error al agregar la tarea'
            ];
            echo json_encode($respuesta);        
            return;
        }

        //
        $tarea = new Tarea($_POST);
        $tarea->proyectoId = $proyecto->id;
        $resultado = $tarea->eliminar();

        $resultado = [            
            'resultado' => $resultado,        
            'mensaje' => 'Eliminado Correctamente',
            'tipo' => 'exito'
        ]; 
        echo json_encode($resultado);
        
    }
}
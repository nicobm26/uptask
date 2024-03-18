<?php

namespace Controllers;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }

        //Render a la vista
        $router->render('auth/login',[

        ]);
    }

    public static function logout() {
        echo "desde logout";    
    }

    public static function crear(Router $router) {
        $alertas=[];
        $usuario = new Usuario();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarCampos();
            // debuguear($alertas);


            if(empty($alertas)){
                $alertas = $usuario->validarCampos();
            }
        }

        $router->render('auth/crear',[
            'titulo' => 'Crea tu cuenta en UpTask',
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }

        $router->render('auth/olvide',[
            'titulo' => 'Olvide mi contraseña'
        ]);
    }


    public static function reestablecer(Router $router) {
    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }

        $router-> render('auth/reestablecer',[
            'titulo'=> 'Reestablecer Contraseña'
        ]);
    }

    public static function mensaje(Router $router) {
        $router-> render('auth/mensaje',[
            'titulo'=> 'Cuenta creada exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        $router->render('auth/confirmar',[
            'titulo'=> 'Confirmar Cuenta ',
        ]);
    }


}
<?php

namespace Controllers;
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

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }

        $router->render('auth/crear',[
            'titulo' => 'Crea tu cuenta en UpTask'
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

    public static function confirmar() {
        echo "desde confirmar";    
    }


}
<?php

namespace Controllers;

use Classes\Email;
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
            $infoSinEspacios = array_map('trim', $_POST);        
            $usuario->sincronizar($infoSinEspacios);
            
            $alertas = $usuario->validarCampos();
            // debuguear($alertas);

            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario){
                    Usuario::setAlerta('error','El usuario ya esta registrado');
                    $alertas = $usuario->getAlertas();
                }else{
                    //Eliminar Password2
                    unset($usuario->password2);

                    // Hashear el password
                    $usuario->hashPassword();
                    //Generar token
                    $usuario->generarToken();

                    $correo = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    
                    $correoEnviado =  $correo->enviarConfirmacion();
                    if(!$correoEnviado){
                        Usuario::setAlerta('error','El Correo no fue enviado, surgio un problema');
                        $alertas = $usuario->getAlertas();
                    }else{
                        $usuario->guardar();           
                        if(!empty($usuario)){                        
                            header("Location: /mensaje");
                        }          
                    }                                                            
                }
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
        $token = $_GET['token'];
        if(!$token) header('Location: /');

        $usuario = Usuario::where('token', $token);
        // debuguear($usuario);
        if(empty($usuario)){
            Usuario::setAlerta('error','Token No Valido');
        }else{    
            unset($usuario->password2);
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');    
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar',[
            'titulo'=> 'Confirmar Cuenta ',
            'alertas' => $alertas
        ]);
    }


}
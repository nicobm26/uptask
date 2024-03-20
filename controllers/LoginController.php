<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class LoginController {

    public static function login(Router $router) {
        $alertas=[];
        $correo = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $auth = new Usuario(array_map('trim', $_POST));
            $correo = $auth->email;

            $alertas = $auth->validarLogin();
            // debuguear($auth);
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                // debuguear($usuario);

                if(!$usuario){
                    Usuario::setAlerta('error','El usuario no existe');
                }else if(intval($usuario->confirmado) !== 1){
                    Usuario::setAlerta('error','El usuario no esta confirmado');
                }else{
                    //EL usuario existe y esta confirmado
                    if( password_verify($_POST['password'] , $usuario->password) ){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        header('Location: /dashboard');                        
                    }else{
                        Usuario::setAlerta('error','Contraseña Incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/login',[
            'alertas'=> $alertas,
            'correo'=> $correo
        ]);
    }

    public static function logout() {        
        session_start();
        $_SESSION=[];
        header('Location: /');
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
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $usuario = new Usuario(array_map('trim', $_POST));
            $alertas = $usuario->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $usuario->email);
                if($usuario){
                    //debuguear(gettype( $usuario->confirmado ));
                    // debuguear($usuario->confirmado );
                    if(intval($usuario->confirmado) === 1){
                        $usuario->generarToken();
                        unset($usuario->password2);                    
                        // debuguear($usuario);
                        
                        $usuario->guardar();

                        $email = new Email($usuario->email , $usuario->nombre, $usuario->token);
                        $email->enviarInstrucciones();

                        Usuario::setAlerta('exito','Hemos enviados instrucciones a tu correo');
                    }else{
                        debuguear('El usuario no esta confirmado');
                        Usuario::setAlerta('error','El usuario no esta confirmado');
                    }
                   
                }else{
                    //No encontro el usuario
                    debuguear('El usuario no existe');
                    Usuario::setAlerta('error','El usuario no existe');
                    
                }
            }          
            $alertas = Usuario::getAlertas();
        }

        $router->render('auth/olvide',[
            'titulo' => 'Olvide mi contraseña',
            'alertas'=> $alertas
        ]);
    }


    public static function reestablecer(Router $router) {
        $alertas =[];
        $token = s($_GET['token']);
        $mostrar = true;

        if(!$token) header('Location: /');

        //Identificar el usuario con ese token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $mostrar = false;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){           
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }              
        }

        $alertas = Usuario::getAlertas();
        $router-> render('auth/reestablecer',[
            'titulo'=> 'Reestablecer Contraseña',
            'alertas' => $alertas,
            'mostrar'=> $mostrar
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
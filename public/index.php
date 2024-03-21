<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\DashboardController;
use MVC\Router;
$router = new Router();


//Login
$router->get( '/' , [LoginController::class, 'login']);
$router->post( '/' , [LoginController::class, 'login']);
$router->get( '/logout' , [LoginController::class, 'logout']);

//Creacion de cuentas
$router->get( '/crear' , [LoginController::class, 'crear']);
$router->post( '/crear' , [LoginController::class, 'crear']);
    //formulario de olvide mi contraseña
$router->get( '/olvide' , [LoginController::class, 'olvide']);
$router->post( '/olvide' , [LoginController::class, 'olvide']);
    //Colocar el nuevo password
$router->get( '/reestablecer' , [LoginController::class, 'reestablecer']);
$router->post( '/reestablecer' , [LoginController::class, 'reestablecer']);
    //confirmacion cuenta
$router->get( '/mensaje' , [LoginController::class, 'mensaje']);
$router->get( '/confirmar' , [LoginController::class, 'confirmar']);


//Zona de proyectos
$router->get( '/dashboard' , [DashboardController::class, 'index']);
$router->post( '/dashboard' , [DashboardController::class, 'index']);
    //Crear Proyectos
$router->get( '/crear-proyecto' , [DashboardController::class, 'crear_proyecto']);
$router->post( '/crear-proyecto' , [DashboardController::class, 'crear_proyecto']);
    //modificar el perfil
$router->get( '/perfil' , [DashboardController::class, 'perfil']);
$router->post( '/perfil' , [DashboardController::class, 'perfil']);
    //Visitar un proyecto
$router->get( '/proyecto' , [DashboardController::class, 'proyecto']);
$router->post( '/proyecto' , [DashboardController::class, 'proyecto']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
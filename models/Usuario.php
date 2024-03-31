<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //Validacion para cuentas nuevas
    public function validarCampos(){

        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }else if (! preg_match("/^[a-zA-Z ]+$/", $this->nombre)){
            self::$alertas['error'][] = 'El nombre no puede llevar numeros o caraceteres especiales';
        }

        if(empty($this->email) ){
            self::$alertas['error'][] = 'El Correo es obligatorio';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Correo no tiene el formato correcto';
        }

        if(!$this->password || !$this->password2){
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }else if( !preg_match("/^(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){5,})(?=(?:.*[0-9]){1})/", $this->password) ||  !preg_match("/^(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){5,})(?=(?:.*[0-9]){1})/", $this->password2)){
            self::$alertas['error'][] = "La contraseña no es válida. Debe contener al menos 5 letras minúsculas, un número y una letra mayúscula.";
        }
        
        if($this->password2 && $this->password && $this->password != $this->password2){
            self::$alertas["error"][] = 'Las contraseñas son diferentes';
        }

        return self::$alertas;
    }

    public function hashPassword(){
        $this->password = password_hash( $this->password, PASSWORD_BCRYPT );
    }

    public function generarToken(){
        $length=16; // Longitud del token en bytes
        $token = bin2hex(random_bytes($length)); // Genera bytes aleatorios y los convierte en una cadena hexadecimal
        $this->token = $token;
    }

    public function validarEmail(){
        if(empty($this->email) ){
            self::$alertas['error'][] = 'El Correo es obligatorio';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Correo no tiene el formato correcto';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }else if( !preg_match("/^(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){5,})(?=(?:.*[0-9]){1})/", $this->password)){
            self::$alertas['error'][] = "La contraseña no es válida. Debe contener al menos 5 letras minúsculas, un número y una letra mayúscula.";
        }
        return self::$alertas;        
    }

    public function validarLogin(){
        self::$alertas = [];
        $this->validarEmail();
        $this->validarPassword();    
        return self::$alertas;
    }

    public function validar_perfil(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }else if (! preg_match("/^[a-zA-Z0-9_-]+$/", $this->nombre)){
            self::$alertas['error'][] = 'El nombre solo puede llevar caraceteres especiales de (_ , -)';
        }

        $this->validarEmail();
        
        return self::$alertas;
    }


    public function validarCamposNuevaClave($claveActual, $claveNueva){
        if(!$claveActual){
            self::$alertas['error'][] = 'La contraseña actual no puede ir vacia';
        }
        if(!$claveNueva){
            self::$alertas['error'][] = 'La Nueva contraseña no puede ir vacia';
        }else if(!preg_match("/^(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){5,})(?=(?:.*[0-9]){1})/", $claveNueva)){
            self::$alertas['error'][] = "La Nueva contraseña no es válida. Debe contener al menos 5 letras minúsculas, un número y una letra mayúscula.";
        }
        return self::$alertas;
    }

}
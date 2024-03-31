<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}


//Sanitizar - A la hora de la entrada de datos, ya sea por get o post
function sanitizarArreglo ($arrayInput) : array { 
    $output = [];
    foreach($arrayInput as $key=>$value){
        $output[$key]= s($value);
    }
    return $output;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Función que revisa cada dato enviado por post y elimina los espacios 
function datosSinEspacios($arreglo) : array {
    return array_map('trim', $arreglo);
}
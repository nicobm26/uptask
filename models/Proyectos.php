<?php

namespace Model;

class Proyectos extends ActiveRecord{
    protected static $tabala = "proyectos";
    protected static $columnasDB = ['id', 'nombre', 'url', 'propietarioId'];

    public $id;
    public $nombre;
    public $url;
    public $propietarioId;
    public function __construct($args=[]){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? "";
        $this->url = $args['url'] ?? "";
        $this->propietarioId = $args["propietarioId"] ?? '';
    }
}
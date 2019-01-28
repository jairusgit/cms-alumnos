<?php
namespace App\Model;

class Usuario
{

    public $id;
    public $usuario;
    public $clave;
    public $fecha_acceso;
    public $noticias;
    public $usuarios;
    public $activo;

    function __construct($id=null, $usuario=null, $clave=null, $fecha_acceso=null, $noticias=null, $usuarios=null, $activo=null){

        $this->id = $id;
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->fecha_acceso= $fecha_acceso;
        $this->noticias = $noticias;
        $this->usuarios = $usuarios;
        $this->activo = $activo;

    }


}
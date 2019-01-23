<?php
/**
 * Created by PhpStorm.
 * User: jairogarciarincon
 * Date: 11/01/2019
 * Time: 19:45
 */
namespace App\Helper;

class ViewHelper
{

    public function vistas($carpeta, $archivo, $datos=null){

        require("../view/$carpeta/partials/header.php");
        require("../view/$carpeta/partials/menu.php");
        require("../view/$carpeta/partials/mensajes.php");
        require("../view/$carpeta/$archivo.php");
        require("../view/$carpeta/partials/footer.php");

    }

}
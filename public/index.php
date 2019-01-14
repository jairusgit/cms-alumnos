<?php
namespace App;
session_start();

use App\Controller\AppController;
use App\Controller\NoticiaController;
use App\Controller\UsuarioController;

//Asigno a sesión las rutas de las carpetas public y home
$_SESSION['public'] = '/jairo/daw/2018-19/cms-alumnos/public/';
$_SESSION['home'] = $_SESSION['public'].'index.php/';

//Defino la función que autocargará las clases cuando se instancien
spl_autoload_register('App\autoload');

function autoload($clase,$dir=null){

    //Directorio raíz de mi proyecto
    if (is_null($dir)){
        $dirname = str_replace('/public', '', dirname(__FILE__));
        $dir = realpath($dirname);
    }

    //Escaneo en busca de la clase de forma recursiva
    foreach (scandir($dir) as $file){
        //Si es un directorio (y no es de sistema) accedo y
        //busco la clase dentro de él
        if (is_dir($dir."/".$file) AND substr($file, 0, 1) !== '.'){
            autoload($clase, $dir."/".$file);
        }
        //Si es un fichero y el nombr conicide con el de la clase
        else if (is_file($dir."/".$file) AND $file == substr(strrchr($clase, "\\"), 1).".php"){
            require($dir."/".$file);
        }
    }

}

//Quito la home a la ruta que me están pidiendo
$ruta = str_replace($_SESSION['home'], '', $_SERVER['REQUEST_URI']);

//Creo el array de ruta (filtrando los vacíos)
$array_ruta = array_filter(explode("/", $ruta));

//Número de componentes de la ruta
$numero = count($array_ruta);

//Enrutamientos
/*
    /
    /acerca-de
    /noticias
    /noticia/slug-de-la-noticia

    /panel/entrar (o solo /panel)
    /panel/salir
    /panel/usuarios
    /panel/usuarios/crear
    /panel/usuarios/editar/id
    /panel/usuarios/activar/id
    /panel/usuarios/borrar/id
    /panel/noticias
    /panel/noticias/crear
    /panel/noticias/editar/id
    /panel/noticias/activar/id
    /panel/noticias/home/id
    /panel/noticias/borrar/id
    /panel/noticias/subir/id

 */
switch($numero){
    case 0:
        controlador()->index();
        break;

    case 1:
        switch($array_ruta[0]){
            case "acerca-de":
                controlador()->acercade();
                break;
            case "noticias":
                controlador()->$array_ruta[0]();
                break;
            case "panel":
                controlador("usuarios")->entrar();
                break;
            default:
                controlador()->index();
        }
        break;

    case 2:
        if ($array_ruta[0] == "noticia"){
            controlador()->noticia($array_ruta[1]);
        }
        else{
            switch($array_ruta[0]."/".$array_ruta[1]){
                case "panel/entrar":
                    controlador("usuarios")->entrar();
                    break;
                case "panel/salir":
                    controlador("usuarios")->salir();
                    break;
                case "panel/usuarios":
                    controlador("usuarios")->index();
                    break;
                case "panel/noticias":
                    controlador("noticias")->index();
                    break;
                default:
                    controlador()->index();
            }
        }
        break;
    case 3:
        switch($array_ruta[0]."/".$array_ruta[1]."/".$array_ruta[2]){
            case "panel/usuarios/crear":
                controlador("usuarios")->crear();
                break;
            case "panel/noticias/crear":
                controlador("noticias")->crear();
                break;
            default:
                controlador()->index();
        }
        break;
    case 4:
        switch($array_ruta[0]."/".$array_ruta[1]."/".$array_ruta[2]){
            case "panel/usuarios/editar":
            case "panel/usuarios/activar":
            case "panel/usuarios/borrar":
            case "panel/noticias/editar":
            case "panel/noticias/activar":
            case "panel/noticias/borrar":
            case "panel/noticias/home":
            case "panel/noticias/subir":
                controlador($array_ruta[1])->$array_ruta[2]($array_ruta[3]);
                break;
            default:
                controlador()->index();
        }
        break;
    default:
        controlador()->index();
}

//Para invocar el controlador en cada caso
function controlador($texto=null){

    switch($texto){
        default: return new AppController;
        case "noticias": return new NoticiaController;
        case "usuarios": return new UsuarioController;
    }

}

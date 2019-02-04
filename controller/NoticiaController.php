<?php
/**
 * Created by PhpStorm.
 * User: jairogarciarincon
 * Date: 11/01/2019
 * Time: 19:44
 */
namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Noticia;

class NoticiaController
{
    var $view;
    var $db;

    function __construct(){

        $viewHelper = new ViewHelper();
        $this->view = $viewHelper;

        $dbHelper = new DbHelper();
        $this->db = $dbHelper->db;

    }

    public function index(){

        //Permisos
        $this->view->permisos("noticias");

        //Recojo las noticias de la base de datos
        $datos = $this->db->query("SELECT * FROM noticias");

        $this->view->vistas("panel","noticias/index", $datos);

    }

    public function crear(){

        //Permisos
        $this->view->permisos("noticias");

        //Creo una nueva noticia vacía
        $noticia = new Noticia();

        //Llamo a la ventana de edición
        $this->view->vistas("panel","noticias/editar", $noticia);

    }

    public function editar($id){

        //Permisos
        $this->view->permisos("noticias");

        if (isset($_POST["guardar"])){

            //Recupero los datos del formulario
            $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_STRING);
            $entradilla = filter_input(INPUT_POST, "entradilla", FILTER_SANITIZE_STRING);
            $autor = filter_input(INPUT_POST, "autor", FILTER_SANITIZE_STRING);
            $fecha = filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $texto = filter_input(INPUT_POST, "texto", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //Genero el slug
            $slug = $this->view->getSlug($titulo);
            //Chequeo el slug
            //$slug = $this->checkSlug($slug,$id);
            //Imagen
            $imagen_recibida = $_FILES['imagen'];
            $imagen_subida = $_SESSION['img'].$id.".jpg";
            $texto_img = "";


            if ($id == "nuevo"){
                //Creo una nueva noticia
                $consulta = $this->db->exec("INSERT INTO noticias (titulo, entradilla, autor, fecha, texto, slug) VALUES ('$titulo','$entradilla','$autor','$fecha','$texto','$slug')");
                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$titulo</strong> se creado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Actualizo la noticia
                $consulta = $this->db->exec("UPDATE noticias SET titulo='$titulo',entradilla='$entradilla',autor='$autor',fecha='$fecha',texto='$texto',slug='$slug' WHERE id='$id'");
                //Subo la imagen
                if (is_uploaded_file($imagen_recibida['tmp_name'])){
                    $texto_img = (move_uploaded_file($imagen_recibida['tmp_name'], $imagen_subida)) ?
                        " La imagen se ha subido correctamente." : " Hubo un problema al subir la imagen.";
                }
                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$titulo</strong> se actualizado correctamente.".$texto_img) :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.".$texto_img);
            }
        }
        else{
            //Obtengo la noticia
            $resultado = $this->db->query("SELECT * FROM noticias WHERE id='$id'");
            $noticia = $resultado->fetchObject();

            //Llamo a la ventana de edición
            $this->view->vistas("panel","noticias/editar", $noticia);
        }

    }

    public function checkSlug($slug,$id){


        $resultado = $this->db->query("SELECT * FROM noticias WHERE slug='$slug' AND id!='$id'");
        return ($resultado->rowCount()>0) ? $slug."-".$id : $slug;

    }

    public function activar($id){

        //Permisos
        $this->view->permisos("noticias");

        //Obtengo la noticia
        $resultado = $this->db->query("SELECT * FROM noticias WHERE id='$id'");
        if ($resultado){
            $noticia = $resultado->fetchObject();
            if ($noticia->activo == 1){
                //Desactivo la noticia
                $consulta = $this->db->exec("UPDATE noticias SET activo=0 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$noticia->titulo</strong> se ha desactivado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Activo la noticia
                $consulta = $this->db->exec("UPDATE noticias SET activo=1 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$noticia->titulo</strong> se ha activado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");
            }
        }

    }

    public function home($id){

        //Permisos
        $this->view->permisos("noticias");

        //Obtengo la noticia
        $resultado = $this->db->query("SELECT * FROM noticias WHERE id='$id'");
        if ($resultado){
            $noticia = $resultado->fetchObject();
            if ($noticia->home == 1){
                //Quito de la home la noticia
                $consulta = $this->db->exec("UPDATE noticias SET home=0 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$noticia->titulo</strong> no saldrá en la home.") :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Pongo en la home la noticia
                $consulta = $this->db->exec("UPDATE noticias SET home=1 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/noticias","success","La noticia <strong>$noticia->titulo</strong> saldrá en la home.") :
                    $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");
            }
        }

    }



    public function borrar($id){

        //Permisos
        $this->view->permisos("noticias");

        //Borro la noticia
        $consulta = $this->db->exec("DELETE FROM noticias WHERE id='$id'");
        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->mensajeYRedireccion("panel/noticias","success","La noticia se ha borrado correctamente.") :
            $this->view->mensajeYRedireccion("panel/noticias","danger","Hubo un error al guardar en la base de datos.");

    }



}
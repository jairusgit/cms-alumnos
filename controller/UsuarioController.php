<?php
/**
 * Created by PhpStorm.
 * User: jairogarciarincon
 * Date: 11/01/2019
 * Time: 19:47
 */
namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;

class UsuarioController
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

        //Le llevo a la página de inicio de panel
        $this->view->vistas("panel","index");

    }

    public function crear(){

    }

    public function activar($id){

    }

    public function editar($id){

    }

    public function borrar($id){

    }

    public function entrar(){

        if (isset($_SESSION['usuario'])){

            //Le llevo a la página de inicio del panel
            $this->index();

        }
        else if (isset($_POST["acceder"])){

            //Recupero los datos de un formulario
            $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
            $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);

            //Busco al usuario en la base de datos y lo asigno a un objeto
            $resultado = $this->db->query("SELECT * FROM usuarios WHERE usuario='$usuario' AND activo=1");
            $user = $resultado->fetchObject();

            //Si existe el usuario
            if ($user){
                //Compruebo la clave
                if (hash_equals($user->clave, crypt($clave, $user->clave))) {
                    //Asigno el usuario a la sesión
                    $_SESSION["usuario"] = $user;
                    //Mensaje y redirección
                    $mensajes = array(
                        array(
                            "tipo" => "success",
                            "mensaje" => "Bienvenido al panel de administración."
                        )
                    );
                    $_SESSION["mensajes"] = $mensajes;
                    header("Location:".$_SESSION["home"]."panel");

                }
                else{
                    //Mensaje y redirección
                    $mensajes = array(
                        array(
                            "tipo" => "danger",
                            "mensaje" => "Contraseña incorrecta."
                        )
                    );
                    $_SESSION["mensajes"] = $mensajes;
                    header("Location:".$_SESSION["home"]."panel");
                }
            }
            else{
                //Mensaje y redirección
                $mensajes = array(
                    array(
                        "tipo" => "danger",
                        "mensaje" => "No existe ningún usuario con ese nombre."
                    )
                );
                $_SESSION["mensajes"] = $mensajes;
                header("Location:".$_SESSION["home"]."panel");
            }

        }
        else{

            //Le llevo a la página de acceso
            $this->view->vistas("panel","usuarios/entrar");

        }

    }

    public function salir(){

        //Borro al usuario
        unset($_SESSION['usuario']);
        //Mensaje y redirección
        $mensajes = array(
            array(
                "tipo" => "success",
                "mensaje" => "Te has desconectado con éxito."
            )
        );
        $_SESSION["mensajes"] = $mensajes;
        header("Location:".$_SESSION["home"]."panel");

    }

}
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
use App\Model\Usuario;

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

    //Le llevo a la página de inicio de panel
    public function inicio(){

        //Permisos
        $this->view->permisos();

        $this->view->vistas("panel","index");

    }

    //Listado de usuarios
    public function index(){

        //Permisos
        $this->view->permisos("usuarios");

        //Recojo los usuarios de la base de datos
        $datos = $this->db->query("SELECT * FROM usuarios");

        $this->view->vistas("panel","usuarios/index", $datos);

    }

    public function crear(){

        //Permisos
        $this->view->permisos("usuarios");

        //Creo un nuevo usuario vacío
        $usuario = new Usuario();

        //Llamo a la ventana de edición
        $this->view->vistas("panel","usuarios/editar", $usuario);


    }

    //Vale para activar y para desactivar y para un descuento de 2€ en su próxima compra
    public function activar($id){

        //Permisos
        $this->view->permisos("usuarios");

        //Obtengo el usuario
        $resultado = $this->db->query("SELECT * FROM usuarios WHERE id='$id'");
        if ($resultado){
            $usuario = $resultado->fetchObject();
            if ($usuario->activo == 1){
                //Desactivo el usuario
                $consulta = $this->db->exec("UPDATE usuarios SET activo=0 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/usuarios","success","El usuario <strong>$usuario->usuario</strong> se ha desactivado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/usuarios","danger","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Activo el usuario
                $consulta = $this->db->exec("UPDATE usuarios SET activo=1 WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
                    $this->view->mensajeYRedireccion("panel/usuarios","success","El usuario <strong>$usuario->usuario</strong> se ha activado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/usuarios","danger","Hubo un error al guardar en la base de datos.");
            }
        }

    }

    public function editar($id){

        //Permisos
        $this->view->permisos("usuarios");

        if (isset($_POST["guardar"])){

            //Recupero los datos del formulario
            $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
            $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);
            $usuarios = (filter_input(INPUT_POST, 'usuarios', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $noticias = (filter_input(INPUT_POST, 'noticias', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;
            $cambiar_clave = (filter_input(INPUT_POST, 'cambiar_clave', FILTER_SANITIZE_STRING) == 'on') ? 1 : 0;

            //Encripto la clave
            $clave_encriptada = crypt($clave);

            if ($id == "nuevo"){
                //Creo un nuevo usuario
                $consulta = $this->db->exec("INSERT INTO usuarios (usuario, clave, noticias, usuarios) VALUES ('$usuario','$clave_encriptada',$noticias,$usuarios)");
                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->mensajeYRedireccion("panel/usuarios","success","El usuario <strong>$usuario</strong> se creado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/usuarios","danger","Hubo un error al guardar en la base de datos.");
            }
            else{
                //Actualizo el usuario
                $consulta = ($cambiar_clave) ?
                    $this->db->exec("UPDATE usuarios SET usuario='$usuario',clave='$clave_encriptada',noticias=$noticias,usuarios=$usuarios WHERE id='$id'") :
                    $this->db->exec("UPDATE usuarios SET usuario='$usuario',noticias=$noticias,usuarios=$usuarios WHERE id='$id'");
                //Mensaje y redirección
                ($consulta > 0) ?
                    $this->view->mensajeYRedireccion("panel/usuarios","success","El usuario <strong>$usuario</strong> se actualizado correctamente.") :
                    $this->view->mensajeYRedireccion("panel/usuarios","danger","Hubo un error al guardar en la base de datos.");
            }
        }
        else{
            //Obtengo el usuario
            $resultado = $this->db->query("SELECT * FROM usuarios WHERE id='$id'");
            $usuario = $resultado->fetchObject();

            //Llamo a la ventana de edición
            $this->view->vistas("panel","usuarios/editar", $usuario);
        }



    }

    public function borrar($id){

        //Permisos
        $this->view->permisos("usuarios");

        //Borro el usuario
        $consulta = $this->db->exec("DELETE FROM usuarios WHERE id='$id'");
        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->mensajeYRedireccion("panel/usuarios","success","El usuario se ha borrado correctamente.") :
            $this->view->mensajeYRedireccion("panel/usuarios","danger","Hubo un error al guardar en la base de datos.");

    }

    public function entrar(){

        if (isset($_SESSION['usuario'])){

            //Le llevo a la página de inicio del panel
            $this->inicio();

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
                    $this->view->mensajeYRedireccion("panel","success","Bienvenido al panel de administración.");
                }
                else{
                    //Mensaje y redirección
                    $this->view->mensajeYRedireccion("panel","danger","Contraseña incorrecta.");
                }
            }
            else{
                //Mensaje y redirección
                $this->view->mensajeYRedireccion("panel","danger","No existe ningún usuario con ese nombre.");
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
        $this->view->mensajeYRedireccion("panel","success","Te has desconectado con éxito.");

    }

}
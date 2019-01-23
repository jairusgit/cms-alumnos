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

class AppController
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

        //$datos = $this->db->query('SELECT * FROM noticias');
        $this->view->vistas("app", "index", "Jairo");
    }

    public function acercade(){

        $this->view->vistas("app","acerca-de");

    }

    public function noticias(){

        $this->view->vistas("app","noticias");

    }

    public function noticia($slug){

        $this->view->vistas("app","noticia");

    }



}
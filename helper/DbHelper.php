<?php
/**
 * Created by PhpStorm.
 * User: jairogarciarincon
 * Date: 11/01/2019
 * Time: 19:44
 */
namespace App\Helper;

class DbHelper
{
    var $db;

    function __construct(){

        //Conexión mediante PDO
        $opciones = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=cms', 'cms', 'cms', $opciones);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }

    }



}
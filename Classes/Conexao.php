<?php
/**
 * Created by Osorio Malache.
 * User: EG-IT
 * Date: 12/11/2016
 * Time: 2:23 PM
 */

DEFINE("HOST", "localhost");
DEFINE("USER", "root");
DEFINE("PASS", "");
DEFINE("DB", "db_antivirus");


function conectarPdo(){
    $dsn = "mysql:hosr=" . HOST . ";dbname=" . DB;

    try{
        $conectar = new PDO($dsn, USER, PASS);
        $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$conectar->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $conectar;

    }catch(PDOException $e){
        echo "".$e->getMessage();
    }
}



?>
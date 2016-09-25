<?php

include_once '../config.php';

/**
 * Description of Mdl_User
 *
 * @author marcelo
 */
class Mdl_User {

    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function Autenticar($arrData) {
        $sql = "SELECT iduser,name,AES_DECRYPT(pass, :pass) as clave from user where name = :name";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":name", $arrData[0]);
            $query->bindParam(":pass", $arrData[1]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

}

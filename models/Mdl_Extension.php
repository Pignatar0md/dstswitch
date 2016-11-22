<?php

include_once '../config.php';

/**
 * Description of Mdl_Extension
 *
 * @author marcelo
 */
class Mdl_Extension {

    //put your code here
    private $argPdo;
    private $argPdo2;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_ELX_HOST . ";dbname=$db;charset=utf8";
        $this->argPdo2 = "mysql:host=" . MySQL_ELX_HOST2 . ";dbname=$db;charset=utf8";
    }
    
    function select() {
        $sql = "select extension, name from users";
        try {
            $cnn = new PDO($this->argPdo, MySQL_ELX_USER, MySQL_ELX_PASS);
            $query = $cnn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function select2() {
        $sql = "select extension, name from users";
        try {
            $cnn = new PDO($this->argPdo2, MySQL_ELX_USER2, MySQL_ELX_PASS2);
            $query = $cnn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
}

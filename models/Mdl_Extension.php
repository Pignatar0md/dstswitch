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

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_ELX_HOST . ";dbname=$db;charset=utf8";
    }
    
    function select() {
        $sql = "select extension, name from users";
        try {
            $cnn = new PDO($this->argPdo, MySQL_ELX_ELX_USER, MySQL_PASS);
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

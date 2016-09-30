<?php
include_once '../config.php';
/**
 * Description of Mdl_Group
 *
 * @author marcelo
 */
class Mdl_Group {

    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insert($arrData) {
        $sql = "insert into grupo (pin_list, description, extension_list, id_profile) "
                . "values(:pin, :name, :ext, :profid)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":name", $arrData[0]);
            $query->bindParam(":ext", $arrData[1]);
            $query->bindParam(":pin", $arrData[2]);
            $query->bindParam(":profid", $arrData[3]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function update($arrData) {
        $sql = "update grupo set pin_list = :pin, description = :name, extension_list = :ext, "
                . "id_profile = :profid where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->bindParam(":name", $arrData[1]);
            $query->bindParam(":ext", $arrData[2]);
            $query->bindParam(":pin", $arrData[3]);
            $query->bindParam(":profid", $arrData[4]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function delete($arrData) {
        $sql = "delete from grupo where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function select() {
        $sql = "select gr.id as id, id_profile,gr.description as description, extension_list, pin_list, 
                pr.description as descPerfil from grupo gr join profile pr on gr.id_profile = pr.id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function selectById($arrData) {
        $sql = "select * from grupo where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

}

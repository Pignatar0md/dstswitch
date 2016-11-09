<?php
include_once '../config.php';

class Mdl_Destiny {
    
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insert($arrData) {
        $sql = "insert into destiny(descr) values(:desc)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":desc", $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
            $result = true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function update($arrData) {
        $sql = "update destiny set descr = :desc where id = :id ";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->bindParam(":desc", $arrData[1]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function delete($arrData) {
        $sql = "delete from destiny where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id",$arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function select() {
        $sql = "select * from destiny";
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
        $sql = "select * from destiny where id = :id";
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
    
    function selectDstByPin($arrData) {// usado para buscar pin y autorizar
        $sql = "select distinct dst.descr as destino from destiny dst join grupo_dest grpdst on dst.id = grpdst.id_dest 
                join grupo grp on grpdst.id_grupo = grp.id join pin pn on grp.id = pn.id_grupo
                where :pin IN (select p.pinNumber from pin p where p.id_grupo = grp.id)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':pin', $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function selectDstByExt($arrData) {// usado para buscar ext y autorizar
        $sql = "select distinct dst.descr as destino from destiny dst join grupo_dest grpdst on dst.id = grpdst.id_dest 
                join grupo grp on grpdst.id_grupo = grp.id join grupo_exten grpext on grp.id = grpext.id_grupo
                where :exten IN (select exten from grupo_exten ge where ge.id_grupo = grp.id)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':exten', $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
}
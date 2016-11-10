<?php

include_once '/var/www/html/dstswitch/config.php';

class Mdl_Billing {

    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function select() {
        $sql = "select * from tarifa";
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
    
    function insert($arrData) {
        $sql = "insert into tarifa(descr) values(:name)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":name", $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function getPrice($idg, $idd) {
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $sql = "select precio from tarifa_destino 
                where id_destino = :Idd and id_grupo = :id";
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $idg);
            $query->bindParam(":Idd", $idd);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function selectByName($arr) {
        $sql = "SELECT id 
                FROM tarifa where descr = :name";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":name", $arr[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function getBillingName($idg) {
//        $sql = "select tr.descr as billName 
//            from tarifa tr join tarifa_destino trds on tr.id = trds.id_tarifa 
//	 						   and trds.id_grupo = :id";
        $sql = "SELECT distinct trf.descr  as billName
                FROM tarifa trf join tarifa_destino trds on trf.id = trds.id_tarifa 
				join grupo gr on trds.id_grupo = gr.id and gr.id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $idg);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function set($arrData) {
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        foreach ($arrData[1] as $cla => $val) {
            $sql = "insert into tarifa_destino (id_destino, id_grupo, id_tarifa, precio) 
                    values ($cla, NULL, $arrData[0], $val)";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        $cnn = NULL;
    }

}
/*$mdl = new Mdl_Billing("Dstswitch");
$arr[0] = "Pacientes";
$res = $mdl->selectByName($arr);
echo var_dump($res);*/
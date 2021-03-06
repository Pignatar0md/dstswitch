<?php

if (file_exists('../config.php')) {
    $z = '../config.php';
} else {
    $z = '/var/www/html/dstswitch/config.php';
}
//echo $z;
include $z;

/**
 * Description of Mdl_Pin
 *
 * @author marcelo
 */
class Mdl_Pin {

    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insertFromCsv($file) {
        $fileLoc = fopen($file, 'r');
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $res = '';
        while (!feof($fileLoc)) {
            try {
                $linea = fgets($fileLoc);
                $linea = explode(',', $linea);
                $sql = "insert into pin(pinNumber, pinName) values(:pin, :desc)";
                $query = $cnn->prepare($sql);
                if ($linea[0] && $linea[1]) {
                    $query->bindParam(":pin", $linea[0]);
                    $query->bindParam(":desc", trim($linea[1]));
                    $query->execute();
                }
                $res = $query->fetchAll();
            } catch (PDOException $ex) {
                $res = $ex->getMessage();
            }
        }
        fclose($fileLoc);
        unlink($file);
        $cnn = NULL;
        return $res;
    }

    function insert($arrData) {
        $sql = "insert into pin (pinNumber, pinName, id_grupo) values(:pin, :desc, :groupid)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":pin", $arrData[0]);
            $query->bindParam(":desc", $arrData[1]);
            $query->bindParam(":groupid", $arrData[2]);
            $query->execute();
            if($query->errorCode()) {
                $result = $query->errorCode();
            }
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getCode();
        }
        return $result;
    }

    function update($arrData) {
        $sql = "update pin set pinNumber = :pin, pinName = :desc "
                . "where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $arrData[0]);
            $query->bindParam(':pin', $arrData[1]);
            $query->bindParam(':desc', $arrData[2]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function delete($arrData) {
        $sql = "delete from pin where id = :id";
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
        $sql = "select * from pin";
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
    
    function selectGroupId($arrData) { // usado para DstAGI
        $sql = "select id_grupo
                    from pin where pinNumber = :pin";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":pin", $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function selectList() {
        $sql = "select id, pinNumber, pinName from pin";
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
        $sql = "select * from pin where id = :id";
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
    
    function selectNameByPin($arrData) {
        $sql = "select pinName from pin where pinNumber = :pin";
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

}
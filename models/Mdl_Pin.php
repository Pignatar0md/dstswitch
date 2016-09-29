<?php

if (file_exists('../config.php')) {
    $z = '../config.php';
} else {
    $z = '/var/www/html/DstSwitch/config.php';
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
                $sql = "insert into pin(pin, description) values(:pin, :desc)";
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
        $sql = "insert into pin (pin, description) values(:pin, :desc)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":pin", $arrData[0]);
            $query->bindParam(":desc", $arrData[1]);
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
        $sql = "update pin set pin = :pin, description = :desc "
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

}

//$a = new Mdl_Pin('dstswitch');
//$arrData[0] = '2312313123';
//$arrData[1] = 'Juana';
//$file = "/var/www/html/DstSwitch/tmpCsvFile.csv";
//$res = $a->insertFromCsv($file);
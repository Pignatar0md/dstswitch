<?php
include_once '../config.php';
/**
 * Description of Mdl_Destiny
 *
 * @author marcelo
 */
class Mdl_Destiny {
    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insert($arrData) {
        $sql = "insert into destiny(description) values(:desc)";
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
        $sql = "update destiny set description = :desc where id = :id ";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":desc", $arrData[1]);
            $query->bindParam(":id", $arrData[0]);
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
    
    function selectDstByPin($arrData) {
        $sql = "select dst.description as destino, perf.id as idPerf, perf.description as nomPerf 
                from profile perf join grupo gr on perf.id = gr.id_profile join profile_destiny pd 
                on perf.id = pd.id_profile join destiny dst on pd.id_destiny = dst.id
                and :pin IN (select p.pin from pin p)";
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

    function selectDstByExt($arrData) {
        $sql = "select dst.description as destino, perf.id as idPerf, perf.description as nomPerf 
                from profile perf join grupo gr on perf.id = gr.id_profile join profile_destiny pd 
                on perf.id = pd.id_profile join destiny dst on pd.id_destiny = dst.id
                and :ext IN ($arrData[1])";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':ext', $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
}

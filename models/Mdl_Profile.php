<?php

include_once '../config.php';

/**
 * Description of Mdl_Profile
 *
 * @author marcelo
 */
class Mdl_Profile {

    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insert($arrData) {
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $sql = "BEGIN";
        $query = $cnn->prepare($sql);
        $query->execute();

        $sql = "insert into profile(description) values(:desc)";
        $query = $cnn->prepare($sql);
        $query->bindParam(":desc", $arrData[0]);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $sql = "select id from profile where description = :desc";
        $query = $cnn->prepare($sql);
        $query->bindParam(":desc", $arrData[0]);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $idprofile = '';
        foreach ($result as $cla => $val) {
            if (is_array($val)) {
                foreach ($val as $c => $v) {
                    $idprofile = $v;
                }
            } else {
                $idprofile = $val;
            }
        }
        foreach ($arrData[1] as $cla => $val) {
            $sql = "insert into profile_destiny(id_profile, id_destiny) values(:idp, :idd)";
            $query = $cnn->prepare($sql);
            $query->bindParam(":idp", $idprofile);
            $query->bindParam(":idd", $val);
            $res = $query->execute();
        }

        $sql = "COMMIT";
        $query = $cnn->prepare($sql);
        $query->execute();
        if ($res) {
            $sql = "ROLLBACK";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        $cnn = NULL;
        return $res;
    }

    /* function update($arrData) {
      $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
      $sql = "BEGIN";
      $query = $cnn->prepare($sql);
      $query->execute();

      $sql = "update profile set description = :desc where id = :id";
      $query = $cnn->prepare($sql);
      $query->bindParam(":id", $arrData[0]);
      $query->bindParam(":desc", $arrData[1]);
      $query->execute();


      foreach ($arrData[2] as $val) {
      $sql = "update profile_destiny set id_destiny = :idd where id = :id";
      $query = $cnn->prepare($sql);
      $query->bindParam(":id", $arrData[0]);
      $query->bindParam(":desc", $val);
      $res = $query->execute();
      }
      $sql = "COMMIT";
      $query = $cnn->prepare($sql);
      $query->execute();
      if ($res) {
      $sql = "ROLLBACK";
      $query = $cnn->prepare($sql);
      $query->execute();
      }
      $cnn = NULL;
      return $result;
      } */

    function delete($arrData) {
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $sql = "BEGIN";
        $query = $cnn->prepare($sql);
        $query->execute();

        /*$sql = "delete from profile where id = :id";
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $arrData[0]);
        $query->execute();*/

        $sql = "delete from profile_destiny where id = :idpd";
        $query = $cnn->prepare($sql);
        //$query->bindParam(':idp', $arrData[0]);
        $query->bindParam(':idpd', $arrData[0]);
        $query->execute();
        $sql = "COMMIT";
        $query = $cnn->prepare($sql);
        $res = $query->execute();
        if ($res) {
            $sql = "ROLLBACK";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        $cnn = NULL;
        return $result;
    }

    function select() {
        $sql = "select p.id as pid, pd.id as pdid, p.description as perfil, d.description as destino 
            from profile p right join profile_destiny pd on p.id =  pd.id_profile 
                join destiny d on pd.id_destiny = d.id and p.id is not null order by perfil";
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

    function selectAll() {
        $sql = "select * from profile";
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
        $sql = "select p.id,pd.id_destiny, d.description as ddescr, p.description as pdescr from profile p 
                join profile_destiny pd on p.id = pd.id_profile 
                join destiny d on d.id = pd.id_destiny and p.id = :id";
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

/*$modelo = new Mdl_Profile("dstswitch");
$arrayDatos[0] = 'provincia';
$arrD = array();
for ($a = 1; $a <= 3; $a++) {
    $arrD[$a] = $a;
}
$arrayDatos[1] = $arrD;
$res = $modelo->insert($arrayDatos);
echo $res;*/
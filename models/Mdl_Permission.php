<?php

include_once '../config.php';

/**
 * Description of Mdl_Permission
 *
 * @author marcelo
 */
class Mdl_Permission {

    //put your code here
    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }

    function insert($arrData) {
        $sql = "insert into permission(pin_list, id_profile, id_group, description, extension_list) "
                . "values(:pinlist, :profid, :groupid, :desc, :extlist)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":pinlist", $arrData[0]);
            $query->bindParam(":profid", $arrData[1]);
            $query->bindParam(":groupid", $arrData[2]);
            $query->bindParam(":desc", $arrData[3]);
            $query->bindParam(":extlist", $arrData[4]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function update($arrData) {
        $sql = "update permission set pin_list = :pinlist, id_profile = :idp, id_group = :idg, "
                . "extension_list = :extlist, description = :desc where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->bindParam(":idp", $arrData[1]);
            $query->bindParam(":idg", $arrData[2]);
            $query->bindParam(":desc", $arrData[3]);
            $query->bindParam(":extlist", $arrData[4]);
            $query->bindParam(":pinlist", $arrData[5]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function delete($arrData) {
        $sql = "delete from permission where id = :id";
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
        $sql = "select perm.id, perm.description as permiso, pro.description as perfil, g.description as grupo, 
                perm.extension_list as ext, perm.pin_list as pin
                from profile pro right join permission perm on pro.id = perm.id_profile 
                left join grupo g on g.id = perm.id_group";
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
        $sql = "select perm.id, perm.description as permiso, pro.id as perfil, g.id as grupo, 
                perm.extension_list as ext, perm.pin_list as pin
                from profile pro join permission perm on pro.id = perm.id_profile 
                join grupo g on g.id = perm.id_group and perm.id = :id";
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

//$mdl = new Mdl_Permission('dstswitch');
//$arrData[0] = 1;
//$arrData[1] = 1;
//$arrData[2] = 2;
//$arrData[3] = "A";
//$arrData[4] = "1,2,3";
//$arrData[5] ="1,2";
//$mdl->update($arrData);

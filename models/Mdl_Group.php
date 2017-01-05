<?php

include_once '../config.php';
include_once '../helpers/bd_helper.php';

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
        $sql = "insert into grupo (descr) "
                . "values(:descr)";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":descr", $arrData[0]);
            $result = $query->execute();
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function set($arrData) {
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $sql = "BEGIN";
        $query = $cnn->prepare($sql);
        $query->execute();

        foreach ($arrData[1] as $cla => $val) {
            $sql = "insert into grupo_exten (id_grupo, exten) values ($arrData[0], '$val')";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        foreach ($arrData[2] as $cla => $val) {
            $sql = "insert into grupo_dest (id_grupo, id_dest) values ($arrData[0], $val)";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        foreach ($arrData[3] as $cla => $val) {
            $sql = "update pin set id_grupo = $arrData[0] where id = $val";
            $query = $cnn->prepare($sql);
            $res = $query->execute();
        }

        $sql = "insert into tarifaDestino_grupo (id_tarifaDestino, id_grupo) 
                values ($arrData[4], $arrData[0])";
        $query = $cnn->prepare($sql);
        $res = $query->execute();

        if ($res == 1) {
            $sql = "COMMIT";
        } else {
            $sql = "ROLLBACK";
        }
        $query = $cnn->prepare($sql);
        $query->execute();
        $cnn = NULL;
        return $res;
    }

    function Quit($fromDB, $toDB) {
        //quita de bd si valor (que viene de user) no se encuentra en toBD
        $arrQuit = array();
        foreach ($fromDB as $clave => $valor) {
            if (!(in_array($valor, $toDB))) {
                $arrQuit[] = $valor;
            }
        }
        return $arrQuit;
    }

    function Add($fromDB, $toDB) {
        //agrega a bd si valor (que viene de user) no se encuentra en fromBD
        $arrAdd = array();
        foreach ($toDB as $clave => $valor) {
            if (!(in_array($valor, $fromDB))) {
                $arrAdd[] = $valor;
            }
        }
        return $arrAdd;
    }

    function update($arrData) {
        $id = $arrData[0];
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $sql = "update grupo set descr = :desc where id = :id";
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $id);
        $query->bindParam(":desc", $arrData[1]);
        $query->execute();
        $sql = "select exten from grupo_exten where id_grupo = :id";
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $id);
        $query->execute();
        $Extens = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($Extens) {
            foreach ($Extens as $clave => $valor) {
                foreach ($valor as $cla => $val) {
                    $valorsDeBD[] = $val;
                }
            }
            $arrQuitExt = $this->Quit($valorsDeBD, $arrData[4]);
            $arrAddExt = $this->Add($valorsDeBD, $arrData[4]);
            foreach ($arrQuitExt as $cla => $val) {
                $sql = "delete from grupo_exten where exten = :Ext and id_grupo = :id";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Ext", $val);
                $query->execute();
            }
            foreach ($arrAddExt as $cla => $val) {
                $sql = "replace into grupo_exten set exten = :Ext, id_grupo = :id";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Ext", $val);
                $query->execute();
            }
        } else {
            foreach ($arrData[4] as $cla => $val) {
                $sql = "insert into grupo_exten (exten, id_grupo) values (:Ext,:id)";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Ext", $val);
                $query->execute();
            }
        }
        $sql = "select id_dest from grupo_dest where id_grupo = :id";
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $id);
        $query->execute();
        $Dests = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($Dests) {
            foreach ($Dests as $clave => $valor) {
                foreach ($valor as $cla => $val) {
                    $valorsDeBD[] = $val;
                }
            }
            $arrQuitDst = $this->Quit($valorsDeBD, $arrData[3]);
            $arrAddDst = $this->Add($valorsDeBD, $arrData[3]);
            foreach ($arrQuitDst as $cla => $val) {
                $sql = "delete from grupo_dest where id_dest = :Dst and id_grupo = :id";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Dst", $val);
                $query->execute();
            }
            foreach ($arrAddDst as $cla => $val) {
                $sql = "replace into grupo_dest set id_dest = :Dst, id_grupo = :id";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Dst", $val);
                $query->execute();
            }
        } else {
            foreach ($arrData[3] as $cla => $val) {
                $sql = "insert into grupo_dest (id_dest,id_grupo) values(:Dst,:id)";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $id);
                $query->bindParam(":Dst", $val);
                $query->execute();
            }
        }
        $sql = "select id from pin where id_grupo = :id";
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $id);
        $query->execute();
        $Pines = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($Pines) {
            foreach ($Pines as $clave => $valor) {
                if (is_array($valor)) {
                    $arrQuitPin = $this->Quit($valor, $arrData[2]);
                    $arrAddPin = $this->Add($valor, $arrData[2]);
                }
            }

            foreach ($arrQuitPin as $cla => $val) {
                $sql = "update pin set id_grupo = null where id = :id";
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $val);
                $query->execute();
            }
            foreach ($arrAddPin as $cla => $val) {
                $sql = "update pin set id_grupo = :idg where id = :idp";
                $query = $cnn->prepare($sql);
                $query->bindParam(":idg", $id);
                $query->bindParam(":idp", $val);
                $query->execute();
            }
        } else {
            foreach ($arrData[2] as $cla => $val) {
                $sql = "update pin set id_grupo = :idg where id = :idp";
                $query = $cnn->prepare($sql);
                $query->bindParam(":idg", $id);
                $query->bindParam(":idp", $val);
                $query->execute();
            }
        }$sql = "update tarifaDestino_grupo set id_tarifaDestino = :idtd where id_grupo = :idg";
        $query = $cnn->prepare($sql);
        $query->bindParam(":idg", $id);
        $query->bindParam(":idtd", $arrData[5]);
        $query->execute();
        $cnn = NULL;
    }

    function delete($arrData) {
        $sql = "delete from tarifaDestino_grupo where id_grupo = :id";
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
        $sql = "update grupo_dest set id_grupo = null where id_grupo = :id";
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
        $sql = "update grupo_exten set id_grupo = null where id_grupo = :id";
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
        $sql = "update pin set id_grupo = null where id_grupo = :id";
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
        
    }

    function select() { // usado para el list group
        $sql = "select gr.id as id, gr.descr as descr
                 from grupo gr";
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
                    from grupo_exten where exten = :exten";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":exten", $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function selectCmb() { // usado para el list group
        $sql = "select id, descr from grupo";
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

    function selectByName($arrData) {// usado en la creacion del grupo para el setting inicial
        $sql = "select id from grupo where descr = :descr";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(':descr', $arrData[0]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function selectById($arrData) { // usado para mostrar los datos para la edicion del grupo
        $resultArr = array();
        $id = $arrData[0];
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $sql = "select gr.descr as groupName, grex.exten
                            from  grupo gr left join grupo_exten grex on gr.id = grex.id_grupo
                            where gr.id = :id";
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            $resultArr[0] = $query->fetchAll(PDO::FETCH_ASSOC);
            $sql = "select p.id as pinId,p.pinName as pinName 
                            from pin p join grupo gr on gr.id = p.id_grupo 
                            where gr.id = :id";
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            $resultArr[1] = $query->fetchAll(PDO::FETCH_ASSOC);
            $sql = "select dst.id as destId,dst.descr as destName  
                            from destiny dst join grupo_dest grds on dst.id = grds.id_dest
                            join grupo gr on grds.id_grupo = gr.id 
                            where gr.id = :id";
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            $resultArr[2] = $query->fetchAll(PDO::FETCH_ASSOC);
            $sql = "select id_tarifa from tarifa_destino td join tarifaDestino_grupo tDg on 
                           td.id_tarifa = tDg.id_tarifaDestino and tDg.id_grupo = :id";
            $query = $cnn->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
            $resultArr[3] = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $resultArr;
    }

}

/*$mld = new Mdl_Group('Dstswitch');
$arrData[0] = "bla";
$res = $mld->insert($arrData);
echo var_dump($res);*/

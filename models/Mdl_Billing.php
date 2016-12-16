<?php

include_once '/var/www/html/dstswitch/config.php';
include_once '/var/www/html/dstswitch/entities/Billing_Destiny.php';

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

    function delete($arrData) {
        $sql = "delete from tarifa_destino where id_tarifa = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->execute();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        $sql = "delete from tarifa where id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arrData[0]);
            $query->execute();
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        $cnn = NULL;
    }

    function CopyCDR() {
        $sql = "select calldate, src, dst, billsec, accountcode, uniqueid, groupid from cdr
                where calldate = curdate()";
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $query = $cnn->prepare($sql);
        $result = $query->execute();
        return $result;
    }
    
    function PasteCDR($arrData) {
        $sql = "insert into mycdr(calldate, src, dst, billsec, accountcode, uniqueid, groupid, amount) "
                . "values(:calldate, :src, :dst, :billsec, :accountcode, :uniqueid, :groupid, NULL)";
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $query = $cnn->prepare($sql);
        $query->bindParam(":calldate", $arrData[0]);
        $query->bindParam(":src", $arrData[1]);
        $query->bindParam(":dst", $arrData[2]);
        $query->bindParam(":billsec", $arrData[3]);
        $query->bindParam(":accountcode", $arrData[4]);
        $query->bindParam(":uniqueid", $arrData[5]);
        $query->bindParam(":groupid", $arrData[6]);
        $query->execute();
    }
    
    function updateAmount($price, $phone) {
        $sql = "update mycdr set amount = :totalCost where src =:src ";
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $query = $cnn->prepare($sql);
        $query->bindParam(":totalCost", $price);
        $query->bindParam(":src", $phone);
        $query->execute();
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
        // Actualizo la descripcionde la tarifa
        $sql = "update tarifa set descr = :descr where id = :id";
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $arrData[0]);
        $query->bindParam(":descr", $arrData[1]);
        $query->execute();
        $cnn = NULL;
        // Traigo los destinos de la tabla tarifa_destino para una tarifa especifica
        $sql = "select trds.id_destino from tarifa_destino trds join tarifa trf 
                on trds.id_tarifa = trf.id and trds.id_tarifa = :id";
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        $query = $cnn->prepare($sql);
        $query->bindParam(":id", $arrData[0]);
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $cnn = NULL;
        if ($res) {// SI TRAE DESTINOS........
            foreach ($res as $clave => $valor) {
                foreach ($valor as $cla => $val) {
                    $valorsDeBD[] = $val;
                }
            }
            $arrQuit = $this->Quit($valorsDeBD, $arrData[3]); //Trae valores que se deberian quitar
            $arrAdd = $this->Add($valorsDeBD, $arrData[3]); //Trae valores que se deberian agregar
            //Quito destinos a tarifas
            foreach ($arrQuit as $cla => $val) {
                $sql = "delete from tarifa_destino where id_destino = :id_dest and id_tarifa = :id";
                $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
                $query = $cnn->prepare($sql);
                $query->bindParam(":id", $arrData[0]);
                $query->bindParam(":id_dest", $val);
                $query->execute();
                $cnn = NULL;
            }
            //Agrego destinos a tarifas
            foreach ($arrAdd as $cla => $val) {
                foreach ($arrData[2] as $clave => $valor) {
                    if ($val == $clave) {
                        $sql = "replace into tarifa_destino(id_destino,id_tarifa,precio) "//o replace
                                . "values(:id_dest,:id_tar,:precio)";
                        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
                        $query = $cnn->prepare($sql);
                        $query->bindParam(":id_tar", $arrData[0]);
                        $query->bindParam(":id_dest", $clave);
                        $query->bindParam(":precio", $valor);
                        $query->execute();
                        $cnn = NULL;
                    }
                }
            }
        } else {// SI NO TRAE DESTINOS......
            foreach ($arrData[2] as $cla => $val) {
                $sql = "insert into tarifa_destino(id_destino,id_tarifa,precio,precio_minimo,tiempo_precio_minimo) "
                        . "values(:id_dest,:id_tar,:precio,:min_price,:time_min_price)";
                $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
                $query = $cnn->prepare($sql);
                $query->bindParam(":id_tar", $arrData[0]);
                $query->bindParam(":id_dest", $cla);
                $query->bindParam(":precio", $val);
                $query->execute();
                $cnn = NULL;
            }
        }
        foreach ($arrData[2] as $cla => $val) {
            $sql = "update tarifa_destino set precio = :price "
                    . "where id_destino = :id_dest and id_tarifa = :id_tar";
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id_tar", $arrData[0]);
            $query->bindParam(":id_dest", $cla);
            $query->bindParam(":price", $val);
            $query->execute();
            $cnn = NULL;
        }
        foreach ($arrData[4] as $cla => $val) {
            $sql = "update tarifa_destino set precio_minimo = :min_price "
                    . "where id_destino = :id_dest and id_tarifa = :id_tar";
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id_tar", $arrData[0]);
            $query->bindParam(":id_dest", $cla);
            $query->bindParam(":min_price", $val);
            $query->execute();
            $cnn = NULL;
        }
        foreach ($arrData[5] as $cla => $val) {
            $sql = "update tarifa_destino set tiempo_precio_minimo = :time_min_price "
                    . "where id_destino = :id_dest and id_tarifa = :id_tar";
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id_tar", $arrData[0]);
            $query->bindParam(":id_dest", $cla);
            $query->bindParam(":time_min_price", $val);
            $query->execute();
            $cnn = NULL;
        }
        //      return $sql;
        $cnn = NULL;
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
    
    function getMinimalPrice($arrData) {
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $sql = "select precio_minimo from tarifa_destino 
                where id_destino = :Idd and id_grupo = :idg";
            $query = $cnn->prepare($sql);
            $query->bindParam(":idg", $arrData[0]);
            $query->bindParam(":Idd", $arrData[1]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    
    function getTimeMinimalPrice($arrData) {
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $sql = "select tiempo_precio_minimo from tarifa_destino 
                where id_destino = :Idd and id_grupo = :idg";
            $query = $cnn->prepare($sql);
            $query->bindParam(":idg", $arrData[0]);
            $query->bindParam(":Idd", $arrData[1]);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }

    function selectById($arr) {
        $sql = "SELECT trf.descr, trds.id_destino, trds.precio, trds.precio_minimo, trds.tiempo_precio_minimo
                FROM tarifa trf join tarifa_destino trds on trf.id = trds.id_tarifa 
                where trf.id = :id";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->bindParam(":id", $arr[0]);
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
        $sql = "SELECT distinct trf.descr  as billName FROM tarifa trf join tarifa_destino trds on trf.id = trds.id_tarifa join grupo gr on trds.id_grupo = gr.id and gr.id = :id";
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

    function set($ArrBillDestObj) {
        $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
        foreach ($ArrBillDestObj as $ObjBillDest) {
            $BllDst = $ObjBillDest;
            $sql = "insert into tarifa_destino (id_destino, 
                                                id_grupo, 
                                                id_tarifa, 
                                                precio, 
                                                precio_minimo, 
                                                tiempo_precio_minimo) 
                                        values (".$BllDst->getDest_id().","
                                                 .$BllDst->getGroup_id().","
                                                 .$BllDst->getBilling_id().","
                                                 .$BllDst->getMinute_price().","
                                                 .$BllDst->getMinimal_price().","
                                                 .$BllDst->getTime_minimal_price().")";
            $query = $cnn->prepare($sql);
            $query->execute();
        }
        $cnn = NULL;
    }
}

//$mdl = new Mdl_Billing("Dstswitch");
//$arr[0] = 15;
//$arr[1] = 'Paciente';
// forma normal
//$arr[2] = array(1 => "0.90", 2 => "2.40", 3=> "4.30", 6=> "0.40");
//$arr[3] = array(1, 2, 3, 6);
// quito 6 
//$arr[2] = array(1 => "0.90", 2 => "2.40", 3=> "4.30");
//$arr[3] = array(1, 2, 3);
// agrego 5
//$arr[2] = array(1 => "0.90", 2 => "2.40", 3=> "4.30", 6=> "0.40", 5 => '3.7');
//$arr[3] = array(1, 2, 3, 6, 5);
//$res = $mdl->update($arr);
//echo var_dump($res);
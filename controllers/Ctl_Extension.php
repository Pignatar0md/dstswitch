<?php

include_once '/var/www/html/dstswitch/models/Mdl_Extension.php';

/**
 * Description of Ctl_Exension
 *
 * @author marcelo
 */
class Ctl_Exension {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Extension('asterisk');
    }

    //put your code here
    function agregar($arr) {
        $res = $this->mdl->insert($arr);
        return $res;
    }

    function eliminar($arr) {
        $res = $this->mdl->delete($arr);
        return $res;
    }

    function traer() {
        $res = $this->mdl->select();
        return $res;
    }
    
    function traer2() {
        $res = $this->mdl->select2();
        return $res;
    }

    function traerPorId($arr) {
        $res = $this->mdl->selectById($arr);
        return $res;
    }

    function actualizar($arr) {
        $res = $this->mdl->update($arr);
        return $res;
    }

}

$operation =  isset($_POST['op']) ? $_POST['op'] : '';
$ctlExt = new Ctl_Exension();
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    switch ($operation) {
        case "getAllExt":
            $res = $ctlExt->traer();
            $res2 = $ctlExt->traer2();
            $cadena = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "extension") {
                            $cadena .= "<option value='$v'>$v";
                        } else {
                            $cadena .= " ($v)</option>";
                        }
                    }
                }
            }
            foreach ($res2 as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "extension") {
                            $cadena .= "<option value='$v'>$v";
                        } else {
                            $cadena .= " ($v)</option>";
                        }
                    }
                }
            }
            echo $cadena;
            break;
    }
}
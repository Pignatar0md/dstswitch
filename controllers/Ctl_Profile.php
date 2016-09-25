<?php

include '../models/Mdl_Profile.php';

/**
 * Description of Ctl_Profile
 *
 * @author marcelo
 */
class Ctl_Profile {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Profile('dstswitch');
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

    function traerTodo() {
        $res = $this->mdl->selectAll();
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

$operation = $_POST['op'];
if (!$operation) {
    $jsonGet = json_decode($_GET['json'], true);
    $operation = $jsonGet['op'];
}
$ctlProf = new Ctl_Profile();
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    switch ($operation) {
        case "getAllProfile":
            $res = $ctlProf->traerTodo();
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $cadena .= "<option value='" . $v . "'>";
                        } elseif ($k == "description") {
                            $cadena .= $v . "</option>";
                        }
                        echo $cadena;
                    }
                }
            }
            break;
        case "getProfileList":
            $res = $ctlProf->traer();
            $cadena = "";
            $pid = '';
            $pdid = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "pid") {
                            $pid = $v;
                        } elseif ($k == "pdid") {
                            $pdid = $v;
                        } elseif ($k == "perfil") {
                            $cadena .= '<tr><td>' . $v . '</td>';
                        } elseif ($k == "destino") {
                            $cadena .= '<td>' . $v . '</td><td style="text-align:center">
                        <a class="eliminar" id=' . $pdid . ' placeholder="eliminar">
                            <input type="hidden" id="' . $pid . '"/>
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        </td></tr>';
                        }
                    }
                }
            }
            $cadena = substr($cadena, 0, -1);
            echo $cadena;
            break;
        case "saveProfile":
            $arrayDatos[0] = $jsonGet['name'];
            $arrayDatos[1] = $jsonGet['dst'];
            $res = $ctlProf->agregar($arrayDatos);
            echo $res;
            break;
        case "deleteProfile":
            //$arrayDatos[0] = $_POST['pid'];
            $arrayDatos[0] = $_POST['pdid'];
            $res = $ctlProf->eliminar($arrayDatos);
            echo $res;
            break;
    }
}
$id = $_GET['pid'];
$jsonStr = '{';
$jsonStrDST = '';
if ($id) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = str_replace("'", "", $value);
        $_GET[$key] = str_replace('"', '', $value);
    }
    $arr[0] = $id;
    $res = $ctlProf->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "id_destiny") {
                    $jsonStrDST .= '{"id":"' . $v . '",';
                } else if ($k == "ddescr") {
                    $jsonStrDST .= '"name":"' . $v . '"},';
                } else if ($k == "pdescr") {
                    $jsonStr .= '"pdescr":"' . $v . '",';
                }
            }
        }
    }
    echo $jsonStr . '"destiny":[' . substr($jsonStrDST, 0, -1) . ']}';
}
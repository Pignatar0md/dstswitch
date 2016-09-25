<?php

include '../models/Mdl_Destiny.php';

/**
 * Description of Ctl_Destiny
 *
 * @author marcelo
 */
class Ctl_Destiny {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Destiny('dstswitch');
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
$ctlDest = new Ctl_Destiny();
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    switch ($operation) {
        case "getAllDest":
            $res = $ctlDest->traer();
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
        case "getDestList":
            $res = $ctlDest->traer();
            $cadena = "";
            $id = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "id") {
                            $cadena .= '<tr><td>' . $v . '</td><td>';
                            $id = $v;
                        } elseif ($k == "description") {
                            $cadena .= $v . '</td><td style="text-align:center">
                        <a href="index.php?page=EditDestiny&id=' . $id . '" placeholder="editar">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a id="' . $id . '" class="eliminar" placeholder="eliminar">
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
        case "saveDestiny":
            $arrDest[] = $_POST["name"];
            if (count($arrDest)) {
                $res = $ctlDest->agregar($arrDest);
            }
            echo $res;
            break;
        case "updateDest":
            if (isset($_POST['id']) && isset($_POST['name'])) {
                $arr[0] = $_POST['id'];
                $arr[1] = $_POST['name'];
                $res = $ctlDest->actualizar($arr);
            }
            echo $res;
            break;
        case "deleteDest":
            $arr[0] = $_POST['id'];
            $res = $ctlDest->eliminar($arr);
            echo $res;
            break;
    }
}
$id = $_GET['id'];
$jsonStr = '{';
if ($id) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = str_replace("'", "", $value);
        $_GET[$key] = str_replace('"', '', $value);
    }
    $arr[0] = $id;
    $res = $ctlDest->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "id") {
                    $jsonStr .= '"id":"' . $v . '",';
                } else if ($k == "description") {
                    $jsonStr .= '"name":"' . $v . '"}';
                }
            }
        }
    }
    echo $jsonStr;
}
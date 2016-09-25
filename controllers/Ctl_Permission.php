<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
include '../models/Mdl_Permission.php';

/**
 * Description of Ctl_Permission
 *
 * @author marcelo
 */
class Ctl_Permission {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Permission('dstswitch');
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
if (!$operation) {
    $jsonGet = json_decode($_GET['json'], true);
    $operation = $jsonGet['op'];
}
$ctlPerm = new Ctl_Permission();
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    switch ($operation) {
        case "getPermissionList":
            $res = $ctlPerm->traer();
            $id = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $id = $v;
                        } elseif ($k == "permiso") {
                            $cadena .= '<tr><td>' . $v . '</td>';
                        } elseif ($k == "perfil") {
                            $cadena .= '<td>' . $v . '</td>';
                        } elseif ($k == "grupo") {
                            $cadena .= '<td>' . $v . '</td>';
                        } elseif ($k == "ext") {
                            $v = explode(',', $v);
                            for ($f = 0; $f < count($v); $f++) {
                                $subCadena .= '<span class="label label-primary">' . $v[$f] . '</span> ';
                            }
                            $cadena .= '<td>' . $subCadena . '</td>';
                            $subCadena = null;
                        } elseif ($k == "pin") {
                            $v = explode(',', $v);
                            for ($f = 0; $f < count($v); $f++) {
                                $subCadena .= '<span class="label label-warning">' . $v[$f] . '</span> ';
                            }
                            $cadena .= '<td>' . $subCadena . '</span></td><td style="text-align:center">
                        <a href="index.php?page=EditPermission&id=' . $id . '" placeholder="editar">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a class="eliminar" id="' . $id . '" placeholder="eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        </td></tr>';
                            $subCadena = null;
                        }
                        echo $cadena;
                    }
                }
            }
            break;
        case "savePermission":
            $arrayDatos[0] = implode(",", $jsonGet['pins']);
            $arrayDatos[1] = $jsonGet['profile'];
            $arrayDatos[2] = $jsonGet['group'];
            $arrayDatos[3] = $jsonGet['name'];
            $arrayDatos[4] = implode(",", $jsonGet['extensions']);
            $res = $ctlPerm->agregar($arrayDatos);
            echo $res;
            break;
        case "updatePermission":
            $arrayDatos[0] = $jsonGet['id'];
            $arrayDatos[1] = $jsonGet['idp'];
            $arrayDatos[2] = $jsonGet['idg'];
            $arrayDatos[3] = $jsonGet['name'];
            $arrayDatos[4] = implode(",", $jsonGet['ext']);
            $arrayDatos[5] = implode(",", $jsonGet['pin']);
            $res = $ctlPerm->actualizar($arrayDatos);
            echo json_encode($res);
            break;
        case "deletePermission":
            $arr[0] = $_POST['id'];
            $res = $ctlPerm->eliminar($arr);
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
    $res = $ctlPerm->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "permiso") {
                    $jsonStr .= '"name":"' . $v . '",';
                } elseif ($k == "perfil") {
                    $jsonStr .= '"idprofile":"' . $v . '",';
                } elseif ($k == "grupo") {
                    $jsonStr .= '"idgroup":"' . $v . '",';
                } elseif ($k == "ext") {
                    $jsonStr .= '"extlist":"' . $v . '",';
                } elseif ($k == "pin") {
                    $jsonStr .= '"pinlist":"' . $v . '",';
                }
            }
        }
    }
    echo substr($jsonStr, 0, -1) . '}';
}
<?php

include '../models/Mdl_Group.php';

/**
 * Description of Ctl_Group
 *
 * @author marcelo
 */
class Ctl_Group {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Group('dstswitch');
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
$ctlGroup = new Ctl_Group();
if (!$operation) {
    $jsonGet = json_decode($_GET['json'], true);
    $operation = $jsonGet['op'];
}
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    switch ($operation) {
        case "getAllGroup":
            $res = $ctlGroup->traer();
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $cadena .= "<option value='" . $v . "'>";
                        } else if ($k == "description") {
                            $cadena .= $v . "</option>";
                        }
                        echo $cadena;
                    }
                }
            }
            break;
        case "getGroupList":
            $res = $ctlGroup->traer();
            $id = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $id = $v;
                        } elseif ($k == "description") {
                            $cadena .= "<tr><td>" . $v . "</td>";
                        } else if ($k == "extension_list") {
                            $v = explode(',', $v);
                            for ($f = 0; $f < count($v); $f++) {
                                $subCadena .= '<span class="label label-primary">' . $v[$f] . '</span> ';
                            }
                            $cadena .= '<td>' . $subCadena . '</td>';
                            $subCadena = null;
                        } elseif ($k == "pin_list") {
                            $v = explode(',', $v);
                            for ($f = 0; $f < count($v); $f++) {
                                $subCadena .= '<span class="label label-warning">' . $v[$f] . '</span> ';
                            }
                            $cadena .= '<td>' . $subCadena . '</span></td><td style="text-align:center">
                        <a href="index.php?page=EditGroup&id=' . $id . '" placeholder="editar">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a id="' . $id . '" class="eliminar" placeholder="eliminar">
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
        case "saveGroup":
            $arrayDatos[0] = $jsonGet['name'];
            $arrayDatos[1] = implode(",", $jsonGet['ext']);
            $arrayDatos[2] = implode(",", $jsonGet['pin']);
            $arrayDatos[3] = $jsonGet['profid'];
            $res = $ctlGroup->agregar($arrayDatos);
            return $res;
            break;
        case "updateGroup":
            $arrayDatos[0] = $jsonGet['id'];
            $arrayDatos[1] = $jsonGet['name'];
            $arrayDatos[2] = implode(",", $jsonGet['ext']);
            $arrayDatos[3] = implode(",", $jsonGet['pin']);
            $res = $ctlGroup->actualizar($arrayDatos);
            echo $res;
            break;
        case 'deleteGroup':
            $arrayDatos[0] = $_POST['id'];
            $res = $ctlGroup->eliminar($arrayDatos);
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
    $res = $ctlGroup->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "description") {
                    $jsonStr .= '"name":"' . $v . '",';
                } elseif ($k == "extension_list") {
                    $jsonStr .= '"extlist":"' . $v . '",';
                } elseif ($k == "pin_list") {
                    $jsonStr .= '"pinlist":"' . $v . '",';
                }
            }
        }
    }
    echo substr($jsonStr, 0, -1) . '}';
}
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
        $this->mdl = new Mdl_Group('Dstswitch');
    }

    function agregar($arr) {
        $res = $this->mdl->insert($arr);
        return $res;
    }

    function configurar($arr) {
        $res = $this->mdl->set($arr);
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

    function traerCombo() {
        $res = $this->mdl->selectCmb();
        return $res;
    }

    function traerPorNom($arr) {
        $res = $this->mdl->selectByName($arr);
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
        case 'confGroup':
            $arrayDatos[0] = $jsonGet['id'];
            $arrayDatos[1] = $jsonGet['ext'];
            $arrayDatos[2] = $jsonGet['dst'];
            $arrayDatos[3] = $jsonGet['pin'];
            $res = $ctlGroup->configurar($arrayDatos);
            echo $res;
            break;
        case "getGroupId":
            $arrDatos[] = $jsonGet['name'];
            $res = $ctlGroup->traerPorNom($arrDatos);
            $jsonStr = '{';
            foreach ($res as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        if ($k == "id") {
                            $jsonStr .= '"id":"' . $v . '",';
                        }
                    }
                }
            }
            echo substr($jsonStr, 0, -1) . '}';
            break;
        case "getAllGroup":
            $res = $ctlGroup->traerCombo();
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $cadena .= "<option value='" . $v . "'>";
                        } else if ($k == "descr") {
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
                        } elseif ($k == "descr") {
                            $cadena .= '<tr><td>' . $v . '</td><td style="text-align:center">
                        <a href="index.php?page=EditGroup&id=' . $id . '" placeholder="editar nombre">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a id="' . $id . '" class="eliminar" placeholder="eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        </td>
                        </tr>';
                        }
                        echo $cadena;
                    }
                }
            }
            break;
        case "saveGroup":
            $arrayDatos[0] = $jsonGet['name'];
            $res = $ctlGroup->agregar($arrayDatos);
            return $res;
            break;
        case "updateGroup":
            $arrayDatos[0] = $jsonGet['id'];
            $arrayDatos[1] = $jsonGet['name'];
            $arrayDatos[2] = $jsonGet['pin'];
            $arrayDatos[3] = $jsonGet['dst'];
            $arrayDatos[4] = $jsonGet['ext'];
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
//$_GET['id'] = 31;
$id = $_GET['id'];
$jsonStr = '{';
if ($id) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = str_replace("'", "", $value);
        $_GET[$key] = str_replace('"', '', $value);
    }
    $arr[0] = $id;
    $res = $ctlGroup->traerPorId($arr);
    $subcadPin = $subcadDst = $subcadExt = '';
    $c=$b=$i=0;
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if(is_array($v)) {
                    foreach ($v as $clave => $valor) {
                        if($clave == "groupName") {
                            $nomGrupo = $valor;
                        } elseif ($clave == "exten") {
                            $subcadExt .= '"'.$i.'":"'.$valor.'",';
                            $i++;
                        } elseif ($clave == "pinId") {
                            $subcadPin .= '"'.$b.'":"'.$valor.'",';
                            $b++;
                        } elseif ($clave == "destId") {
                            $subcadDst .= '"'.$c.'":"'.$valor.'",';
                            $c++;
                        } 
                    }
                }
            }
        }
    }
    $subcadDst = substr($subcadDst, 0, -1);
    $subcadExt = substr($subcadExt, 0, -1);
    $subcadPin = substr($subcadPin, 0, -1);
    $jsonStr .= '"nomgrupo":"'.$nomGrupo.'","extensiones":[{'.$subcadExt.'}],"pines":[{'.$subcadPin.'}],"destinos":[{'.$subcadDst.'}]}';
    echo $jsonStr;
}
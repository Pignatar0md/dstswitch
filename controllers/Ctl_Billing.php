<?php

include '/var/www/html/dstswitch/models/Mdl_Billing.php';
include '../helpers/json_helper.php';

/**
 * Description of Ctl_Destiny
 *
 * @author marcelo
 */
class Ctl_Billing {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Billing('Dstswitch');
    }

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

    function traerPorNom($arr) {
        $res = $this->mdl->selectByName($arr);
        return $res;
    }

    function actualizar($arr) {
        $res = $this->mdl->update($arr);
        return $res;
    }

    function configurar($arr) {
        $res = $this->mdl->set($arr);
        return $res;
    }

}

/* $_POST['op'] = 'saveDestiny';
  $_POST["name"] = "sdsdsdsd"; */

$operation = isset($_POST['op']) ? $_POST['op'] : '';
$ctlBill = new Ctl_Billing();
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
        case "getAllBilling":
            $res = $ctlBill->traer();
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $cadena = "";
                        if ($k == "id") {
                            $cadena .= "<option value='$v'>";
                        } elseif ($k == "descr") {
                            $cadena .= "$v</option>";
                        }
                        echo $cadena;
                    }
                }
            }
            break;
        case "confBilling":
            $arrDatos[0] = $jsonGet['id'];
            $arrDatos[1] = $jsonGet['dest_prec'];
            $res = $ctlBill->configurar($arrDatos);
            echo $res;
            break;
        case "getBillingList":
            $res = $ctlBill->traer();
            $cadena = "";
            $id = '';
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "id") {
                            $cadena .= '<tr><td>' . $v . '</td><td>';
                            $id = $v;
                        } elseif ($k == "descr") {
                            $cadena .= $v . '</td><td style="text-align:center">
              <a href="index.php?page=EditBilling&id=' . $id . '" placeholder="editar">
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
        case "saveBilling":
            $arrDatos[0] = $jsonGet["name"];
            $res = $ctlBill->agregar($arrDatos);
            return;
            $res;
            break;
        case "updateBilling":
            /* if (isset($_POST['id']) && isset($_POST['name'])) {
              $arr[0] = $_POST['id'];
              $arr[1] = $_POST['name'];
              $res = $ctlDest->actualizar($arr);
              }
              echo $res; */
            break;
        case "deleteBilling":
            /* $arr[0] = $_POST['id'];
              $res = $ctlDest->eliminar($arr);
              echo $res; */
            break;
        case "getBillingId":
            $arrDatos[] = $jsonGet['name'];
            $res = $ctlBill->traerPorNom($arrDatos);
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
    }
}
$id = isset($_GET['id']) ? $_GET['id'] : '';
$jsonStr = '{';
if ($id) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = str_replace("'", "", $value);
        $_GET[$key] = str_replace('"', '', $value);
    }
    $arr[0] = $id;
    $res = $ctlBill->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "id") {
                    $jsonStr .= '"id":"' . $v . '",';
                } else if ($k == "descr") {
                    $jsonStr .= '"name":"' . $v . '"}';
                }
            }
        }
    }
    echo $jsonStr;
}
//debug
//$ctl = new Ctl_Destiny();
//$arr[0] = 1003;
//$arr[1] = '1002,1003';
//$res = $ctl->traerDstPorExt($arr);
//echo var_dump($res);
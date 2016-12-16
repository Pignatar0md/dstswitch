<?php

include '/var/www/html/dstswitch/models/Mdl_Billing.php';
include '../helpers/json_helper.php';

/**
 * Description of Ctl_Destiny
 *
 * @author marcelo
 */
class Ctl_Billing {

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

    function traerPrecioMinimo($arr) {
        $res = $this->mdl->getMinimalPrice($arr);
        return $res;
    }

    function traerTiempoPrecioMinimo($arr) {
        $res = $this->mdl->getTimeMinimalPrice($arr);
        return $res;
    }

    function actualizarPrecioTotal($price, $phone) {
        $this->mdl->updateAmount($price, $phone);
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
            $arrObjBillDest = array();
            //---------------------------RECIBIR Y DAR TRATAMIENTO A ARRAY
            $destprec = array_filter($jsonGet['dest_prec'], function($var){return !is_null($var);});
            $minprec = array_filter($jsonGet['min_prec'], function($var){return !is_null($var);});
                                                        //function($value) { return $value !== ''; }
                                                        //create_function('$value', 'return $value !== "";')
            $timeminprec = array_filter($jsonGet['tiempo_min_prec'], function($var){return !is_null($var);});
            //------------------------------------------------------------
            foreach ($destprec as $dest => $price) {
                $objBillDest = new Billing_Destiny($dest, 'NULL', $jsonGet['id'], $price, $minprec[$dest], $timeminprec[$dest]);
                $arrObjBillDest[] = $objBillDest;
            }
            $res = $ctlBill->configurar($arrObjBillDest);
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
            if (isset($jsonGet['id']) && isset($jsonGet['name'])) {
                $arr[0] = $jsonGet['id'];
                $arr[1] = $jsonGet['name'];
                $arr[2] = $jsonGet['dest_prec'];
                $arr[3] = $jsonGet['dsts'];
                $arr[4] = $jsonGet['min_prec'];
                $arr[5] = $jsonGet['tiempo_min_prec'];
                $res = $ctlBill->actualizar($arr);
            }
            echo $res;
            break;
        case "deleteBilling":
            $arr[0] = $_POST['id'];
            $res = $ctlBill->eliminar($arr);
            echo $res;
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
    $i = 0;
    $res = $ctlBill->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "descr") {
                    if ($v != $repetido) {
                        $jsonStr .= '"desc":"' . $v . '",';
                        $repetido = $v;
                    }
                } else if ($k == "id_destino") {
                    $jsonDestStr .= '"' . $i . '":"' . $v . '",';
                    $jsonSubstr .= '"' . $v . '":';
                    $jsonSubstr2 .= '"' . $v . '":';
                    $jsonSubstr3 .= '"' . $v . '":';
                    $i++;
                } else if ($k == "precio") {
                    $jsonSubstr .= '"' . $v . '",';
                } elseif ($k == "precio_minimo") {
                    $jsonSubstr2 .= '"' . $v . '",';
                } elseif ($k == "tiempo_precio_minimo") {
                    $jsonSubstr3 .= '"' . $v . '",';
                }
            }
        }
    }
    $jsonDestStr = substr($jsonDestStr, 0, -1);
    $jsonSubstr = substr($jsonSubstr, 0, -1);
    $jsonSubstr2 = substr($jsonSubstr2, 0, -1);
    $jsonSubstr3 = substr($jsonSubstr3, 0, -1);
    echo $jsonStr . '"destinos_precios":[{' . $jsonSubstr . '}],'
    . '"destinos":[{' . $jsonDestStr . '}],'
    . '"precios_min":[{' . $jsonSubstr2 . '}],'
    . '"tiempo_precios_min":[{' . $jsonSubstr3 . '}]}';
}
//debug
//$ctl = new Ctl_Destiny();
//$arr[0] = 1003;
//$arr[1] = '1002,1003';
//$res = $ctl->traerDstPorExt($arr);
//echo var_dump($res);
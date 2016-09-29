<?php

if (file_exists('../../models/Mdl_Pin.php')) {
    $a = '../../models/Mdl_Pin.php';
} else if (file_exists('../models/Mdl_Pin.php')) {
    $a = '../models/Mdl_Pin.php';
} else {
    $a = '/var/www/html/DstSwitch/models/Mdl_Pin.php';
}
include_once $a;

/**
 * Description of Ctl_Pin
 *
 * @author marcelo
 */
class Ctl_Pin {

    //put your code here
    private $mdl;

    function __construct() {
        $this->mdl = new Mdl_Pin('dstswitch');
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

    function crearCsv($mtzFile, $separador_campos) {
        $n = 0;
        $file = $mtzFile;
        $gestor = fopen($file, "r");
        if ($gestor !== FALSE) {
            $linea_texto = fgets($gestor);
            $explode_valores = explode($separador_campos, $linea_texto);
            $cdadColum = count($explode_valores);
        }
        $m = $a = 0;
        $cad = '';
        $fileTmp = fopen('/var/www/html/DstSwitch/tmpCsvFile.csv', 'w');
        if ($gestor) {
            while (($datos = fgetcsv($gestor, 1000, $separador_campos)) !== FALSE) {//crea archivo temporal
                $m++;
                while ($a < $cdadColum) {
                    if ($datos[$a]) {
                        $cad .= $datos[$a] . ',';
                    }
                    $a++;
                }
                $cad = substr($cad, 0, -1);
                $cad .= PHP_EOL;
                fwrite($fileTmp, $cad);
                $a = 0;
            }
        }
        fclose($fileTmp);
        fclose($gestor);
    }

    function agregarPorCsv() {
        $res = $this->mdl->insertFromCsv('/var/www/html/DstSwitch/tmpCsvFile.csv');
        return $res;
    }

}

$operation = $_POST['op'];
$ctlPin = new Ctl_Pin();
if ($operation) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }

    switch ($operation) {
        case "createCsvFile":
            $matrizFile = $_FILES['file']['tmp_name'];
            $res = $ctlPin->crearCsv($matrizFile, ",");
            echo $res;
            break;
        case "importPin":
            $res = $ctlPin->agregarPorCsv();
            if ($res === array()) {
                $res = "<h4><img src='../../static/img/success.png' alt='success'/>&nbsp;&nbsp;Almacenamiento de datos.</h4>";
            } else {
                $res = "<h4><img src='../../static/img/error.png' alt='error'/>&nbsp;&nbsp;Almacenamiento de datos.</h4>";
            }
            echo $res;
            break;
        case "getAllPin":
            $res = $ctlPin->traer();
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
        case "getPinList":
            $res = $ctlPin->traer();
            $cadena = "";
            $id = "";
            foreach ($res as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if ($k == "id") {
                            $cadena .= '<tr><td>' . $v . '</td><td>';
                            $id = $v;
                        } elseif ($k == "pin") {
                            $cadena .= $v . '</td><td>';
                        } elseif ($k == "description") {
                            $cadena .= $v . '</td><td style="text-align:center">
                        <a href="index.php?page=EditPin&id=' . $id . '" placeholder="editar">
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
        case "savePin":
            $arrPin[0] = $_POST['pin'];
            $arrPin[1] = $_POST['name'];
            if (count($arrPin) > 1) {
                $res = $ctlPin->agregar($arrPin);
            } 
            if($res === '00000'){
                $res = "1";
            } else {
                $res = "0";
            }
            echo $res;
            break;
        case "updatePin":
            if (isset($_POST['name']) && isset($_POST['pin'])) {
                $arr[0] = $_POST['id'];
                $arr[1] = $_POST['pin'];
                $arr[2] = $_POST['name'];
                $res = $ctlPin->actualizar($arr);
            }
            echo $res;
            break;
        case "deletePin":
            $arr[0] = $_POST['id'];
            $res = $ctlPin->eliminar($arr);
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
    $res = $ctlPin->traerPorId($arr);
    foreach ($res as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($k == "id") {
                    $jsonStr .= '"id":"' . $v . '",';
                } else if ($k == "pin") {
                    $jsonStr .= '"pin":"' . $v . '",';
                } else if ($k == "description") {
                    $jsonStr .= '"name":"' . $v . '"}';
                }
            }
        }
    }
    echo $jsonStr;
}

//    $boca = $_FILES['file']['tmp_name'];
//    $matrizFile = $boca;
//    $res = $ctlPin->crearCsv($matrizFile, ",");
//    echo $res;


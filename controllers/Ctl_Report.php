<?php

/* if (file_exists('../../models/Mdl_Report.php')) {
  $a = '../../models/Mdl_Report.php';
  } else if (file_exists('../models/Mdl_Report.php')) {
  $a = '../models/Mdl_Report.php';
  } else { */
$a = '/var/www/html/dstswitch/models/Mdl_Report.php';
$b = '/var/www/html/dstswitch/models/Mdl_Billing.php';
//}
include_once $a;
include_once $b;

/**
 * Description of Ctl_Report
 *
 * @author marcelo
 */
class Ctl_Report {

    private $mdlR, $mdlB;

    function __construct() {
        $this->mdlR = new Mdl_Report(AstDB);
        $this->mdlB = new Mdl_Billing('Dstswitch');
    }

    function traerPrecioId($idg, $idd) {
        $res = $this->mdlB->getPrice($idg, $idd);
        return $res;
    }

    function traerNomTarifa($id) {
        $res = $this->mdlB->getBillingName($id);
        foreach ($res as $clave => $valor) {
            if ($clave == 'billName') {
                $nom = $valor;
            } else {
                foreach ($valor as $cla => $val) {
                    if ($cla == 'billName') {
                        $nom = $val;
                    }
                }
            }
        }
        return $nom;
    }

    function cdadTotalLlam($arr) {
        $res = $this->mdlR->countCallsReport($arr);
        foreach ($res as $clave => $valor) {
            if ($clave == 'cdadLlam') {
                $cdadllm = $valor;
            } else {
                foreach ($valor as $cla => $val) {
                    if ($cla == 'cdadLlam') {
                        $cdadllm = $val;
                    }
                }
            }
        }
        return $cdadllm;
    }

    function segundosTotales($arr) {
        $res = $this->mdlR->sumBillsecDuration($arr);
        foreach ($res as $clave => $valor) {
            if ($clave == 'segundosTarifados') {
                $segstotales = $valor;
            } else {
                foreach ($valor as $cla => $val) {
                    if ($cla == 'segundosTarifados') {
                        $segstotales = $val;
                    }
                }
            }
        }
        return $segstotales;
    }

    //put your code here
    function llamsFijosUrb($arr, $boolTable) {
        $resu = $this->mdlR->UrbanPhoneCallsReport($arr);
        $cad = '';
        if($boolTable) {
        foreach ($resu as $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    if ($cla == 'tipollm') {
                        $cad .="<tr><td>$val</td>";
                    } else if ($cla == 'fecha') {
                        $cad .="<td>$val</td>";
                    } else if ($cla == 'hora') {
                        $cad .="<td>$val</td>";
                    } else if ($cla == 'src') {
                        $cad .="<td>$val</td>";
                    } else if ($cla == 'userfield') {
                        $cad .="<td>$val</td>";
                    } else if ($cla == 'dst') {
                        $cad .="<td>$val</td>";
                    } else if ($cla == 'duration') {
                        //$cad .="<td>$val</td>";
                    } else if ($cla == 'billsec') {
                        $cad .="<td>$val</td></tr>";
                    }
                }
            }
        }
        return $cad;
    } else {
            return $resu;
        }
    }

    function llamsFijosInterurb($arr, $boolTable) {
        $res = $this->mdlR->InterurbanPhoneCallsReport($arr);
        $cad = '';
        if ($boolTable) {
            foreach ($res as $clave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $cla => $val) {
                        if ($cla == 'tipollm') {
                            $cad .="<tr><td>$val</td>";
                        } else if ($cla == 'fecha') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'hora') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'src') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'userfield') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'dst') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'duration') {
                          //  $cad .="<td>$val</td>";
                        } else if ($cla == 'billsec') {
                            $cad .="<td>$val</td></tr>";
                        }
                    }
                }
            }
            return $cad;
        } else {
            return $res;
        }
    }

    function llamsCelsUrb($arr, $boolTable) {
        $res = $this->mdlR->UrbanCelCallsReport($arr);
        $cad = '';
        if ($boolTable) {
            foreach ($res as $clave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $cla => $val) {
                        if ($cla == 'tipollm') {
                            $cad .="<tr><td>$val</td>";
                        } else if ($cla == 'fecha') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'hora') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'src') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'userfield') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'dst') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'duration') {
                            //$cad .="<td>$val</td>";
                        } else if ($cla == 'billsec') {
                            $cad .="<td>$val</td></tr>";
                        }
                    }
                }
            }
            return $cad;
        } else {
            return $res;
        }
    }

    function llamsCelsInterurb($arr, $boolTable) {
        $res = $this->mdlR->InterurbanCelCallsReport($arr);
        $cad = '';
        if ($boolTable) {
            foreach ($res as $clave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $cla => $val) {
                        if ($cla == 'tipollm') {
                            $cad .="<tr><td>$val</td>";
                        } else if ($cla == 'fecha') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'hora') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'src') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'userfield') {
                        $cad .="<td>$val</td>";
                        } else if ($cla == 'dst') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'duration') {
                            //$cad .="<td>$val</td>";
                        } else if ($cla == 'billsec') {
                            $cad .="<td>$val</td></tr>";
                        }
                    }
                }
            }
            return $cad;
        } else {
            return $res;
        }
    }

    function llamsInternac($arr, $boolTable) {
        $res = $this->mdlR->InternacCallsReport($arr);
        $cad = '';
        if ($boolTable) {
            foreach ($res as $clave => $valor) {
                if (is_array($valor)) {
                    foreach ($valor as $cla => $val) {
                        if ($cla == 'tipollm') {
                            $cad .="<tr><td>$val</td>";
                        } else if ($cla == 'fecha') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'hora') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'src') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'userfield') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'dst') {
                            $cad .="<td>$val</td>";
                        } else if ($cla == 'duration') {
                            //$cad .="<td>$val</td>";
                        } else if ($cla == 'billsec') {
                            $cad .="<td>$val</td></tr>";
                        }
                    }
                }
            }
            return $cad;
        } else {
            return $res;
        }
    }

    function traerColumnas() {
        $res = $this->mdlR->getColumns();
        $cad = '';
        foreach ($res as $valor) {
            if (is_array($valor)) {
                foreach ($valor as $val) {
                    $cad .= "$val,";
                }
            } else {
                $cad .= $valor;
            }
        }
        return $cad;
    }

}

// despliegue de reporte detallado en ventana Modal
//$jsonGet = json_decode($_GET['json'], true);
//$id = $jsonGet['id'];
//$arrDts[0] = $id;
//$arrDts[1] = $jsonGet['fechaIni'];
//$arrDts[2] = $jsonGet['fechaFin'];
//$arrDts[3] = $jsonGet['horaIni'];
//$arrDts[4] = $jsonGet['horaFin'];
//if ($id) {
//    switch ($id) {
//        case "cdadFijosUrbanos":
//            $resultado = $ctlRep->llamsFijosUrb($arrDts);
//            echo $resultado;
//            break;
//        case "cdadFijosInter":
//            $resultado = $ctlRep->llamsCelsInterurb($arrDatos);
//            echo $resultado;
//            break;
//        case "cdadCelsUrbanos":
//            $resultado = $ctlRep->llamsCelsUrb($arrDatos);
//            echo $resultado;
//            break;
//        case "cdadCelsInter":
//            $resultado = $ctlRep->llamsCelsInterurb($arrDatos);
//            echo $resultado;
//            break;
//        case "cdadInternac":
//            break;
//        case "cdadCeroOchos":
//            break;
//    }
//}
/*$arr[0] = 16;
$arr[1] = '29/10/2015';
$arr[2] = '31/10/2015';
$arr[3] = '09:30';
$arr[4] = '10:30';
$ctl = new Ctl_Report();
$res = $ctl->llamsInternac($arr);
echo $res;*/
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
include '/var/www/html/dstswitch/config.php';
include '/var/www/html/dstswitch/controllers/Ctl_Billing.php';
include_once '/var/www/html/dstswitch/models/Mdl_Billing.php';

$Modelo_Tarifa_LocalDB = new Mdl_Billing('Dstswitch');
$Modelo_Tarifa_AsteriskDB = new Mdl_Billing("asteriskcdr");
$resultado = $Modelo_Tarifa_AsteriskDB->CopyCDR();
$TelTiempoGrupo = array();
$f = 0;
// DATOS DE CDR.ASTERISKCDR
foreach ($resultado as $clave => $valor) {
    $FilaCDR = new BillingRow(0, 0, 0, 0, 0, 0, 0, 0);
    foreach ($valor as $cla => $val) {
        if ($cla == "calldate") {
            $FilaCDR->setCalldate($val);
        } elseif ($cla == "src") {
            $FilaCDR->setSource($val);
        } elseif ($cla == "dst") {
            $FilaCDR->setDest($val);
            $TelTiempoGrupo[$f][0] = $val;
        } elseif ($cla == "billsec") {
            $FilaCDR->setBillingsec($val);
            $TelTiempoGrupo[$f][1] = $val;
        } elseif ($cla == "accountcode") {
            $FilaCDR->setAccountcode($val);
            $TelTiempoGrupo[$f][2] = $val;
        } elseif ($cla == "groupid") {
            $FilaCDR->setGroupid($val);
        } elseif ($cla == "uniqueid") {
            $FilaCDR->setUniqueid($val);
            $TelTiempoGrupo[$f][3] = $val;
        } elseif ($cla = "userfield") {
            if ($val == "") {
                $FilaCDR->setUserfield('NULL');
            } else {
                $FilaCDR->setUserfield($val);
            }
        }
    }
    $Modelo_Tarifa_LocalDB->PasteCDR($FilaCDR);
    $f++;
}
// DATOS DE Dstswitch (tiempo minimo y precio minimo)
// *$fila[0] TEL
// *$fila[1] TIEMPO DE LLAMADA
// *$fila[2] GRUPO
// *$fila[3] UNIQUEID
$CtlBilling = new Ctl_Billing();
foreach ($TelTiempoGrupo as $fila) {
    if (strlen($fila[0]) == 13 && substr($fila[0], 0, 1) == '0') {
        //13 digitos con 0 al ppio = celular larga distancia
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 4;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }

        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    } elseif (strlen($fila[0]) === 13 && substr($fila[0], 1, 2) === '08') {
        //11 digitos de largo comenzando con 0 = 0810/0800
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 6;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }

        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    } elseif (strlen($fila[0]) === 7) {
        //7 digitos de largo = fijo local
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 1;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    } elseif (strlen($fila[0]) === 9 && substr($fila[0], 0, 2) === '15') {
        //9 digitos de largo con 15 = celular local
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 3;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    } else if (strlen($fila[0]) == 11 && substr($fila[0], 0, 1) == '0') {
        //11 digitos con 0 al ppio = fijo larga distancia
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 2;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }

        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    } elseif (strlen($fila[0]) > 13 && substr($fila[0], 0, 2) === '00') {
        //empezando con 00 es larga distancia internacional
        $arrDatos[0] = $fila[2];
        $arrDatos[1] = 5;
        $arrDatos[2] = $fila[3];

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else {
                $TiempoMinimo = $valor;
            }
        }

        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else {
                $PrecioMinimo = $valor;
            }
        }

        $Ppm = $CtlBilling->traerPrecioPorMin($arrDatos);
        foreach ($Ppm as $clave => $valor) {
            foreach ($valor as $cla => $val) {
                $Ppm = $val;
            }
        }
        if ($fila[1] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[1] - $TiempoMinimo) / 60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[0], $fila[3]);
    }
}


<?php

include '/var/www/html/dstswitch/config.php';
include '/var/www/html/dstswitch/controllers/Ctl_Billing.php';

$Modelo_Tarifa_LocalDB = new Mdl_Billing('Dstswitch');
$Modelo_Tarifa_AsteriskDB = new Mdl_Billing('asteriskcdr');
$resultado = $Modelo_Tarifa_LocalDB->CopyCDR();
$TelTiempoGrupo = array();
$f = 0;
// DATOS DE CDR.ASTERISKCDR
foreach ($resultado as $clave => $valor) {
    if ($clave == "calldate") {
        $DatosIns[0] = $valor;
    } elseif ($clave == "src") {
        $DatosIns[1] = $valor;
    } elseif ($clave == "dst") {
        $DatosIns[2] = $valor;
        $TelTiempoGrupo[$f][0] = $valor;
    } elseif ($clave == "billsec") {
        $DatosIns[3] = $valor;
        $TelTiempoGrupo[$f][1] = $valor;
    } elseif ($clave == "accountcode") {
        $DatosIns[4] = $valor;
    } elseif ($clave == "uniqueid") {
        $DatosIns[5] = $valor;
    } elseif ($clave == "groupid") {
        $DatosIns[6] = $valor;
        $TelTiempoGrupo[$f][2] = $valor;
    }
    $Modelo_Tarifa_AsteriskDB->PasteCDR($DatosIns);
    $f++;
}
$a = 0;
// DATOS DE Dstswitch (tiempo minimo y precio minimo)
/*
 *$fila[x][0] TEL
 *$fila[x][1] TIEMPO DE LLAMADA
 *$fila[x][2] GRUPO
 */
$CtlBilling = new Ctl_Billing();
foreach ($arrTelTiempoGrupo as $fila/*$tel => $tiempo*/) {
    if (strlen($fila[$a][0]) === 15 && substr($fila[$a][0], 1, 1) == '0') {
        //13 digitos con 0 al ppio = celular larga distancia
        $arrDatos[0] = $fila[$a][2];
        $arrDatos[1] = 4;

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else { $TiempoMinimo = $valor; }
        }
        
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else { $PrecioMinimo = $valor; }
        }
        
        if ($fila[$a] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[$a][1] - $TiempoMinimo)/60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[$a][0]);
    } elseif (strlen($fila[$a][0]) === 13 && substr($fila[$a][0], 1, 2) === '08') {
        //11 digitos de largo comenzando con 0 = 0810/0800
        $arrDatos[0] = $fila[$a][2];
        $arrDatos[1] = 6;

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else { $TiempoMinimo = $valor; }
        }
        
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else { $PrecioMinimo = $valor; }
        }
        
        if ($fila[$a] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[$a][1] - $TiempoMinimo)/60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[$a][0]);
    } elseif (strlen($fila[$a][0]) === 9) {
        //7 digitos de largo = fijo local
        $arrDatos[0] = $fila[$a][2];
        $arrDatos[1] = 1;

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else { $TiempoMinimo = $valor; }
        }
        
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else { $PrecioMinimo = $valor; }
        }
        
        if ($fila[$a] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[$a][1] - $TiempoMinimo)/60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[$a][0]);
    } elseif (strlen($fila[$a][0]) === 11 && substr($fila[$a][0], 1, 2) === '15') {
        //9 digitos de largo con 15 = celular local
        $arrDatos[0] = $fila[$a][2];
        $arrDatos[1] = 3;

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else { $TiempoMinimo = $valor; }
        }
        
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else { $PrecioMinimo = $valor; }
        }
        
        if ($fila[$a] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[$a][1] - $TiempoMinimo)/60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[$a][0]);
    } elseif (strlen($fila[$a][0]) > 14 && substr($fila[$a][0], 1, 2) === '00') {
        //empezando con 00 es larga distancia internacional
        $arrDatos[0] = $fila[$a][2];
        $arrDatos[1] = 5;

        $TiempoMinimo = $CtlBilling->traerTiempoPrecioMinimo($arrDatos);
        foreach ($TiempoMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $TiempoMinimo = $val;
                }
            } else { $TiempoMinimo = $valor; }
        }
        
        $PrecioMinimo = $CtlBilling->traerPrecioMinimo($arrDatos);
        foreach ($PrecioMinimo as $clave => $valor) {
            if (is_array($valor)) {
                foreach ($valor as $cla => $val) {
                    $PrecioMinimo = $val;
                }
            } else { $PrecioMinimo = $valor; }
        }
        
        if ($fila[$a] >= $TiempoMinimo) {
            $precioTotal = $PrecioMinimo + ($Ppm * ceil((($fila[$a][1] - $TiempoMinimo)/60)));
        } else {
            $precioTotal = $PrecioMinimo;
        }
        $CtlBilling->actualizarPrecioTotal($precioTotal, $fila[$a][0]);
    }
    $a++;
}
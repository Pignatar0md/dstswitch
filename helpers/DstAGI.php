#!/usr/bin/php -q
<?php
include '/var/www/html/DstSwitch/config.php';
include '/var/www/html/DstSwitch/controllers/Ctl_Destiny.php';
include '/var/www/html/DstSwitch/controllers/Ctl_Extension.php';
include '/var/www/html/DstSwitch/controllers/Ctl_Pin.php';
$Agi = new AGI();
$controllerDst = new Ctl_Destiny();
$controllerExt = new Ctl_Exension();
$controllerPin = new Ctl_Pin();
$boolPin = $argv[1];
$arrPinExten[0] = $Agi->get_variable('agi_callerid');
$res = '';
$nom = '';

if ($boolPin) {
    $res = $controllerDst->traerDstPorPin($arrPinExten);
} else {
    $extensiones = $controllerExt->traer();
    $extChain = '';

    foreach ($extensiones as $cla => $val) {
        if (is_array($val)) {
            foreach ($val as $c => $v) {
                if ($c == "extension") {
                    $extChain .= "$v,";
                }
            }
        }
    }

    $arrPinExten[1] = substr($extChain, 0, -1);
    $res = $controllerDst->traerDstPorExt($arrPinExten);
}

$dest = '';
foreach ($res as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            if ($k == "destino") {
                $dest = $v;
            }
        }
    }
}

$nroDiscado = $Agi->get_variable("agi_dnid", true);
$toCall = '';

if ($nroDiscado) {
    if (strlen($nroDiscado) === 13 && substr($nroDiscado, 0, 1) == '0') {
        //13 digitos con 0 al ppio = celular larga distancia
        if ($dest == "CelularesInterurbano") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } elseif (strlen($nroDiscado) === 11 && substr($nroDiscado, 0, 1) === '0') {
         //11 digitos de largo comenzando con 0 = 0810/0800
        if ($dest == "CeroOchocientos") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } elseif (strlen($nroDiscado) === 11 && substr($nroDiscado, 0, 1) === '0') {
        //11 digitos comenzando con 0 = fijo larga distancia   
        if ($dest == "FijosInterurbanos") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } elseif (strlen($nroDiscado) === 7) {
        //7 digitos de largo = fijo local
        if ($dest == "FijosUrbanos") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } elseif (strlen($nroDiscado) === 9 && substr($nroDiscado, 0, 2) === '15') {
        //9 digitos de largo con 15 = celular local
        if ($dest == "CelularesUrbanos") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } elseif (strlen($nroDiscado) > '12' && substr($nroDiscado, 0, 2) === '00') {
         //empezando con 00 es larga distancia internacional
        if ($dest == "Internacionales") {
            $toCall = true;
        } else {
            $toCall = false;
        }
    } else {
        $toCall = 404;
    }
}

$Agi->set_variable("otorga_permiso", $toCall);
#!/usr/bin/php -q
<?php
include '/var/www/html/dstswitch/config.php';
include '/var/www/html/dstswitch/controllers/Ctl_Destiny.php';
$Agi = new AGI();
$controllerDst = new Ctl_Destiny();
$boolPin = $argv[1]; // pin del llamante
$res = '';

if ($boolPin) {
    $arrPinExten[0] = $boolPin;
    $res = $controllerDst->traerDstPorPin($arrPinExten);
} else {
    $arrPinExten[0] = $argv[3];//Agi->get_variable('agi_callerid'); // extension del llamante
    $res = $controllerDst->traerDstPorExt($arrPinExten);
}

$dest = '';
foreach ($res as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $k => $v) {
            if ($k == "destino") {
                $dest[] = $v;
            }
        }
    }
}

$nroDiscado = $argv[2]; // numero a llamar
$toCall = '';

if ($nroDiscado) {
    if (strlen($nroDiscado) === 15 && substr($nroDiscado, 1, 1) == '0') {
        //13 digitos con 0 al ppio = celular larga distancia
        if (in_array("CelularesInterurbanos", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } elseif (strlen($nroDiscado) === 13 && substr($nroDiscado, 1, 2) === '08') {
        //11 digitos de largo comenzando con 0 = 0810/0800
        if (in_array("CeroOchocientos", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } elseif (strlen($nroDiscado) === 13 && substr($nroDiscado, 1, 1) === '0') {
        //11 digitos comenzando con 0 = fijo larga distancia   
        if (in_array("FijosInterurbanos", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } elseif (strlen($nroDiscado) === 9) {
        //7 digitos de largo = fijo local
        if (in_array("FijosLocales", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } elseif (strlen($nroDiscado) === 11 && substr($nroDiscado, 1, 2) === '15') {
        //9 digitos de largo con 15 = celular local
        if (in_array("CelularesUrbanos", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } elseif (strlen($nroDiscado) > 14 && substr($nroDiscado, 1, 2) === '00') {
        //empezando con 00 es larga distancia internacional
        if (in_array("Internacionales", $dest)) {
            $toCall = 'true';
        } else {
            $toCall = 'false';
        }
    } else {
        $toCall = 404;
    }
}
$Agi->set_variable("otorga_permiso", $toCall);

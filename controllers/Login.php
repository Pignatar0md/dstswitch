<?php

if (isset($_POST["login"])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = str_replace("'", "", $value);
        $_POST[$key] = str_replace('"', '', $value);
    }
    include_once '../models/Mdl_User.php';
    $dataAuth[0] = $_POST["usuario"];
    $dataAuth[1] = $_POST["clave"];
    if ($dataAuth[0] && $dataAuth[1]) {
        $mdlUser = new Mdl_User('dstswitch');
        $result = $mdlUser->Autenticar($dataAuth);
        $user = '';
        $id = '';
        $pass = '';
        if ($result) {
            session_start();
            foreach ($result as $cla => $val) {
                if (is_array($val)) {
                    foreach ($val as $c => $v) {
                        if ($c == "name") {
                            $user = $v;
                        }
                        /*if ($c == "clave") {
                            $pass = $v;
                        }*/
                    }
                }
            }
            if ($dataAuth[0] === $user /*&& $dataAuth[1] == $pass*/) {
                $_SESSION["Usuario"] = $user;
                //$_SESSION["Id"] = $id;
                header("location: ../index.php");
            } else {
                header("location: ../index.php?auth=false");
            }
        } else {
            header("location: ../index.php?auth=false");
        }
    }
}
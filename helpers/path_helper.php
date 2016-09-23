<?php

function obtenerPath() {

    $op = isset($_GET['op']) ? $_GET['op'] : "new";
    $pag = isset($_GET['page']) ? $_GET['page'] : 'abc';

    $path = "";

    $arraypags = array("NewGroup" => "views/Group/NewGroup","ListGroup" => "views/Group/ListGroup","EditGroup" => "views/Group/EditGroup",
        "NewPin"=>"views/Pin/NewPin","ListPin"=>"views/Pin/ListPin","EditPin"=>"views/Pin/EditPin","EditDestiny"=>"views/Destiny/EditDestiny",
        "ListDestiny"=>"views/Destiny/ListDestiny","NewDestiny"=>"views/Destiny/NewDestiny","ListProfile"=>"views/Profile/ListProfile","NewProfile"=>"views/Profile/NewProfile",
        "EditPermission"=>"views/Permission/EditPermission","ListPermission"=>"views/Permission/ListPermission","NewPermission"=>"views/Permission/NewPermission");

    if (array_key_exists($pag, $arraypags)) {

        $path = "$arraypags[$pag].php";
        //echo "$arraypags[$pag].php";
    } else {
        $path = "Inc/Inexistente.php";
    }
    return $path;
}
//
//function MostrarPagina($path) {
//    $pag = isset($_GET['page']) ? $_GET['page'] : 'inicio';
//    switch ($pag) {
//        case 'NewGroup':
//            $path = header("location: " . $path);
//            break;
//        case 'contactos':
//            $path = header("location: Contactos/contactoslistado.php");
//            break;
//        case 'productos':
//            $path = header("location: Productos/productoslistado.php");
//            break;
//        case 'tickets':
//            $path = header("location: Tickets/ticketslistado.php");
//            break;
//    }
//    include($path);
//}

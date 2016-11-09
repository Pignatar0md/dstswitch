<?php

function obtenerPath() {

    $op = isset($_GET['op']) ? $_GET['op'] : "new";
    $pag = isset($_GET['page']) ? $_GET['page'] : 'ListGroup';

    $path = "";

    $arraypags = array("NewGroup" => "views/Group/NewGroup","ListGroup" => "views/Group/ListGroup","EditGroup" => "views/Group/EditGroup",
        "NewPin"=>"views/Pin/NewPin","ListPin"=>"views/Pin/ListPin","EditPin"=>"views/Pin/EditPin","EditDestiny"=>"views/Destiny/EditDestiny",
        "ListDestiny"=>"views/Destiny/ListDestiny","NewDestiny"=>"views/Destiny/NewDestiny", "configureGroup"=>"views/Group/configureGroup", 
        "ReportMenu"=>"views/Report/ReportMenu","dataReport"=>"views/Report/dataReport","detailedReport"=>"views/Report/detailedReport",
        "NewBilling" => "views/Billing/NewBilling","ListBilling" => "views/Billing/ListBilling","EditBilling" => "views/Billing/EditBilling");

    if (array_key_exists($pag, $arraypags)) {
        $path = "$arraypags[$pag].php";
    } else {
        $path = "views/error/Inexistente.php";
    }
    return $path;
}
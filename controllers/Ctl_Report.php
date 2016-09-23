<?php
include '../models/Mdl_Report.php';
/**
 * Description of Ctl_Report
 *
 * @author marcelo
 */
class Ctl_Report {
    
    private $mdl;
            
    function __construct() {
        $this->mdl = new Mdl_Report('dstswitch');
    }
    //put your code here
    function agregar($arr) {
        $res = $this->mdl->insert($arr);
        return $res;
    }
    
    function eliminar($arr)  {
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
}

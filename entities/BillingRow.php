<?php

class BillingRow {

    private $calldate;
    private $source;
    private $dest;
    private $billingsec;
    private $accountcode;
    private $groupid;
    private $uniqueid;
    private $userfield;
                function __construct($cd, $s, $d, $b, $ac, $gid, $uid,$uf) {
        $this->calldate = $cd;
        $this->source = $s;
        $this->dest = $d;
        $this->billingsec = $b;
        $this->accountcode = $ac;
        $this->groupid = $gid;
        $this->uniqueid = $uid;
        $this->userfield = $uf;
    }
    
    function getUserfield() {
        return $this->userfield;
    }

    function setUserfield($userfield) {
        $this->userfield = $userfield;
    }
    
    function getUniqueid() {
        return $this->uniqueid;
    }

    function setUniqueid($uniqueid) {
        $this->uniqueid = $uniqueid;
    }

    function getCalldate() {
        return $this->calldate;
    }

    function getSource() {
        return $this->source;
    }

    function getDest() {
        return $this->dest;
    }

    function getBillingsec() {
        return $this->billingsec;
    }

    function getAccountcode() {
        return $this->accountcode;
    }

    function getGroupid() {
        return $this->groupid;
    }

    function setCalldate($calldate) {
        $this->calldate = $calldate;
    }

    function setSource($source) {
        $this->source = $source;
    }

    function setDest($dest) {
        $this->dest = $dest;
    }

    function setBillingsec($billingsec) {
        $this->billingsec = $billingsec;
    }

    function setAccountcode($accountcode) {
        $this->accountcode = $accountcode;
    }

    function setGroupid($groupid) {
        $this->groupid = $groupid;
    }

}

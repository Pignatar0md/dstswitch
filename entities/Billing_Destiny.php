<?php

class Billing_Destiny {

    private $dest_id;
    private $group_id;
    private $billing_id;
    private $minute_price;
    private $minimal_price;
    private $time_minimal_price;

    function __construct($did, $gid, $bid, $minutep, $minimalp, $timeminimalp) {
        $this->dest_id = $did;
        $this->group_id = $gid;
        $this->billing_id = $bid;
        $this->minute_price = $minutep;
        $this->minimal_price = $minimalp;
        $this->time_minimal_price = $timeminimalp;
    }

    function getDest_id() {
        return $this->dest_id;
    }

    function getGroup_id() {
        return $this->group_id;
    }

    function getBilling_id() {
        return $this->billing_id;
    }

    function getMinute_price() {
        return $this->minute_price;
    }

    function getMinimal_price() {
        return $this->minimal_price;
    }

    function getTime_minimal_price() {
        return $this->time_minimal_price;
    }

    function setDest_id($dest_id) {
        $this->dest_id = $dest_id;
    }

    function setGroup_id($group_id) {
        $this->group_id = $group_id;
    }

    function setBilling_id($billing_id) {
        $this->billing_id = $billing_id;
    }

    function setMinute_price($minute_price) {
        $this->minute_price = $minute_price;
    }

    function setMinimal_price($minimal_price) {
        $this->minimal_price = $minimal_price;
    }

    function setTime_minimal_price($time_minimal_price) {
        $this->time_minimal_price = $time_minimal_price;
    }

}

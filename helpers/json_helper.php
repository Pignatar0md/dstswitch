<?php
function json_decode($content, $assoc = false) {
    require_once '/var/www/html/dstswitch/static/JSON/JSON.php';
    if ($assoc) {
        $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
    } else {
        $json = new Services_JSON;
    }
    return $json->decode($content);
}
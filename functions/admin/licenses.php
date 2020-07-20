<?php
namespace main\admin;
use general;

function fetch_all_licenses($unused = false){
    $db = get_connection();

    $query = ($unused) ? $db->query("SELECT * FROM licenses WHERE used='0'")
        : $db->query("SELECT * FROM licenses");

    return $query->fetchAll();
}

function generate_licenses($amount, $days, $level){
    $db = get_connection();

    $to_return = array();

    for($i = 0; $i < $amount; $i++){
        $ctx_license = general\generate_license_structure();

        $db->query("INSERT INTO licenses (license, days, `level`) VALUES(?,?,?)", [$ctx_license, $days, $level], 'sii');

        array_push($to_return, $ctx_license);
    }

    return $to_return;
}
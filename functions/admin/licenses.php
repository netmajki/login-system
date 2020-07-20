<?php
namespace main\admin;
use general;

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
<?php
namespace main\funcs;
use main;

function fetch_license_data($license){
    $license_query = get_connection()->query("SELECT * FROM licenses WHERE license=?", [$license]);

    return ($license_query->numRows() > 0)
        ? $license_query->fetch()
        : main\responses::license_doesnt_exist;
}

function get_time_to_update($user_data, $license_data){
    $syntax = "+{$license_data["days"]} days";

    if($user_data["expiry"] == '0' || time() > $user_data["expiry"])
        return strtotime($syntax);

    return strtotime($syntax, $user_data["expiry"]);
}

function activate($username, $license){
    $db = get_connection();

    $user_data = fetch_user_data($username);

    if(!is_array($user_data))
        return $user_data;

    $license_data = fetch_license_data($license);

    if(!is_array($license_data))
        return $license_data;

    if($license_data["used"] == '1')
        return main\responses::license_was_already_used;

    $final_timestamp = get_time_to_update($user_data, $license_data);

    $db->query("UPDATE users SET expiry=?, `level`=? WHERE username=?",
        [$final_timestamp, $license_data["level"], $username]);

    $db->query("UPDATE licenses SET used='1' WHERE license=?", [$license]);
    //$db->query("UPDATE licenses SET used='1', used_by=? WHERE license=?", [$username, $license]);

    return main\responses::success;
}
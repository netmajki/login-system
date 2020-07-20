<?php
namespace main\admin;
use main;

function fetch_all_users(){
    $query = get_connection()->query("SELECT * FROM users");

    return $query->fetchAll();
}

function reset_user_hwid($username){
    get_connection()->query("UPDATE users SET hwid='0' WHERE username=?", [$username]);

    return main\responses::success;
}
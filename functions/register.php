<?php
namespace main\funcs;
use main;

function user_already_exists($username){
    $user_query = get_connection()->query("SELECT username FROM users WHERE username=?", [$username]);

    return $user_query->numRows() > 0;
}

function check_length($to_check){
    $length = strlen($to_check);

    return !$length <= 4 && !$length > 25;
}

function register($username, $password){
    $db = get_connection();

    if(check_length($username) || check_length($password))
        return main\responses::not_valid_length;

    if(user_already_exists($username))
        return main\responses::user_already_exists;

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $db->query("INSERT INTO users (username, password) VALUES(?,?)", [$username, $hashed_password]);

    return main\responses::success;
}
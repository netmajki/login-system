<?php
namespace main\funcs;
use main;

function fetch_user_data($username){
    $user_query = get_connection()->query("SELECT * FROM users WHERE username=?", [$username]);

    return ($user_query->numRows() > 0)
        ? $user_query->fetch()
        : main\responses::user_doesnt_exist;
}

function login($username, $password, $api_mode = false) {
    $user_data = fetch_user_data($username);

    if (!is_array($user_data))
        return $user_data;

    if (!password_verify($password, $user_data["password"]))
        return main\responses::password_is_wrong;

    if ($api_mode && time() > $user_data["expiry"])
        return main\responses::no_active_subscription;

    return ($api_mode) ? array(
        main\responses::success,
        $user_data["username"],
        $user_data["expiry"],
        $user_data["level"]
    ) : main\responses::success;
}
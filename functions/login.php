<?php
namespace main\funcs;
use main;

function fetch_user_data($username){
    $user_query = get_connection()->query("SELECT * FROM users WHERE username=?", [$username]);

    return ($user_query->numRows() > 0)
        ? $user_query->fetch()
        : main\responses::user_doesnt_exist;
}

function update_user_hwid($username, $new_hwid){
    get_connection()->query("UPDATE users SET hwid=? WHERE username=?", [$new_hwid, $username]);
}

function check_user_hwid($user_data, $hwid) {
    if ($user_data["hwid"] == '0')
        get_connection()->query("UPDATE users SET hwid=? WHERE username=?", [$hwid, $user_data["username"]]);

    if ($user_data["hwid"] != $hwid)
        return main\responses::wrong_hwid;

    return main\responses::success;
}

function login(
    $username, $password, $hwid = null, $api_mode = false
) {
    $user_data = fetch_user_data($username);

    if (!is_array($user_data))
        return $user_data;

    if (!password_verify($password, $user_data["password"]))
        return main\responses::password_is_wrong;

    if ($api_mode && time() > $user_data["expiry"])
        return main\responses::no_active_subscription;

    if($api_mode && $hwid != null) {
        $check = check_user_hwid($user_data, $hwid);
        if($check != main\responses::success) return $check;
    }

    return ($api_mode) ? array(
        main\responses::success,
        $user_data["username"],
        $user_data["expiry"],
        $user_data["level"]
    ) : main\responses::success;
}

function get_user_level($username){
    $user_data = fetch_user_data($username);

    return $user_data["level"];
}
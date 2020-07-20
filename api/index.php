<?php
include_once '../deps/includes.php';

if($_SERVER["HTTP_USER_AGENT"] != 'song')
    die('wrong user agent');

switch($_GET["type"]){
    case 'login':
        $ctx_iv = aes::decrypt_string($_POST["ctx_iv"]);

        $username = aes::decrypt_string($_POST["username"], null, $ctx_iv);
        $password = aes::decrypt_string($_POST["password"], null, $ctx_iv);
        $hwid = aes::decrypt_string($_POST["hwid"], null, $ctx_iv);

        $result = main\funcs\login($username, $password, $hwid, true);

        if(is_array($result))
            die(aes::encrypt_string(
                general\encode(main\funcs\login($username, $password, $hwid, true)),
                null,
                $ctx_iv
            ));
        else die(aes::encrypt_string(
            main\funcs\login($username, $password, $hwid, true),
            null,
            $ctx_iv
        ));

    case 'register':
        //TODO
        break;

    case 'activate':
        //TODO
        break;
}

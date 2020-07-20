<?php
namespace general;

function alert($message){
    ?><script>alert("<?php echo $message; ?>")</script><?php
}

function encode($array){
    $to_return = '';

    foreach($array as $value)
        $to_return .= str_replace('|', '#', $value) . '|';

    return substr($to_return, 0, strlen($to_return) - 1);
}

function get_group($level) {
    switch ($level) {
        case 0:
            return 'normal_user';
        case 1:
            return 'admin_user';
        default:
            return 'unknown';
    }
}

function random_string($length = 6){
    $to_return = '';
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    for($i = 0; $i < $length; $i++){
        $rand_index = mt_rand(0, strlen($alphabet) - 1);

        $to_return .= $alphabet[$rand_index];
    }

    return $to_return;
}

function generate_license_structure(){
    $to_return = '';

    for($i = 0; $i < 4; $i++)
        $to_return .= random_string(5) . '-';

    return substr($to_return, 0, strlen($to_return) - 1);
}
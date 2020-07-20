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

function random_string($length = 6){
    $to_return = '';
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    for($i = 0; $i < $length; $i++){
        $rand_index = mt_rand(0, strlen($alphabet) - 1);

        $to_return .= $alphabet[$rand_index];
    }

    return $to_return;
}
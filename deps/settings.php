<?php
include_once 'simple-mysqli.php';

if(!isset($_SESSION)) session_start();

date_default_timezone_set('UTC');

function get_connection(){
    $connection = new SimpleMySQLi(
        'localhost',
        'root',
        '',
        'login_sys'
    );

    return $connection;
}

$default_encryption_key = 'awuNVAVFGJ6NFPeE78mdegw3hkknv2kH';
$default_encryption_iv = 'dhwPF67YfpG5UqsV';
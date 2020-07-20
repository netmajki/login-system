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
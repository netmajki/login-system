<?php
$pat = __DIR__ . '/../';

foreach(glob($pat . "deps/*.php") as $file)
    include_once $file;

foreach(glob($pat . 'functions/*.php') as $file)
    include_once $file;
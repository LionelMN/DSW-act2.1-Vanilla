<?php
    $host = 'localhost';
    $database = 'campus';
    $user = 'lioneldsw';
    $password = 'DSW';
    $gestor = 'mysql';
    $dsn = "$gestor:host=$host;dbname=$database";

    $conecction = new PDO($dsn, $user, $password);
?>
<?php
    $host = 'localhost';
    $database = 'ac21';
    $user = 'lionelDSW';
    $password = 'DSW';
    $gestor = 'mysql';
    $dsn = "$gestor:host=$host;dbname=$database";

    try {
        $conecction = new PDO($dsn, $user, $password);
    }catch(PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
?>
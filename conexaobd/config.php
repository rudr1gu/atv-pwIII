<?php
    define('DB_SERVE', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'test');

try{
    $pdo = new PDO("mysql:host=".DB_SERVE.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e){
    echo "Não foi possivel conectar: ".$e->getMessage();
}
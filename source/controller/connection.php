<?php
$host = 'localhost'; //host type
$port = '3306'; //host port
$dbname = 'web_master'; //data base name
$user = 'root'; //user database
$pass = ''; //password from database


try {
    $connection = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
} catch (PDOException $error) {
    echo $error->getMessage();
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}
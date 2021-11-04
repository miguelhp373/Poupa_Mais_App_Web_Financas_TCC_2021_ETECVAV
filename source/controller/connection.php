<?php
require_once('config/ENV.php');

$host   = $HOST_NAME; //host type
$port   = $PORT_SERVER; //host port
$dbname = $DATA_BASE_NAME; //data base name
$user   = $USER_DATA_BASE; //user database
$pass   = $PASS_DATA_BASE; //password from database


try {
    $connection = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
} catch (PDOException $error) {
    //echo $error->getMessage();
    echo "<h1>Erro 503 - Serviço Indisponivel Temporariamente<h1>";
    die;
}
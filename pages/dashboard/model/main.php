<?php
session_start();
require_once('../../../source/controller/connection.php');

$valor          =   filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);
$categorias     =   filter_input(INPUT_POST, 'categorias', FILTER_SANITIZE_STRING);
$descricao      =   filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$data           =   filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$type           =   filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);


$searchinfos = $connection->prepare("SELECT cod, saldo FROM userstableapplication WHERE email = :email LIMIT 1");
$searchinfos->bindParam(':email', $_SESSION['user_email']);

$searchinfos->execute();

if ($searchinfos->rowCount() > 0) {

    $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getdata) {
        $user_cod      =   $getdata['cod'];
        $user_Saldo      =   $getdata['saldo'];
    }
}

try {

    $insert = $connection->prepare("INSERT INTO operationsapplication (idUser, tipo , data, categoria, descricao, valor) VALUES (:cod_user,:tipo, :data, :cate,  :descri, :valor)");

    $insert->bindParam(':cod_user', $user_cod);
    $insert->bindParam(':tipo', $type);
    $insert->bindParam(':cate', $categorias);
    $insert->bindParam(':descri', $descricao);
    $insert->bindParam(':data', $data);
    $insert->bindParam(':valor', $valor);

    $insert->execute();

    if ($insert->rowCount() > 0) {

        if ($type == 'receita') {
    
            $saldo_atual    = number_format($user_Saldo, 2, '.', ',');
            $getValor       = number_format($valor, 2, '.', ',');

            $newSaldo = $saldo_atual + $getValor;


            try {
                $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
                $UpdateSaldo->bindParam(':id', $user_cod);
                $UpdateSaldo->bindParam(':saldo', $newSaldo);
                
                $UpdateSaldo->execute();
                

                if ($UpdateSaldo->rowCount() > 0) {
                    header('Location: ../index.php');
                }
            } catch (PDOException $error) {
                echo 'ERRO';
            }
        }

        if ($type == 'despesa') {
    
            $saldo_atual    = number_format($user_Saldo, 2, '.', ',');
            $getValor       = number_format($valor, 2, '.', ',');

            $newSaldo = $saldo_atual - $getValor;

            try {
                $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
                $UpdateSaldo->bindParam(':id', $user_cod);
                $UpdateSaldo->bindParam(':saldo', $newSaldo);
                
                $UpdateSaldo->execute();
                

                if ($UpdateSaldo->rowCount() > 0) {
                    header('Location: ../index.php');
                }
            } catch (PDOException $error) {
                echo 'ERRO';
            }
        }

    } else {
        echo "Erro ao Tentar Adicionar Nova" . $type;
        die();
        $_SESSION['Msg_error']  =   "Erro ao Tentar Adicionar Nova" . $type;
    }
} catch (PDOException $error) {
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}

<?php
session_start();
require_once('../../../source/controller/connection.php');


if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../login/index.php');
    }
}



$valor          =   filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);
$categorias     =   filter_input(INPUT_POST, 'categorias', FILTER_SANITIZE_STRING);
$descricao      =   filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$data           =   filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$type           =   filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$automatico     =   filter_input(INPUT_POST, 'automatico', FILTER_SANITIZE_STRING);


// if ($valor == null) {
//     $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $type;
//     header('Location: ../index.php');
//     die();
// }

// if ($categorias == 'null') {
//     $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $type;
//     header('Location: ../index.php');
//     die();
// }

// if ($descricao == null) {
//     $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $type;
//     header('Location: ../index.php');
//     die();
// }

// if ($data == null) {
//     $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $type;
//     header('Location: ../index.php');
//     die();
// }




if ($automatico !== null) {
    $automatico = "S";
    $dateAuto = date('Y-m-d', strtotime('+1 months', strtotime($data)));
} else {
    $automatico = "N";
    $dateAuto = null;
}

/////////////////////////////////////////////////////////////////
//PESQUISA SALDO
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
//////////////////////////////////////////////////////////////
//INSERT OPERATION

try {
    $getValor       = str_replace (',', '.', str_replace ('.', '', $valor));

    $insert = $connection->prepare("INSERT INTO operationsapplication (idUser, tipo , data, categoria, descricao, valor, automatico, proximoAuto) VALUES (:cod_user,:tipo, :data, :cate,  :descri, :valor, :auto,:dateAuto)");

    $insert->bindParam(':cod_user', $user_cod);
    $insert->bindParam(':tipo', $type);
    $insert->bindParam(':cate', $categorias);
    $insert->bindParam(':descri', $descricao);
    $insert->bindParam(':data', $data);
    $insert->bindParam(':valor', $getValor);
    $insert->bindParam(':auto', $automatico);
    $insert->bindParam(':dateAuto', $dateAuto);

    $insert->execute();
    
    
    if ($insert->rowCount() > 0) {

        //////////////////////////////////////////////////////////
        //SALDO
     
        ///////////////
        //RECEITA
        if ($type == 'receita') {

            $newSaldo = $user_Saldo + $getValor;
    
            try {
                $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
                $UpdateSaldo->bindParam(':id', $user_cod);
                $UpdateSaldo->bindParam(':saldo', $newSaldo);

                $UpdateSaldo->execute();


                if ($UpdateSaldo->rowCount() > 0) {
                    header('Location: ../index.php');
                }
            } catch (PDOException $error) {
                $_SESSION['Msg_error']  =   "Erro ao Tentar Adicionar Nova " . $type;
                header('Location: ../index.php');
                die();
            }
        }

        ////////////// 
        ////DESPESA
        if ($type == 'despesa') {

            $newSaldo = $user_Saldo - $getValor;

            try {
                $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
                $UpdateSaldo->bindParam(':id', $user_cod);
                $UpdateSaldo->bindParam(':saldo', $newSaldo);

                $UpdateSaldo->execute();


                if ($UpdateSaldo->rowCount() > 0) {
                    header('Location: ../index.php');
                }
            } catch (PDOException $error) {
                $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $type;
                header('Location: ../index.php');
                die();
            }
        }
        ///////////////////////////////////////////////////////////

    } else {
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
    }
} catch (PDOException $error) {
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}

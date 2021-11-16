<?php

require_once('../../../../source/controller/connection.php');
session_start();

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../login/index.php');
    }
}


    $searchinfos = $connection->prepare("SELECT cod,  email, saldo FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_Saldo      =   $getdata['saldo'];
            $user_cod        =   $getdata['cod'];
        }
    }else{
        header('location: ../../index.php');
        die;
    }




// function GenerateOperation($connection, $user_cod, $valor,$type){

//     $categorias     =   'Reajuste de Saldo';
//     $descricao      =   'Reajuste de Saldo';
//     $data           =   date('Y-m-d');
//     $automatico     =   'N';


//     $insert = $connection->prepare("INSERT INTO operationsapplication (idUser, tipo , data, categoria, descricao, valor, automatico) VALUES (:cod_user,:tipo, :data, :cate,  :descri, :valor, :auto)");

//     $insert->bindParam(':cod_user', $user_cod);
//     $insert->bindParam(':tipo', $type);
//     $insert->bindParam(':cate', $categorias);
//     $insert->bindParam(':descri', $descricao);
//     $insert->bindParam(':data', $data);
//     $insert->bindParam(':valor', $valor);
//     $insert->bindParam(':auto', $automatico);

//     $insert->execute();

// }





    $newSaldo       =   filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);

    $newSaldo_F     =   str_replace (',', '.', str_replace ('.', '', $newSaldo));

    $updateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :new_saldo  WHERE email = :email LIMIT 1");
    $updateSaldo->bindParam(':email', $_SESSION['user_email']);
    $updateSaldo->bindParam(':new_saldo', $newSaldo_F);


    $updateSaldo->execute();    

    
    header('location: ../../index.php');
    die;

    // if($user_Saldo < $newSaldo_F){

        
    //     $GenerationOperation = $newSaldo_F - $user_Saldo;
        
    //     $type = 'receita';

    //     // GenerateOperation($connection, $user_cod, $GenerationOperation, $type);

    //     $updateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :new_saldo  WHERE email = :email LIMIT 1");
    //     $updateSaldo->bindParam(':email', $_SESSION['user_email']);
    //     $updateSaldo->bindParam(':new_saldo', $newSaldo_F);


    //     $updateSaldo->execute();    

        
    //     header('location: ../../index.php');
    //     die;




    // }else if($user_Saldo > $newSaldo_F){

    //     $GenerationOperation = $saldo_atual - $newSaldo_F ;

    //     $type = 'despesa';

    //     GenerateOperation($connection, $user_cod, $GenerationOperation, $type);


    //     $updateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :new_saldo  WHERE email = :email LIMIT 1");
    //     $updateSaldo->bindParam(':email', $_SESSION['user_email']);
    //     $updateSaldo->bindParam(':new_saldo', $newSaldo_F);


    //     $updateSaldo->execute();        


    //     header('location: ../../index.php');
    //     die;        
    // }

    // header('location: ../../index.php');
    // die;     



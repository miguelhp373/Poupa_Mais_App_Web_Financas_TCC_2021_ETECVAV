<?php

require_once('../../../../source/controller/connection.php');
session_start();

$_SESSION['Msg_error']  = '';


$code01 =   filter_input(INPUT_POST,'code01',FILTER_SANITIZE_STRING);
$code02 =   filter_input(INPUT_POST,'code02',FILTER_SANITIZE_STRING);
$code03 =   filter_input(INPUT_POST,'code03',FILTER_SANITIZE_STRING);
$code04 =   filter_input(INPUT_POST,'code04',FILTER_SANITIZE_STRING);

$WriteCode  =   $code01.$code02.$code03.$code04;


try{
    $searchOTPCode = $connection->prepare("SELECT pass_recover FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchOTPCode->bindParam(':email', $_SESSION['email']);

    $searchOTPCode->execute();

    if ($searchOTPCode->rowCount() > 0) {

        $row = $searchOTPCode->fetchAll(PDO::FETCH_ASSOC);

        foreach($row as $getcode){
            $codeOTP   =   $getcode['pass_recover'];

            if($codeOTP == $WriteCode){

                $RemoveOTPCode = $connection->prepare("UPDATE userstableapplication SET pass_recover = NULL WHERE email = :email LIMIT 1");
                $RemoveOTPCode->bindParam(':email', $_SESSION['email']);
                $RemoveOTPCode->execute();
                
                if($RemoveOTPCode->rowCount() < 1){
                    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
                }
            

                
                $_SESSION['ValidationCode'] =   md5(rand(1,9999));
                $_SESSION['Msg_error'] = '';
                $_SESSION['AlterPassWord']  =   true;
                header('Location: ../trocar senha.php?validation='.$_SESSION['ValidationCode']);

            }else{
                $_SESSION['Msg_error']  =   'Código de Recuperação Inválido!';
                header('Location: ../index.php?verificationcode=true');
                die();
            }
        }
        $_SESSION['Msg_error'] = '';

    }
}catch(PDOException $error){
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}

?>
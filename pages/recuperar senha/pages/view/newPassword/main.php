<?php
    session_start();
    require_once('../../../../../source/controller/connection.php');

 
if($_POST['newpass_user'] != $_POST['newpass_user_confirm']){
    $_SESSION['Msg_error']  =   "Erro ao Tentar Alterar a Senha! As Senhas Não Conferem.";
    header('Location: ../../trocar senha.php?validation='.$_SESSION['ValidationCode']);
}else{
        $PassHash  =    password_hash(filter_input(INPUT_POST,'newpass_user',FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);
    }

    try{
            $AlterPassword = $connection->prepare("UPDATE userstableapplication SET senha = :pass  WHERE email = :email LIMIT 1");
            $AlterPassword->bindParam(':email', $_SESSION['email']);
            $AlterPassword->bindParam(':pass',$PassHash);
            $AlterPassword->execute();

            if($AlterPassword->rowCount() > 0){
                header('Location: ../../../../login/index.php');
                
                $_SESSION['sucess_msg'] =   "Senha Alterada Com Sucesso!";
                $_SESSION['Msg_error']  =   '';
                $_SESSION['ValidationCode'] =   '';
                die;
            }

    }catch(PDOException $error){
        $_SESSION['Msg_error']  =   "Erro ao Tentar Alterar a Senha! Tente Novamente.";
        header('Location: ../../trocar senha.php?validation='.$_SESSION['ValidationCode']);
    }

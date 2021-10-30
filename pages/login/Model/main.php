<?php

require_once('../../../source/controller/connection.php');

session_start();
$_SESSION['Msg_error'] = '';
$_SESSION['Authentication'] = '';


try {

    $_SESSION['user_email'] = filter_input(INPUT_POST, 'email_user', FILTER_SANITIZE_EMAIL);
    $_SESSION['user_pass']  = filter_input(INPUT_POST, 'user_pass', FILTER_SANITIZE_STRING);





    $loginquery = $connection->prepare("SELECT email, senha FROM userstableapplication WHERE email = :email LIMIT 1");
    $loginquery->bindParam(':email', $_SESSION['user_email']);

    $loginquery->execute();
} catch (PDOException $error) {
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}


if ($loginquery->rowCount() > 0) {

    $row = $loginquery->fetch();

    if (password_verify($_SESSION['user_pass'], $row["senha"])) {
        $_SESSION['Authentication'] = rand(1, 9);

        if (isset($_SESSION['sucess_msg'])) {
            $_SESSION['sucess_msg'] =   '';
        }


        if (isset($_POST["remember_password"])) {
            setcookie("member_login", $_SESSION['user_email'], time() + 3600);
            setcookie("member_password", $_SESSION['user_pass'], time() + 3600);
        }


        header('Location: ../../dashboard/index.php');
    } else {
        $_SESSION['Authentication'] = '';
        $_SESSION['Msg_error'] = 'Senha Incorreta!';
        header('Location: ../index.php?wrong_fields=true');
        die;
        //enviar uma mensagem de erro pro login
    }
} else {
    $_SESSION['Msg_error'] = 'Usuário Não Encontrado!';
    $_SESSION['Authentication'] = '';
    header('Location: ../index.php?wrong_fields=true');
    die;
    //enviar uma mensagem de erro pro login
}

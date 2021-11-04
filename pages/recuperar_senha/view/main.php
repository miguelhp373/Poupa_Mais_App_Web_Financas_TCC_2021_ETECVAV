<?php
session_start();

require_once('../../../source/controller/connection.php');
require_once('../../../ENV.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//para quem será enviado
$_SESSION['email']  =   filter_input(INPUT_POST,'email_user',FILTER_SANITIZE_EMAIL);//email que será utilizado para enviar

try{
    
    $searchEmail = $connection->prepare("SELECT nome FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchEmail->bindParam(':email', $_SESSION['email']);

    $searchEmail->execute();

    if ($searchEmail->rowCount() > 0) {

        $row = $searchEmail->fetchAll(PDO::FETCH_ASSOC);

        foreach($row as $getName){
            $name   =   $getName['nome'];
        }
        $_SESSION['Msg_error'] = '';

    }else{
        $_SESSION['Msg_error'] = 'Email Não Encontrado!';
        header('Location: ../index.php');
        die;
    }

}catch(PDOException $error){
    echo $error->getMessage();
    die;
}



try{
    $_SESSION['codeOTP']    =   strval(rand(1000, 9999));

    $AddOTPCode = $connection->prepare("UPDATE userstableapplication SET pass_recover = :code WHERE email = :email LIMIT 1");
    $AddOTPCode->bindParam(':email', $_SESSION['email']);
    $AddOTPCode->bindParam(':code', $_SESSION['codeOTP']);
    $AddOTPCode->execute();
    
    if($AddOTPCode->rowCount() < 1){
        header('location: ../../Page404/index.php');
        die;
    }

    
}catch(PDOException $error){
    header('location: ../../Page404/index.php');
    die;
}

//quem enviou
$email_from =   'apppoupamais@gmail.com';//email da nossa empresa
$name_from  =   'Poupa Mais';//nome da empresa

$mail = new PHPMailer(true);

//Send mail using gmail

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = $emailHost; // GMAIL username
    $mail->Password = $passwordHost; // GMAIL password
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    

//Typical mail data
$mail->AddAddress($_SESSION['email'], $name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = "Recuperação de Senha";//titulo do email
$mail->Body =  "<html>
                    <meta charset='UTF-8' /> 
                    <h4>Olá $name, Logo Abaixo está seu código de recuperação</h4>
                    <span>Insira esse código na tela de recuperação para poder alterar a senha!</span>
                    <strong>".$_SESSION['codeOTP']."</strong>
                </html>";//conteudo do email

try{
    $mail->Send();
    $_SESSION['Validation'] =   true;
    header('Location: ../pages/index.php?verificationcode=true'); //página de recuperação
} catch(Exception $e){
    //Something went bad
    $_SESSION['Validation'] =   false;
    echo "Fail - " . $mail->ErrorInfo;
    die;
}

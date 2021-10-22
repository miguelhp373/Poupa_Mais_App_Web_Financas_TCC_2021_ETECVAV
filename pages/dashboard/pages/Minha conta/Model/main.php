<?php
require_once('../../../../../source/controller/connection.php');
session_start();

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../login/index.php');
        

    }
}

$_SESSION['Msg_sucess'] = '';
$_SESSION['Msg_error'] = '';

$UserName                   =   filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$userEmail                  =   filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
$UserCpf                    =   filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_STRING);   
$UserPhoneNumber            =   filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$UserPassVerify             =   filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
$UserPass                   =   password_hash(filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);            


function validaCPF($cpf) {
 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        $_SESSION['Msg_error']  =   "CPF Inválido.";
        header('Location: ../index.php');
        die();
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        $_SESSION['Msg_error']  =   "CPF Inválido.";
        header('Location: ../index.php');
        die();
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            $_SESSION['Msg_error']  =   "CPF Inválido.";
            header('Location: ../index.php');
            die();
        }
    }
    return true;

}

validaCPF($UserCpf);

if(isset($_SESSION['image_selected'])){

    try{        
        $update = $connection->prepare("UPDATE userstableapplication SET image_user = :imageParam WHERE email = :email LIMIT 1");
        
        $update->bindParam(':imageParam',$_SESSION['image_selected']);
        $update->bindParam(':email',$userEmail);
        
        $update->execute();
  
    }catch(PDOException $error){
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
    } 
}


if(strlen($UserPassVerify) > 0) {
    try{        
        $update = $connection->prepare("UPDATE userstableapplication SET Nome = :nome , email = :email , cpf = :cpf, telefone = :telefone , senha = :pass WHERE email = :email LIMIT 1");
        
        $update->bindParam(':nome',$UserName);
        $update->bindParam(':email',$userEmail);
        $update->bindParam(':cpf',$UserCpf);
        $update->bindParam(':telefone',$UserPhoneNumber );
        $update->bindParam(':pass',$UserPass);
        
        $update->execute();
        
        if($update->rowCount() > 0){
            $_SESSION['Msg_sucess'] = 'Informações Alteradas com Sucesso!';
            header('location: ../../minha conta/index.php');
        }else{
            $_SESSION['Msg_sucess'] = '';
            $_SESSION['Msg_error'] = 'Erro Ao Tentar Alterar As Informações';;
            header('location: ../../minha conta/index.php');
            die();
        }
        
       
    
    }catch(PDOException $error){
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
    }

}else{
    try{        
        $update = $connection->prepare("UPDATE userstableapplication SET Nome = :nome , email = :email, cpf = :cpf, telefone = :telefone  WHERE email = :email LIMIT 1");
        
        $update->bindParam(':nome',$UserName);
        $update->bindParam(':email',$userEmail);
        $update->bindParam(':cpf',$UserCpf);
        $update->bindParam(':telefone',$UserPhoneNumber );
        $update->bindParam(':typeaccount',$AccountType);
        
        $update->execute();
        
        if($update->rowCount() > 0){
            $_SESSION['Msg_sucess'] = 'Informações Alteradas com Sucesso!';
            header('location: ../../minha conta/index.php');
        }else{
            $_SESSION['Msg_sucess'] = '';
            $_SESSION['Msg_error'] = 'Erro Ao Tentar Alterar As Informações';
            header('location: ../../minha conta/index.php');
            die();
            
        }
        
       
    
    }catch(PDOException $error){
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
    }
}



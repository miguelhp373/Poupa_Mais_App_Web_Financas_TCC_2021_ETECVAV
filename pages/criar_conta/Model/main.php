<?php
session_start();
require_once('../../../source/controller/connection.php');

$UserName                   =   filter_input(INPUT_POST,'name_user',FILTER_SANITIZE_STRING);
$_SESSION['email_user']     =   filter_input(INPUT_POST,'email_user',FILTER_SANITIZE_EMAIL);
//$UserCpf                    =   filter_input(INPUT_POST,'cpf_user',FILTER_SANITIZE_STRING);   
$UserPhoneNumber            =   filter_input(INPUT_POST,'phonenumber_user',FILTER_SANITIZE_STRING);
$UserPass                   =   password_hash(filter_input(INPUT_POST,'pass_user',FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);



///////////////////////
//SALVA OS CAMPOS:

$_SESSION['user_name_create_account']            =  $UserName; 
$_SESSION['user_email_create_account']           =  $_SESSION['email_user'] ;
$_SESSION['user_phone_create_account']           =  $UserPhoneNumber; 
$_SESSION['user_pass_create_account']            =  $_POST['pass_user'];
$_SESSION['user_passconfirm_create_account']     =  $_POST['pass_user_confirm']; 


// function validaCPF($cpf) {
 
//     // Extrai somente os números
//     $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
//     // Verifica se foi informado todos os digitos corretamente
//     if (strlen($cpf) != 11) {
//         $_SESSION['Msg_error']  =   "CPF Inválido.";
//         header('Location: ../index.php');
//         die();
//     }

//     // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
//     if (preg_match('/(\d)\1{10}/', $cpf)) {
//         $_SESSION['Msg_error']  =   "CPF Inválido.";
//         header('Location: ../index.php');
//         die();
//     }

//     // Faz o calculo para validar o CPF
//     for ($t = 9; $t < 11; $t++) {
//         for ($d = 0, $c = 0; $c < $t; $c++) {
//             $d += $cpf[$c] * (($t + 1) - $c);
//         }
//         $d = ((10 * $d) % 11) % 10;
//         if ($cpf[$c] != $d) {
//             $_SESSION['Msg_error']  =   "CPF Inválido.";
//             header('Location: ../index.php');
//             die();
//         }
//     }
//     return true;

// }

// validaCPF($UserCpf);


//VALIDA SENHAS
if($_POST['pass_user'] !== $_POST['pass_user_confirm']){

    $_SESSION['Msg_error']  =   "As Senhas Não Batem! Verifique e Tente Novamente.";
    header('Location: ../index.php?wrong_fields=true');

    die();
}


//VALIDA TELEFONE
if(strlen($UserPhoneNumber) < 14){

    $_SESSION['Msg_error']  =   "Telefone Inválido! Verifique e Tente Novamente.";
    header('Location: ../index.php?wrong_fields=true');
    
    die();
}



$cat = '[{"id":"0","description":"Compras"},{"id":"1","description":"Supermercado"},{"id":"2","description":"Salário"},{"id":"3","description":"Pagamentos"}]';
$defaultPath = '/source/assets/avatar_profiles/default.png';

try{
    $existsUser =   $connection->prepare("SELECT * FROM userstableapplication WHERE email = :email LIMIT 1");
    $existsUser->bindParam(':email',$_SESSION['email_user']);
    //$existsUser->bindParam(':cpf',$UserCpf);

    $existsUser->execute();

    if($existsUser->rowCount() > 0){
        $_SESSION['Msg_error']  =   "Erro ao Tentar Criar a Conta! Usuário Já Existente.";
        header('Location: ../index.php?wrong_fields=true');

        die();
        
    }else{
        
        $_SESSION['Msg_error'] = '';


        
        
        try{
        
            $insert = $connection->prepare("INSERT INTO userstableapplication (Nome, email, telefone, senha, categorias, image_user) VALUES (:nome,:email, :telefone, :pass, :categories, :imageDefault)");
            
            $insert->bindParam(':nome',$UserName);
            $insert->bindParam(':email',$_SESSION['email_user']);
            //$insert->bindParam(':cpf',$UserCpf);
            $insert->bindParam(':telefone',$UserPhoneNumber );
            $insert->bindParam(':pass',$UserPass);
            $insert->bindParam(':categories',$cat);
            $insert->bindParam(':imageDefault',$defaultPath);
            
            $insert->execute();
            
            if($insert->rowCount() > 0){

                //LIMPA AS VARIAVEIS TEMPORARIAS
                $_SESSION['user_name_create_account']            =  ''; 
                $_SESSION['user_email_create_account']           =  '';
                $_SESSION['user_phone_create_account']           =  '';
                $_SESSION['user_pass_create_account']            =  '';
                $_SESSION['user_passconfirm_create_account']     =  '';

                header('location: ../../login/index.php?register=true');
            }else{
                $_SESSION['Msg_error']  =   "Erro ao Tentar Criar a Conta! Tente Novamente Mais Tarde.";
            }
            
           
        
        }catch(PDOException $error){
            die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
        }
    }

}catch(PDOException $error){
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}







?>
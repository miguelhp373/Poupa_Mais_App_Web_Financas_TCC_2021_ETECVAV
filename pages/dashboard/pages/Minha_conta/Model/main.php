<?php
require_once('../../../../../source/controller/connection.php');
session_start();

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../login/index.php');
        

    }
}

$_SESSION['Msg_sucess'] = '';
$_SESSION['Msg_error'] = '';

$UserName                   =   filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
$userEmail                  =   filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
$UserPhoneNumber            =   filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$UserPassVerify             =   filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
$UserPass                   =   password_hash(filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);            




try {

    $searchinfos = $connection->prepare("SELECT cod, nome, email, telefone, image_user FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);


        foreach ($row as $getdata) {
            $user_name      =   $getdata['nome'];
            $user_email     =   $getdata['email'];
            $user_cod       =   $getdata['cod'];
            $user_telefone  =   $getdata['telefone'];
            $image_user     =   $getdata['image_user'];
        }
    }
} catch (PDOException $error) {
    header('location: ../../../Page404/index.php');
    die;
}


if(isset($_GET['deleteAccont'])){

    if($_GET['deleteAccont'] == 'true'){


        try{        
            $DeleteAccount = $connection->prepare("DELETE FROM userstableapplication WHERE cod = :cod");
            $DeleteAccount->bindParam(':cod',$user_cod);
            
            $DeleteAccount->execute();


            $DeleteOperations = $connection->prepare("DELETE FROM operationsapplication WHERE cod = :cod");
            $DeleteOperations->bindParam(':cod',$user_cod);
            
            $DeleteOperations->execute();

            $DeleteEvents = $connection->prepare("DELETE FROM eventstableapplicartion WHERE coduser = :cod");
            $DeleteEvents->bindParam(':cod',$user_cod);
            
            $DeleteEvents->execute();            
            
            if($DeleteAccount->rowCount() > 0){
                
                setcookie('email_storage_remember','', time() - (3600 * 5),'/',NULL,false, true);
                setcookie('pass_storage_remember','',time() - (3600 * 5),'/',NULL,false, true);
                
                //clean session
                session_unset();
                session_destroy();
        
                header('Location: ../../../../login/index.php?login=logout');
                die;
            }

      
        }catch(PDOException $error){
            header('location: ../../../../Page404/index.php');
            die;
        }     
    }else{
        header('location: ../../Minha_conta/index.php');
        die;
    }
}



if(isset($_SESSION['image_selected'])){

    try{        
        $update = $connection->prepare("UPDATE userstableapplication SET image_user = :imageParam WHERE email = :email LIMIT 1");
        
        $update->bindParam(':imageParam',$_SESSION['image_selected']);
        $update->bindParam(':email',$_SESSION['user_email']);
        
        $update->execute();
  
    }catch(PDOException $error){
        header('location: ../../../../Page404/index.php');
        die;
    } 
}


if(strlen($UserPassVerify) > 0) {
    try{        
        $update = $connection->prepare("UPDATE userstableapplication SET Nome = :nome , email = :email , telefone = :telefone , senha = :pass WHERE email = :emailValidation LIMIT 1");
        
        $update->bindParam(':nome',$UserName);
        $update->bindParam(':email',$userEmail);
        $update->bindParam(':emailValidation',$_SESSION['user_email']);
        //$update->bindParam(':cpf',$UserCpf);
        $update->bindParam(':telefone',$UserPhoneNumber );
        $update->bindParam(':pass',$UserPass);
        
        $update->execute();
        
        if($update->rowCount() > 0){
            $_SESSION['Msg_sucess'] = 'Informações Alteradas com Sucesso!';
            header('location: ../../Minha_conta/index.php');
        }else{
            $_SESSION['Msg_sucess'] = '';
            $_SESSION['Msg_error'] = 'Erro Ao Tentar Alterar As Informações';;
            header('location: ../../Minha_conta/index.php');
            die();
        }
        
       
    
    }catch(PDOException $error){
        header('location: ../../../../Page404/index.php');
        die;
    }

}else{
    try{  
        

        $update = $connection->prepare("UPDATE userstableapplication SET Nome = :nome , email = :email, telefone = :telefone  WHERE email = :emailValidation LIMIT 1");
        
        $update->bindParam(':nome',$UserName);
        $update->bindParam(':email',$userEmail);
        $update->bindParam(':emailValidation',$_SESSION['user_email']);
        $update->bindParam(':telefone',$UserPhoneNumber );
        
        $update->execute();
        
        if($update->rowCount() > 0){
            $_SESSION['Msg_sucess'] = 'Informações Alteradas com Sucesso!';
            header('location: ../../Minha_conta/index.php');
        }else{
            $_SESSION['Msg_sucess'] = '';
            $_SESSION['Msg_error'] = 'Erro Ao Tentar Alterar As Informações';
            header('location: ../../Minha_conta/index.php');
            die();
            
        }
        
       
    
    }catch(PDOException $error){
        header('location: ../../../../Page404/index.php');
        die;
    }
}



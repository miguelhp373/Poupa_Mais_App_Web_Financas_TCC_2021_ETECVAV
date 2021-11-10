<?php
session_start();
require_once('../../../../../../../source/controller/connection.php');

////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication'])) || (empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../../login/index.php');
    }
}

if (isset($_SESSION['ADM_USER'])) {
    if ($_SESSION['ADM_USER'] != 'root_user_acept') {
        header('Location: ../../../../../../dashboard/index.php');
        die;
    }
} else {
    header('Location: ../../../../../../login/index.php');
    die();
}

if(!isset($_GET['type'])){
    header('Location: ../../../../../../dashboard/index.php');
    die; 
}




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
        }
    }
} catch (PDOException $error) {
    header('location: ../../../../../../../../Page404/index.php');
    die;
}


switch ($_GET['type']) {
    case 'root':
        UpdateLevel($connection,'master');
        break;
    case 'remove':
        UpdateLevel($connection,null);
            break;        
    case 'delete':
        DeleteUser($connection,$user_cod);
        break;
    default:
        header('Location: ../../../../../../dashboard/index.php');
        die;
        break;
}

function UpdateLevel($connection,$type)
{
    $user_id = $_GET['user_id'];


    try {

        $UpdateLevelUser = $connection->prepare("UPDATE userstableapplication SET access =  :type WHERE cod = :Usercod");
        $UpdateLevelUser->bindParam(':Usercod', $user_id);
        $UpdateLevelUser->bindParam(':type', $type);
        $UpdateLevelUser->execute();
    
        if ($UpdateLevelUser->rowCount() > 0) {
            header('Location: ../../user_organization/index.php');
        } else {
            header('Location: ../../user_organization/index.php');
            die();
        }
    } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }
}


function DeleteUser($connection,$cod)
{

    $user_id = $_GET['user_id'];

    if($cod == $user_id){
        header('Location: ../../user_organization/index.php');
        die();
    }

    $DeleteAccount = $connection->prepare("DELETE FROM userstableapplication WHERE cod = :cod");
    $DeleteAccount->bindParam(':cod',$user_id);
    
    $DeleteAccount->execute();


    $DeleteOperations = $connection->prepare("DELETE FROM operationsapplication WHERE cod = :cod");
    $DeleteOperations->bindParam(':cod',$user_id);
    
    $DeleteOperations->execute();

    $DeleteEvents = $connection->prepare("DELETE FROM eventstableapplicartion WHERE coduser = :cod");
    $DeleteEvents->bindParam(':cod',$user_id);
    
    $DeleteEvents->execute(); 
    
    header('Location: ../../user_organization/index.php');
    die();
}




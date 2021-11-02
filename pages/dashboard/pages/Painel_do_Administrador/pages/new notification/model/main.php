<?php 
    session_start();
    require_once('../../../../../../../source/controller/connection.php');

    ////////////
    //VALIDA USUÁRIO
    if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
        if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
            $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
            header('Location: ../../../../../../login/index.php');
        }
    }

    if(isset($_SESSION['ADM_USER'])){
        if($_SESSION['ADM_USER'] != 'root_user_acept'){
            header('Location: ../../../../../dashboard/index.php');
            die();
        }
    }else{
        header('Location: ../../../../../dashboard/index.php');
        die();
    }
    /////////////////////


    $dateField     =       filter_input(INPUT_POST,'date',FILTER_SANITIZE_STRING);
    $textField     =       filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);
    $linkField     =       filter_input(INPUT_POST,'link',FILTER_SANITIZE_STRING);


    if($_GET['type'] == 'new'){
        
        if($linkField == '')$linkField = '#';

        try {
    
            $createNotification = $connection->prepare(
                "INSERT INTO notificationtableapplication
                (
                    date, 
                    text,
                    link
                )
                VALUES
                (
                    :date, 
                    :text,
                    :link
                )"
            );
            $createNotification->bindParam(':date', $dateField);
            $createNotification->bindParam(':text', $textField);
            $createNotification->bindParam(':link', $linkField);
            
        
            $createNotification->execute();
        
            if ($createNotification->rowCount() > 0) {
                header('Location: ../../../index.php');
            }else{
                die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
            }
        } catch (PDOException $error) {
            die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
        }
    
    
    }  
    
    
    if($_GET['type'] == 'edit'){

        if($linkField == '')$linkField = '#';

        try {
    
            $updateNotification = $connection->prepare("UPDATE notificationtableapplication SET date = :date, text = :text, link = :link WHERE id = :id");
            $updateNotification->bindParam(':date', $dateField);
            $updateNotification->bindParam(':text', $textField);
            $updateNotification->bindParam(':link', $linkField);
            $updateNotification->bindParam(':id', $_GET['id']);
            $updateNotification->execute();
        
            if ($updateNotification->rowCount() > 0) {
                header('Location: ../../../index.php');
            }else{
                die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
            }
        } catch (PDOException $error) {
            die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
        }
    
    
    }

    if($_GET['type'] == 'delete'){
        try {
    
            $deleteNotification = $connection->prepare("DELETE FROM notificationtableapplication WHERE id = :id");
            $deleteNotification->bindParam(':id', $_GET['id']);
            $deleteNotification->execute();
        
            if ($deleteNotification->rowCount() > 0) {
                header('Location: ../../../index.php');
            }else{
                die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
            }
        } catch (PDOException $error) {
            die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
        }
    }

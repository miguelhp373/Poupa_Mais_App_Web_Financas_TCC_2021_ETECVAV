<?php
    session_start();
    require_once('../../../../../source/controller/connection.php');
    
    if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
        if ($_SESSION['Authentication'] == '') {
            $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
            header('Location: ../../../../login/index.php');
            

        }
    }
    

    $id_event   =   filter_input(INPUT_POST,'id_event',FILTER_SANITIZE_STRING);
    $date_ini   =   filter_input(INPUT_POST,'dateini',FILTER_SANITIZE_STRING);
    $title      =   filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
    $color      =   filter_input(INPUT_POST,'color_picker',FILTER_SANITIZE_STRING);


    $searchinfos = $connection->prepare("SELECT cod FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_cod      =   $getdata['cod'];
        }
    }


    try{
        $updadeEvent = $connection->prepare("UPDATE eventstableapplicartion SET title = :Ptitle, color = :Pcolor, start = :Pdateini, end = :Pdatefim WHERE id = :Pid_event AND coduser = :Pcoduser");
        
        $updadeEvent->bindParam(':Pcoduser',$user_cod );
        $updadeEvent->bindParam(':Ptitle',$title);
        $updadeEvent->bindParam(':Pcolor',$color );
        $updadeEvent->bindParam(':Pdateini',$date_ini);
        $updadeEvent->bindParam(':Pdatefim',$date_ini);
        $updadeEvent->bindParam(':Pid_event',$id_event);

        $updadeEvent->execute();
        
        if($updadeEvent->rowCount() > 0){
            header('location: ../index.php');
        }else{
            $_SESSION['Msg_error']  =   "Erro ao Tentar Alterar o Evento! Tente Novamente Mais Tarde.";
            header('location: ../index.php');
        }
        
       
    
    }catch(PDOException $error){
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
    }

    







?>
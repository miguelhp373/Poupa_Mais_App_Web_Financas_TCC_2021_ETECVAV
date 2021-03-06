<?php
   
   require_once('../../../../../source/controller/connection.php');
   
    session_start();
    
    if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
        if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
            $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
            header('Location: ../../../../login/index.php');
            

        }
    }
    


    $date_ini   = filter_input(INPUT_POST,'dateini',FILTER_SANITIZE_STRING);
    $title      = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
    $color      = filter_input(INPUT_POST,'color_picker',FILTER_SANITIZE_STRING);


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
        $saveEvent = $connection->prepare("INSERT INTO eventstableapplicartion (coduser,title, color, start, end) VALUES (:Pcoduser,:Ptitle, :Pcolor, :Pdateini, :Pdatefim)");
        
        $saveEvent->bindParam(':Pcoduser',$user_cod );
        $saveEvent->bindParam(':Ptitle',$title);
        $saveEvent->bindParam(':Pcolor',$color );
        $saveEvent->bindParam(':Pdateini',$date_ini);
        $saveEvent->bindParam(':Pdatefim',$date_ini);

        $saveEvent->execute();
        
        if($saveEvent->rowCount() > 0){
            header('location: ../index.php');
        }else{
            $_SESSION['Msg_error']  =   "Erro ao Tentar Criar a Conta! Tente Novamente Mais Tarde.";
            header('location: ../index.php');
        }
        
       
    
    }catch(PDOException $error){
        header('location: ../../../Page404/index.php');
        die;
    }

    







?>
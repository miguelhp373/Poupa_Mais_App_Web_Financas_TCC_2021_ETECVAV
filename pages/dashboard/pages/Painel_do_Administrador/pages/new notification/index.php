<?php

session_start();
require_once('../../../../../../source/controller/connection.php');

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


////////////////////////////
//LIMPA MENSAGENS DE ERRO
if (isset($_SESSION['Msg_error'])) {

    $_SESSION['Msg_error'] = '';
}

if (isset($_SESSION['Msg_sucess'])) {
    $_SESSION['Msg_sucess'] = '';
}
////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔔 Criar Nova Notificação</title>
    <link rel="shortcut icon" href="../../../../../../Favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../../../source/styles/components/button-back/main.css">

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    body{
        background-color: var(--input-background);
    }

    .container {
        width: 100%;
        height: 50vh;

        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;

        background-color: var(--input-background);

        margin-top: 100px;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        height: 100%;
        width: 100%;
    }

    .container-new-post {
        width: 800px;
        height: 800px;
        background-color: #FFFF;
        border-radius: 12px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    .title-container {
        margin: 25px;
    }

    .col-fields>form {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .col-fields>form>input, button {
        margin: 20px;
    }

    .col-fields>form>input{
        margin: 20px;
        width: 700px;

        border: none;
        border-radius: 12px;
        background-color: var(--input-background);
        padding: 8px;
    }

    .col-fields>form>button {
        width: 50%;
        height: 60px;
        background-color: var(--primary-color);
        color: var(--text-primary);
        border: none;
        border-radius: 12px;
    

    }
</style>

<body>
    <div class="container">
       
        <div class="content">
        <div class="btn_back_home">
            <a href="../../index.php" title="Voltar Para Tela Inicial">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
            <div class="container-new-post">
                <h1 class="title-container">Crie Notificação</h1>
                <div class="col-fields">
                    <form action="model/main.php?type=new" method="post">
                        <input type="text" name="text" placeholder="Texto" required autocomplete="off">
                        <input type="date" name="date"  maxlength="9" required>
                        <input type="text" name="link" placeholder="Link" autocomplete="off">
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</body>

</html>
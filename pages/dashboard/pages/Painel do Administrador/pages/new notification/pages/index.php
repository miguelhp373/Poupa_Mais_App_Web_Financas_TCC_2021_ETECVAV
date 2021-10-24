<?php

session_start();
require_once('../../../../../../../source/controller/connection.php');


////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../login/index.php');
        die();
    }
}

if (isset($_SESSION['ADM_USER'])) {
    if ($_SESSION['ADM_USER'] != 'root_user_acept') {
        header('Location: ../../../dashboard/index.php');
        die();
    }
} else {
    header('Location: ../../../dashboard/index.php');
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


try {

    $searchNotifications = $connection->prepare("SELECT id, text, link, date FROM notificationtableapplication");


    $searchNotifications->execute();

    if ($searchNotifications->rowCount() > 0) {

        $rowNotificationsALL = $searchNotifications->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador | Poupa+</title>
    <link rel="shortcut icon" href="../../../../Favicon.svg" type="image/x-icon">
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Styles -->
    <link rel="stylesheet" href="../../../../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../../../../source/styles/components/button-back/main.css">

    <style>

    </style>
</head>

<body>

    <div class="container_page">

        <div class="content_page" id="content-page">
            <div class="btn_back_home">
                <a href="../../../index.php" title="Voltar Para Tela Inicial">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>

            <br>
            <h1>
                &nbsp;
                <i class="far fa-bell"></i>
                Notificações
            </h1>
            <table class="table table-striped table-hover">
                <tr>
                    <th style="text-align: center;">#</th>
                    <th>Texto</th>
                    <th>Link</th>
                    <th style="text-align: center;">Data</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php if (isset($rowNotificationsALL)) {
                    foreach ($rowNotificationsALL as $getNotificationsAll) {
                ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $getNotificationsAll['id']; ?></td>
                            <td><?php echo $getNotificationsAll['text']; ?></td>
                            <td><?php echo $getNotificationsAll['link']; ?></td>
                            <td style="text-align: center;"><?php echo $getNotificationsAll['date']; ?></td>
                            <td>
                                <a href="view/edit.php?id=<?php echo $getNotificationsAll['id'];?>">
                                    Editar
                                </a>
                            </td>
                            <td><a href="../model/main.php?id=<?php echo $getNotificationsAll['id'];?>&type=delete">Apagar</a></td>
                        </tr>
                    <?php }
                } else { ?>

                    <h2 class="text-center">Nenhum Dado Encontrado</h2>

                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>
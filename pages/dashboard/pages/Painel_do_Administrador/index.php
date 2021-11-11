<?php

session_start();
require_once('../../../../source/controller/connection.php');


////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication'])) || (empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../login/index.php');
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

    $searchinfos = $connection->prepare("SELECT nome, email, telefone, image_user FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_name      =   $getdata['nome'];
            $user_email     =   $getdata['email'];
            //$user_cpf       =   $getdata['cpf'];
            $user_telefone  =   $getdata['telefone'];
            $image_user     =   $getdata['image_user'];
        }
    }
} catch (PDOException $error) {
    header('location: ../../../Page404/index.php');
    die;
}



try {

    $searchStatistUsers = $connection->prepare("SELECT COUNT(cod) as tot_users FROM userstableapplication");


    $searchStatistUsers->execute();

    if ($searchStatistUsers->rowCount() > 0) {

        $row = $searchStatistUsers->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $tot_users      =   $getdata['tot_users'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}

try {

    $searchStatistPosts = $connection->prepare("SELECT COUNT(id) AS tot_posts, SUM(views) AS tot_views FROM blog_posts");


    $searchStatistPosts->execute();

    if ($searchStatistPosts->rowCount() > 0) {

        $row = $searchStatistPosts->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $tot_Posts     =   $getdata['tot_posts'];
            $post_views    =    $getdata['tot_views'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}


try {

    $searchUsers = $connection->prepare("SELECT cod, nome, email, access FROM userstableapplication WHERE access = 'master' ");

    $searchUsers->execute();

    if ($searchUsers->rowCount() > 0) {

        $rowUsersALL = $searchUsers->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador | Poupa+</title>
    <link rel="shortcut icon" href="../../../../Favicon.png" type="image/x-icon">
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- DarkMode -->
    <script src="../js/dark_mode/main.js"></script>
    <link rel="stylesheet" href="../../../../source/root/darkmode.css">

    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Styles -->
    <link rel="stylesheet" href="../../../../source//styles/components/left-bar/main.css">
    <link rel="stylesheet" href="../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../source/styles/components/button-back/main.css">
    <link rel="stylesheet" href="../../../../source/styles/adm_page/main.css">

</head>

<body>
   <!------------------>
    <div class="container_page">
        <div class="nav-bar-left-desktop">

            <div class="user_info">
                <div class="image_user_icon">
                    <img src="../../../..<?php echo $image_user; ?>" alt="">
                </div>
                <div class="text_name_user">
                    <span>
                        <?php
                        echo $user_name;
                        ?>
                    </span>
                </div>
            </div>

            <a href="pages/user_organization/index.php" class="link_menu">
            <i class="fas fa-shield-alt"></i>
                Usuários
            </a>

            <a href="pages/my posts/index.php" class="link_menu">
                <i class="far fa-clone"></i>
                Meus Posts
            </a>

            <a href="pages/new post/index.php" class="link_menu">
                <i class="fas fa-file-medical"></i>
                Criar Post
            </a>

            <a href="pages/new notification/pages/index.php" class="link_menu">
                <i class="far fa-clone"></i>
                Notificações
            </a>

            <a href="pages/new notification/index.php" class="link_menu">
                <i class="far fa-bell"></i>
                Nova Notificação
            </a>

        </div>

        <div class="content_page" id="content-page">
            <div class="btn_back_home">
                <a href="../../index.php" title="Voltar Para Tela Inicial">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="content_dashboard">
                <div class="cards" style="width: 260px;">
                    <div class="col_left" style="margin-left: 26px;">
                        <strong>
                            <span><?php echo $tot_users; ?></span>
                        </strong>
                        <span>Usuários</span>
                    </div>
                    <div class="col_right">
                        <div class="icon_container">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    <div class="col_left">
                        <strong>
                            <span><?php echo $tot_Posts; ?></span>
                        </strong>
                        <span>Posts</span>
                    </div>
                    <div class="col_right">
                        <div class="icon_container">
                            <i class="far fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    <div class="col_left">
                        <strong>
                            <span><?php echo $post_views; ?></span>
                        </strong>
                        <span>Views</span>
                    </div>
                    <div class="col_right">
                        <div class="icon_container">
                            <i class="far fa-eye"></i>
                        </div>
                    </div>
                </div>

            </div>
            <br>
            <h1 class="text-adm-page">
                &nbsp;
                <i class="fas fa-user-shield"></i>
                Usuários Administradores
            </h1>
            <table class="table table-striped table-hover">
                <tr>
                    <th class="text-adm-page">#</th>
                    <th class="text-adm-page">Nome</th>
                    <th class="text-adm-page">Email</th>
                    <th style="text-align: center;" class="text-adm-page">Acesso</th>
                </tr>

                <?php if (isset($rowUsersALL)) {
                    foreach ($rowUsersALL as $getUsersAll) {
                ?>
                        <tr>
                            <td class="text-adm-page"><?php echo $getUsersAll['cod']; ?></td>
                            <td class="text-adm-page"><?php echo $getUsersAll['nome']; ?></td>
                            <td class="text-adm-page"><?php echo $getUsersAll['email']; ?></td>
                            <?php if ($getUsersAll['access'] === 'master') { ?>
                                <td style="text-align: center;" class="text-adm-page"><input type="checkbox" name="" id="" checked disabled></td>
                            <?php } ?>

                        </tr>
                    <?php }
                } else { ?>

                    <h2 class="text-center" class="text-adm-page">Nenhum Dado Encontrado</h2>

                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>
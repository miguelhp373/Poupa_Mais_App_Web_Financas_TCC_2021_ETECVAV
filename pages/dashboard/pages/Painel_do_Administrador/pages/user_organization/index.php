<?php

session_start();
require_once('../../../../../../source/controller/connection.php');



////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication'])) || (empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../login/index.php');
        die();
    }
}

if (isset($_SESSION['ADM_USER'])) {
    if ($_SESSION['ADM_USER'] != 'root_user_acept') {
        header('Location: ../../../../../dashboard/index.php');
        die();
    }
} else {
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


if (isset($_GET['user_string'])) {

    $emailParameter = filter_input(INPUT_GET, 'user_string', FILTER_SANITIZE_STRING);

    if (!empty($emailParameter)) {
        try {

            $searchUsers = $connection->prepare("SELECT cod, nome, email, access FROM userstableapplication WHERE email LIKE '%" . $emailParameter . "%'");
            $searchUsers->execute();

            if ($searchUsers->rowCount() > 0) {
                $searchUsersALL = $searchUsers->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $error) {
            die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
        }
    } else {
        try {

            $searchUsers = $connection->prepare("SELECT cod, nome, email, access FROM userstableapplication");
            $searchUsers->execute();

            if ($searchUsers->rowCount() > 0) {
                $searchUsersALL = $searchUsers->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $error) {
            die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
        }
    }
} else {
    try {

        $searchUsers = $connection->prepare("SELECT cod, nome, email, access FROM userstableapplication");
        $searchUsers->execute();

        if ($searchUsers->rowCount() > 0) {
            $searchUsersALL = $searchUsers->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }
}




?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Usuários | Poupa+</title>
    <link rel="shortcut icon" href="../../../../../../Favicon.svg" type="image/x-icon">
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Styles -->
    <link rel="stylesheet" href="../../../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../../../source/styles/components/button-back/main.css">

    <style>
        .container-top {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .container-top>i,
        h1,
        button,
        input {
            margin: 10px;
        }

        .search-input {
            width: 500px;
            height: 38px;
            font-size: 15px;
            border-radius: 30px;
            border: 1px solid;
            padding-left: 7px;
        }
        .btn{
            border-radius: 30px !important;
        }
    </style>

<script>
        <?php

        if (isset($_GET['deleteButton'])) {
            echo '
                var box =    confirm("Você Tem Certeza, Deseja Apagar a Conta? Após Isso o Usuário Não Poderá Acessar Sua Conta!");

                if(box == true){
                    window.location.href = "model/Main.php?type=delete&user_id='.$_GET['user_id'].'"
                }else{
                    window.location.href = "index.php"   
                }
                
            ';
        }

        ?>
    </script>
</head>

<body>

    <div class="container_page">

        <div class="content_page" id="content-page">
            <div class="btn_back_home">
                <a href="../../index.php" title="Voltar Para Tela Inicial">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>

            <br>
            <h1>
                <form action="index.php" method="get">
                    <div class="container-top">
                        <i class="fas fa-shield-alt"></i>
                        <h1>Usuários</h1>

                        <input type="search" placeholder="Buscar Usuário Por Email" class="search-input" name="user_string" value="<?php if (isset($_GET['user_string'])) { echo $_GET['user_string'];}?>" style="width: 500px;height: 38px;font-size: 15px;">
                        <button class="btn btn-success">Buscar</button>

                    </div>
                </form>


            </h1>
            <table class="table table-striped table-hover">
                <tr>
                    <th style="text-align: center;">Cod</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th style="text-align: center;">Acesso</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php if (isset($searchUsersALL)) {
                    foreach ($searchUsersALL as $GetsearchUsersALL) {
                ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $GetsearchUsersALL['cod']; ?>
                            </td>
                            <td><?php echo $GetsearchUsersALL['nome']; ?></td>
                            <td><?php echo $GetsearchUsersALL['email']; ?></td>
                            <?php if ($GetsearchUsersALL['access'] === 'master') { ?>
                                <td style="text-align: center;" class="text-adm-page"><input type="checkbox" name="" id="" checked disabled></td>
                            <?php } else { ?>
                                <td style="text-align: center;" class="text-adm-page"><input type="checkbox" name="" id="" disabled></td>
                            <?php } ?>
                            <td>
                                <?php if ($GetsearchUsersALL['access'] === 'master') { ?>
                                    <a href="model/Main.php?type=remove&user_id=<?php echo $GetsearchUsersALL['cod']; ?>">
                                        Remover Nivel De Acesso
                                    </a>
                                <?php } else { ?>
                                    <a href="model/Main.php?type=root&user_id=<?php echo $GetsearchUsersALL['cod']; ?>">
                                        Tornar Administrador
                                    </a>
                                <?php } ?>

                            </td>
                            
                            <td><a href="index.php?deleteButton=true&user_id=<?php echo $GetsearchUsersALL['cod']; ?>">Apagar</a></td>

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
<?php

session_start();
require_once('../../../../source/controller/connection.php');



//validações/////////////////////////

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../login/index.php');
    }
}

if (isset($_SESSION['Msg_error'])) {

    $_SESSION['Msg_error'] = '';
}

if (isset($_SESSION['Msg_sucess'])) {
    $_SESSION['Msg_sucess'] = '';
}
/////////////////////////////////////////


//consulta usuário
try {

    $searchinfos = $connection->prepare("SELECT cod, nome, email, cpf, telefone, plano, image_user, saldo FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_cod       =   $getdata['cod'];
            $user_name      =   $getdata['nome'];
            $user_email     =   $getdata['email'];
            $user_cpf       =   $getdata['cpf'];
            $user_telefone  =   $getdata['telefone'];
            $user_plano     =   $getdata['plano'];
            $image_user     =   $getdata['image_user'];
            $saldo_user     =   $getdata['saldo'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
//////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA O TOTAL DE RECEITAS
try {

    $searchOperations = $connection->prepare("SELECT SUM(valor) AS TOTAL FROM operationsapplication  WHERE   idUser = :cod AND tipo = 'receita'");
    $searchOperations->bindParam(':cod', $user_cod);

    $searchOperations->execute();

    if ($searchOperations->rowCount() > 0) {

        $row = $searchOperations->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $receitas       =   $getdata['TOTAL'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA O TOTAL DE DESPESAS
try {

    $searchOperations = $connection->prepare("SELECT SUM(valor) AS TOTAL FROM operationsapplication  WHERE   idUser = :cod AND tipo = 'despesa'");
    $searchOperations->bindParam(':cod', $user_cod);

    $searchOperations->execute();

    if ($searchOperations->rowCount() > 0) {

        $row = $searchOperations->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $despesas       =   $getdata['TOTAL'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////


$datini = filter_input(INPUT_GET, 'dateini', FILTER_SANITIZE_STRING);
$datfim = filter_input(INPUT_GET, 'datefim', FILTER_SANITIZE_STRING);
$tipo   = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);


if ($datini == '') {
    $datini = '1999-01-01 00:00:00';
}

if ($datfim == '') {
    $datfim = '2099-01-01 00:00:00';
}

if (($tipo == null) || ($tipo == '') || ($tipo == 'todas')) {
    $tipo = null;
}


try {

    $searchOperations = $connection->prepare(
        "   SELECT cod, tipo , data, categoria, descricao, valor 
            FROM operationsapplication 
            WHERE   idUser = :cod  AND
                    data BETWEEN :datin AND :datfi  AND
                    :tip IS NULL AND cod > 0        OR
                    tipo = :tip
            ORDER BY cod DESC
        "
    );
    $searchOperations->bindParam(':cod', $user_cod);
    $searchOperations->bindParam(':datin', $datini);
    $searchOperations->bindParam(':datfi', $datfim);
    $searchOperations->bindParam(':tip', $tipo);

    $searchOperations->execute();

    if ($searchOperations->rowCount() > 0) {

        $rowOperation = $searchOperations->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Dashboard | Nome do App</title>

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../source/styles/dashboard/transaction/main.css">
    <link rel="stylesheet" href="../../../../source/styles/components/button-back/main.css">
    <link rel="stylesheet" href="../../../../source/styles/mobile/transact_page/main.css">
    <link rel="stylesheet" href="../../../../source/styles/components/nav-bar-mobile/main.css">

    <!-- Mask Input JS -->
    <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>

    <!-- Botão do Filtro Open e Close -->
    <script src="js/btn_filter.js"></script>
</head>

<body>
    <div class="container_page">
        <!--NavBar Mobile-->
        <div class="nav_bar_top_mobile">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mobile-navbar">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../../index.php">Logo</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars btn_menu"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link" href="../Transacoes/index.php">Transações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Dicas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../Ajuda/ajuda.php">Ajuda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../../login/index.php?login=logout">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!------------------>
        <!--NavBar Desktop-->
        <div class="nav-bar-left-desktop">

            <div class="user_info">
                <div class="image_user_icon">
                    <img src="../../../../<?php echo $image_user; ?>" alt="">
                </div>
                <div class="text_name_user">
                    <span>
                        <?php
                        //nome do usuário pego pelo banco de dados
                        echo $user_name;
                        ?>
                    </span>
                </div>
            </div>

            <a href="../../index.php" class="link_menu">
                <i class="fas fa-home"></i>
                Home
            </a>

            <a href="../Minha conta/index.php" class="link_menu">
                <i class="fas fa-user-alt"></i>
                Minha Conta
            </a>

            <a href="../Calendario/index.php" class="link_menu">
                <i class="far fa-calendar-alt"></i>
                Calendário
            </a>

            <a href="#" class="link_menu">
                <i class="fas fa-pencil-ruler"></i>
                Dicas
            </a>

            <a href="../Ajuda/ajuda.ph" class="link_menu">
                <i class="fas fa-question"></i>
                Ajuda
            </a>


            <a href="../../../login/index.php?login=logout" class="link_menu">
                <i class="fas fa-door-open"></i>
                Sair
            </a>

        </div>
        <!------------------>

        <!---ContentPage Desktop--->
        <div class="content_page">
            <div class="btn_back_home">
                <a href="../../index.php">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="row_button_filter">
                <h1>Transações</h1>
                <button id="btn_filter_show">
                    <i class="fas fa-filter"></i>
                </button>
            </div>

            <div class="container_content_grid">

                <table class="table table-bordered table-hover">
                    <thead style="
                               background-color: #dfe6e9;
                    ">
                        <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                            <th>Valor</th>

                        </tr>
                    </thead>

                    <?php if (isset($rowOperation)) {
                        foreach ($rowOperation as $getOperation) {
                    ?>
                            <tbody style="
                                    cursor: pointer;
                                    background-color: #FFFF;
                            ">
                                <tr>
                                    <td><?php echo $getOperation['cod']; ?></td>
                                    <?php if ($getOperation['tipo'] == 'receita') { ?>
                                        <td class="text-success"><?php echo strtoupper($getOperation['tipo']); ?></td>
                                    <?php } else { ?>
                                        <td class="text-danger"><?php echo strtoupper($getOperation['tipo']); ?></td>
                                    <?php } ?>
                                    <td><?php echo date('d/m/y', strtotime($getOperation['data'])); ?></td>
                                    <td><?php echo $getOperation['categoria']; ?></td>
                                    <td><?php echo $getOperation['descricao']; ?></td>
                                    <td>R$ <?php echo number_format($getOperation['valor'], 2, ',', '.'); ?></td>

                                </tr>
                            </tbody>
                        <?php }
                    } else { ?>

                        <h2 class="text-center">Nenhum Dado Encontrado</h2>

                    <?php } ?>
                </table>


            </div>
        </div>
        <!------------------>

        <!--Content-Mobile------->
        <div class="content-page-mobile">
            <div class="btn_back_home">
                <a href="../../index.php" style="display: flex;flex-direction: row;">
                    <i class="fas fa-arrow-left"></i>
                    <h1 style="color: black; margin: 20px;">
                        Transações
                    </h1>
                </a>
            </div>


            <div class="container-content-grid-transactions">

                <div class="top-container-grid">
                    <div class="container-left-top">
                        <i class="fas fa-university" style="font-size: 22px;"></i>
                        <div class="text-container">
                            <span>Saldo Atual</span>
                            <span>R$ <?php echo number_format($saldo_user, 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <div class="container-right-top">
                        <i class="fas fa-wallet" style="font-size: 22px;"></i>
                        <div class="text-container">
                            <span>Balanço Mensal</span>
                            <span>R$ <?php echo number_format($receitas - $despesas, 2, ',', '.') ?></span>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="content-grid-container">

                    <?php if (isset($rowOperation)) {
                        foreach ($rowOperation as $getOperation) {
                    ?>
                            <div class="row-card-content">
                                <div class="icon-left">
                                    <?php if ($getOperation['tipo'] == 'receita') { ?>
                                        <img src="../../../../source/assets/icons/icon_line_up.png" alt="">
                                    <?php } else { ?>
                                        <img src="../../../../source/assets/icons/icon_line_down.png" alt="">
                                    <?php } ?>

                                </div>
                                <div class="title-column">
                                    <div class="title-description-row">
                                        <span class="title-row"><?php echo $getOperation['descricao']; ?></span>
                                        <span class="type-row"><?php echo $getOperation['categoria']; ?></span>
                                    </div>
                                </div>
                                <div class="currency-value-display">
                                    R$ <?php echo number_format($getOperation['valor'], 2, ',', '.'); ?>
                                </div>
                            </div>

                        <?php }
                    } else { ?>

                        <h2 class="text-center">Nenhum Dado Encontrado</h2>

                    <?php } ?>


                </div>
            </div>
        </div>
        <!------------------>
        <!--POPUP-->
        <div class="popup_filter hidden">
            <div class="row_content">
                <div class="col_button_popup_close">
                    <button id="close_pop_up" class="close_pop_up">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="column_content">

                    <div class="content">
                        <br>
                        <div class="title_popup">
                            <h1>Filtro</h1>
                        </div>
                        <form action="index.php" method="GET">
                            <br>

                            <div class="col_dates">
                                <label for="date_input" class="lb_dates">
                                    Data Inicial
                                    &nbsp;&nbsp;
                                    <input type="date" name="dateini" class="date_input" maxlength="9">
                                </label>

                                <label for="date_input" class="lb_dates">
                                    Data Final
                                    &nbsp;&nbsp;
                                    <input type="date" name="datefim" class="date_input" maxlength="9">
                                </label>
                            </div>
                            <div class="row_field_00">
                                <select name="tipo" id="" class="sel_tip">
                                    <option value="null">Tipo de Transação</option>
                                    <option value="receita">Receitas</option>
                                    <option value="despesa">Despesas</option>
                                    <option value="todas">Todas</option>
                                </select>
                            </div>

                            <div class="row_btn_submit">
                                <button type="submit">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!---FIM POPUP-->
    </div>


</body>

</html>
<?php

session_start();
require_once('../../../../source/controller/connection.php');

////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../login/index.php');
    }
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


////////////////////////////
//USER INFORMATIONS
try {

    $searchinfos = $connection->prepare("SELECT cod, nome, email, cpf, telefone, plano, image_user FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_name      =   $getdata['nome'];
            $user_email     =   $getdata['email'];
            $user_cpf       =   $getdata['cpf'];
            $user_telefone  =   $getdata['telefone'];
            $user_plano     =   $getdata['plano'];
            $image_user     =   $getdata['image_user'];
            $user_cod       =   $getdata['cod'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
////////////////////////////

////////////////////////////
//GET CHART INFORMATIONS RECEITAS
try {

    $getMonthTot = $connection->prepare(
        "SELECT 
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 1  AND tipo = 'receita')  as 'jan', 
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 2  AND tipo = 'receita')  as 'feb',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 3  AND tipo = 'receita')  as 'mar',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 4  AND tipo = 'receita')  as 'apr',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 5  AND tipo = 'receita')  as 'may',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 6  AND tipo = 'receita')  as 'jun',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 7  AND tipo = 'receita')  as 'jul',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 8  AND tipo = 'receita')  as 'aug', 
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 9  AND tipo = 'receita')  as 'sep',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 10 AND tipo = 'receita') as 'oct',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 11 AND tipo = 'receita') as 'nov',
        (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 12 AND tipo = 'receita') as 'dez'
        FROM  operationsapplication
        WHERE  idUser = :cod    
        "
    );

    $getMonthTot->bindParam(':cod', $user_cod);

    $getMonthTot->execute();

    if ($getMonthTot->rowCount() > 0) {
        $rowREC = $getMonthTot->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rowREC as $gettotPerMonthR) {
            $januaryR         =   $gettotPerMonthR['jan'];
            $februaryR        =   $gettotPerMonthR['feb'];
            $marchR           =   $gettotPerMonthR['mar'];
            $aprilR           =   $gettotPerMonthR['apr'];
            $mayR             =   $gettotPerMonthR['may'];
            $juneR            =   $gettotPerMonthR['jun'];
            $julyR            =   $gettotPerMonthR['jul'];
            $augustR          =   $gettotPerMonthR['aug'];
            $septemberR       =   $gettotPerMonthR['sep'];
            $octoberR         =   $gettotPerMonthR['oct'];
            $novemberR        =   $gettotPerMonthR['nov'];
            $dezemberR        =   $gettotPerMonthR['dez'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
////////////////////////////

////////////////////////////
//GET CHART INFORMATIONS DESPESAS
try {

    $getMonthDESP = $connection->prepare(
        "SELECT 
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 1  AND tipo = 'despesa')  as 'jan', 
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 2  AND tipo = 'despesa')  as 'feb',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 3  AND tipo = 'despesa')  as 'mar',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 4  AND tipo = 'despesa')  as 'apr',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 5  AND tipo = 'despesa')  as 'may',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 6  AND tipo = 'despesa')  as 'jun',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 7  AND tipo = 'despesa')  as 'jul',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 8  AND tipo = 'despesa')  as 'aug', 
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 9  AND tipo = 'despesa')  as 'sep',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 10 AND tipo = 'despesa') as 'oct',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 11 AND tipo = 'despesa') as 'nov',
            (SELECT SUM(valor) FROM operationsapplication WHERE MONTH(data) = 12 AND tipo = 'despesa') as 'dez'
        FROM  operationsapplication
        WHERE idUser = :cod    
        "
    );

    $getMonthDESP->bindParam(':cod', $user_cod);

    $getMonthDESP->execute();

    if ($getMonthDESP->rowCount() > 0) {

        $rowDesp = $getMonthDESP->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rowDesp as $gettotPerMonth) {
            $january         =   $gettotPerMonth['jan'];
            $february        =   $gettotPerMonth['feb'];
            $march           =   $gettotPerMonth['mar'];
            $april           =   $gettotPerMonth['apr'];
            $may             =   $gettotPerMonth['may'];
            $june            =   $gettotPerMonth['jun'];
            $july            =   $gettotPerMonth['jul'];
            $august          =   $gettotPerMonth['aug'];
            $september       =   $gettotPerMonth['sep'];
            $october         =   $gettotPerMonth['oct'];
            $november        =   $gettotPerMonth['nov'];
            $dezember        =   $gettotPerMonth['dez'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gráfico de Gastos Mensais | Poupa+</title>
    <link rel="shortcut icon" href="../../../../Favicon.svg" type="image/x-icon">
    
    <link rel="stylesheet" href="style.css">
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../source/styles/components/left-bar/main.css">
    <link rel="stylesheet" href="../../../../source/styles/dashboard/account_edit/main.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        @media(min-width:1000px) {
            .page_not_found_gif {
                display: none;
            }
        }

        @media(max-width:1000px) {
            .container_page {
                display: none;
            }

            .page_not_found_gif {
                width: 100%;
                height: 100vh;
            }

            .page_not_found_gif>img {
                width: 100%;
                height: auto;

            }

            .page_not_found_gif>a {
                margin: 20px;
                margin-top: 18px;
                padding: 20px;
                background-color: var(--primary-color);
                color: var(--text-primary);
                border-radius: 12px;

            }
        }
    </style>

</head>


<body>
<div class="page_not_found_gif">
        <a href="../../index.php">
            Voltar
        </a>
        <img src="../../../../source/assets/udraw_images/page-not-found-error-404.gif" alt="">
    </div>
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
            <a href="../../index.php" class="link_menu">
                <i class="fas fa-home"></i>
                Home
            </a>

            <a href="../Minha conta/index.php" class="link_menu">
                <i class="fas fa-user-alt"></i>
                Minha Conta
            </a>

            <!-- <a href="../../../blog/index.php" class="link_menu">
            <i class="fas fa-rss-square"></i>   
                Blog
            </a> -->

            <a href="../Ajuda/index.php" class="link_menu">
                <i class="fas fa-question"></i>
                Ajuda
            </a>


            <a href="../../../login/index.php?login=logout" class="link_menu">
                <i class="fas fa-door-open"></i>
                Sair
            </a>

        </div>

        <div class="content_page" id="content-page" style="margin-top: -155px;">
            <h1 id="Title-Page">Gráfico De Transações Mensal</h1>
            <div id="uknowData"></div>
            <canvas id="chartApplication" style="width: 100%;height: 80vh;"></canvas>
        </div>
    </div>

    <script>
        <?php
        if((isset($rowREC))&&(isset($rowDesp))){
            echo "
            var ctx = document.getElementById('chartApplication').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    datasets: [{
                        label: 'Despesas Mensais',
                        data: [".ceil(number_format($january, 2, '.', ',')).",".ceil(number_format($february, 2, '.', ',')).",".ceil(number_format($march, 2, '.', ',')).",".ceil(number_format($april, 2, '.', ',')).",".ceil(number_format($may, 2, '.', ',')).",".ceil(number_format($june, 2, '.', ',')).",".ceil(number_format($july, 2, '.', ',')).",".ceil(number_format($august, 2, '.', ',')).",".ceil(number_format($september, 2, '.', ',')).",".ceil(number_format($october, 2, '.', ',')).",".ceil(number_format($november, 2, '.', ',')).",".ceil(number_format($dezember, 2, '.', ','))."],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Receitas Mensais',
                        data: [".ceil(number_format($januaryR, 2, ',', '.')).",".ceil(number_format($februaryR, 2, '.', ',')).",".ceil(number_format($marchR, 2, '.', ',')).",".ceil(number_format($aprilR, 2, '.', ',')).",".ceil(number_format($mayR, 2, '.', ',')).",".ceil(number_format($juneR, 2, '.', ',')).",".ceil(number_format($julyR, 2, '.', ',')).",".ceil(number_format($augustR, 2, '.', ',')).",".ceil(number_format($septemberR, 2, '.', ',')).",".ceil(number_format($octoberR, 2, '.', ',')).",".ceil(number_format($novemberR, 2, '.', ',')).",".ceil(number_format($dezemberR, 2, '.', ','))."],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }    
                ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        ";
        }else{
            echo "
            document.getElementById('uknowData').innerHTML += `<h2 style='Text-align: center;'>Nenhum Dado Encontrado.</h2>`
            document.getElementById('Title-Page').style.display = 'none';
            ";
        }
       ?>
       
    </script>
</body>

</html>
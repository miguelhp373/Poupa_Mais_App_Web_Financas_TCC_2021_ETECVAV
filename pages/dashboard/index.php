<?php

session_start();
require_once('../../source/controller/connection.php');

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
  if ($_SESSION['Authentication'] == '') {
    $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
    header('Location: ../login/index.php');
  }
}

if (isset($_SESSION['Msg_error'])) {

  $_SESSION['Msg_error'] = '';
}

if (isset($_SESSION['Msg_sucess'])) {
  $_SESSION['Msg_sucess'] = '';
}


try {

  $searchinfos = $connection->prepare("SELECT nome, email, cpf, telefone, plano, image_user FROM userstableapplication WHERE email = :email LIMIT 1");
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
    }
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
  <title>Dashboard | Nome do App</title>

  <!--Jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!--Bootstrap v5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  <!--Icones FontAwesome-->
  <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="../../source/root/root.css">
  <link rel="stylesheet" href="../../source/styles/dashboard/main.css">
  <link rel="stylesheet" href="../../source/styles/mobile/dash_page/main.css">

  <script src="js/api_money/main.js"></script>

</head>

<body>
  <!--NavBar Mobile-->
  <div class="nav_bar_top_mobile">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars btn_menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#Info_section">O Que Somos?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#planos_account">Nossos Planos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#form_contact">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../dicas/index.php">Dicas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../login/index.php?page=login+from+create">Entrar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <!------------------>
  <div class="container_page">

    <!--NavBar Desktop-->
    <div class="nav-bar-left-desktop">

      <div class="user_info">
        <div class="image_user_icon">
          <img src="../../<?php echo $image_user; ?>" alt="">
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

      <a href="pages/minha conta/index.php" class="link_menu">
        <i class="fas fa-user-alt"></i>
        Minha Conta
      </a>
      <a href="pages/todas atividades/index.php" class="link_menu">
      <i class="fas fa-coins"></i>
        Transações
      </a>
      <a href="pages/todas atividades/index.php" class="link_menu">
        <i class="far fa-calendar-alt"></i>
        Calendário
      </a>
      
      <a href="pages/todas atividades/index.php" class="link_menu">
      <i class="fas fa-pencil-ruler"></i>
        Dicas
      </a>

      <a href="pages/todas atividades/index.php" class="link_menu">
      <i class="fas fa-question"></i>
        Dicas
      </a>
      
 
      <a href="../login/index.php?login=logout" class="link_menu">
        <i class="fas fa-door-open"></i>
        Sair
      </a>

    </div>
    <!------------------>
    <div class="content_page" id="content-page">
      <div class="notification_button">
        <button class="btn btn-secondary" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false" title="Notificações">
          <i class="fas fa-bell"></i>
          
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <li>
            <a class="dropdown-item" href="#">
              Nenhuma Notificação
            </a>
          </li>
          <!-- <li>
            <hr class="dropdown-divider">
          </li> -->
        </ul>
      </div>
      <div class="container">
        <div class="row d-flex justify-content-around">

          <div class="col" style="width: 350px;">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-landmark icon-01"></i>
                <h2>Saldo</h2>
              </div>
              <span class="Saldo_total">R$ 9999,99</span>
            </div>
          </div>

          <div class="col">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-arrow-circle-up icon-01"></i>
                <h2>Receitas</h2>
              </div>
              <span class="Saldo_total text-success">R$ 9999,99</span>
            </div>
          </div>

          <div class="col">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-arrow-circle-down icon-01"></i>
                <h2>Despesas</h2>
              </div>
              <span class="Saldo_total text-danger">R$ 9999,99</span>
            </div>
          </div>

          <!--COTAÇÃO DAS MOEDAS COM API AWESOME-->

          <div class="col" style="width: 100px;">
            <div class="card-saldo" style="height: 300px;">
              <div class="icon_card_saldo">
                <i class="far fa-calendar-alt icon-01"></i>
                <h2>
                  Cotação de Moedas
                </h2>
              </div>
              <div class="row-cotation">
                <div class="span-left">
                  <span>
                    Dolar
                  </span>
                </div>
                <div class="span-right">
                  <span id="dollar_cotation" style="font-weight: bold;">
                    R$
                    <!--Aqui Retorna da API-->
                  </span>
                </div>
              </div>

              <div class="row-cotation">
                <div class="span-left">
                  <span>
                    Euro
                  </span>
                </div>
                <div class="span-right">
                  <span id="eur_cotation" style="font-weight: bold;">
                    R$
                    <!--Aqui Retorna da API-->
                  </span>
                </div>
              </div>

              <div class="row-cotation">
                <div class="span-left">
                  <span>
                    BitCoin
                  </span>
                </div>
                <div class="span-right">
                  <span id="bitcoin_cotation" style="font-weight: bold;">
                    R$
                    <!--Aqui Retorna da API-->
                  </span>
                </div>
              </div>
            </div>
          </div>


          <!--------------------------------------->

          <div class="col">
            <div class="card-saldo" style="height: 300px;">
              <div class="icon_card_saldo">
                <i class="far fa-calendar-alt icon-01"></i>
                <h2>Lançamentos Futuros</h2>
              </div>
              <ul>
                <li>Conta de Luz -
                  <span style="font-weight: bold;">
                    R$300,00
                  </span>
                </li>
                <li>Conta da Internet -
                  <span style="font-weight: bold;">
                    R$290,00
                  </span>
                </li>
                <li>Parcela do Carro -
                  <span style="font-weight: bold;">
                    R$900,00
                  </span>
                </li>
              </ul>
            </div>
          </div>

          <div class="col">
            <div class="card-saldo" style="height: 300px;">
              <div class="icon_card_saldo">
                <i class="fas fa-balance-scale icon-01"></i>
                <h2>Balanço Mensal</h2>
              </div>
              <span class="Saldo_total text-success">R$ 9999,99</span>
              <span class="Saldo_total text-danger">R$ 9999,99</span>
              <hr>
              <span class="Saldo_total">R$ 9999,99</span>
            </div>
          </div>
        </div>
      </div>


      <!--Botão Expansivel-->

      <div class="fab" id="fab">
        <button class="main" title="Menu">
          <i class="fas fa-plus icon-menu-plus" id="icon-menu-plus"></i>
        </button>
        <ul>
          <li>
            <a href="#">
              <button title="Nova Receita">
                <img src="../../source/assets/icons/icon_line_up.png" alt="" style="width: 20px; height: auto;">
              </button>
            </a>
          </li>
          <li>
            <a href="#">
              <button title="Nova Despesa">
                <img src="../../source/assets/icons/icon_line_down.png" alt="" style="width: 20px; height: auto;">
              </button>
            </a>
          </li>
          <li>
            <a href="pages/grafico mensal/index.php?page=chart">
              <button title="Gráfico Mensal">
                <i class="fas fa-chart-bar"></i>
              </button>
            </a>
          </li>
        </ul>
      </div>

    </div>

  </div>


  <script>
    function toggleFAB(fab) {
      if (document.querySelector(fab).classList.contains('show')) {
        document.querySelector(fab).classList.remove('show');
        $('#icon-menu-plus').css({
          transform: 'rotate(0deg)'
        })
      } else {
        document.querySelector(fab).classList.add('show');
        $('#icon-menu-plus').css({
          transform: 'rotate(45deg)'
        })

      }
    }

    document.querySelector('.fab .main').addEventListener('click', function() {
      toggleFAB('.fab');
    });

    document.querySelectorAll('.fab ul li button').forEach((item) => {
      item.addEventListener('click', function() {
        toggleFAB('.fab');
      });
    });
  </script>
  <!---------------------->

</body>

</html>
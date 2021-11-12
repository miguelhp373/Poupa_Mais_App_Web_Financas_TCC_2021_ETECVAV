<?php
session_start();
require_once('../../source/controller/connection.php');

date_default_timezone_set('America/Sao_Paulo');

////////////////////////////////////////////////////////////////////////////////////////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
  if ((empty($_SESSION['Authentication'])) || (empty($_SESSION['user_email']))) {
    $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
    header('Location: ../login/index.php');
  }
}
////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////
//LIMPA MENSAGENS DE ERRO
if (isset($_SESSION['Msg_error'])) {

  $_SESSION['Msg_error'] = '';
}

if (isset($_SESSION['Msg_sucess'])) {
  $_SESSION['Msg_sucess'] = '';
}
/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA INFORMAÇÕES DO USUÁRIO
try {

  $searchinfos = $connection->prepare("SELECT cod, nome, email, telefone, image_user, saldo, categorias, access FROM userstableapplication WHERE email = :email LIMIT 1");
  $searchinfos->bindParam(':email', $_SESSION['user_email']);

  $searchinfos->execute();

  if ($searchinfos->rowCount() > 0) {

    $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getdata) {
      $user_cod            =   $getdata['cod'];
      $user_name           =   $getdata['nome'];
      $user_email          =   $getdata['email'];
      //$user_cpf            =   $getdata['cpf'];
      $user_telefone       =   $getdata['telefone'];
      $image_user          =   $getdata['image_user'];
      $saldo_user          =   $getdata['saldo'];
      $access_user         =   $getdata['access'];

      if ($access_user == 'master') {
        $_SESSION['ADM_USER'] = 'root_user_acept';
      }
    }
  } else {
    $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
    header('Location: ../login/index.php');
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
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

/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA O TOTAL DE RECEITAS POR MÊS
try {

  $searchOperationsPerMonth = $connection->prepare("SELECT SUM(valor) AS TOTAL FROM operationsapplication  WHERE   idUser = :cod AND tipo = 'receita' AND MONTH(data) = MONTH(NOW())");
  $searchOperationsPerMonth->bindParam(':cod', $user_cod);

  $searchOperationsPerMonth->execute();

  if ($searchOperationsPerMonth->rowCount() > 0) {

    $row = $searchOperationsPerMonth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getdata) {
      $receitasPerMonth       =   $getdata['TOTAL'];
    }
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA O TOTAL DE DESPESAS POR MÊS
try {

  $searchOperationsPerMonth = $connection->prepare("SELECT SUM(valor) AS TOTAL FROM operationsapplication  WHERE   idUser = :cod AND tipo = 'despesa' AND MONTH(data) = MONTH(NOW())");
  $searchOperationsPerMonth->bindParam(':cod', $user_cod);

  $searchOperationsPerMonth->execute();

  if ($searchOperationsPerMonth->rowCount() > 0) {

    $row = $searchOperationsPerMonth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getdata) {
      $despesasPerMonth       =   $getdata['TOTAL'];
    }
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////
//PESQUISA LANÇAMENTOS FUTUROS
try {

  $searchLancamento = $connection->prepare(
    "SELECT descricao, data, proximoAuto
    FROM operationsapplication 
    WHERE idUser   =   :cod  AND automatico = 'S' AND proximoAuto >  NOW()
    "
  );
  $searchLancamento->bindParam(':cod', $user_cod);

  $searchLancamento->execute();

  if ($searchLancamento->rowCount() > 0) {
    $rowLancamentos = $searchLancamento->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////

function newOperation($cod, $tipo, $data, $categoria, $descricao, $valor, $automatico, $connection)
{

  ////////////////////////////////////////////
  //remove a data automatica da data atual

  $removeAuto = null;
  $SetAuto    = 'N';

  try {
    $UpdateData = $connection->prepare("UPDATE operationsapplication SET proximoAuto = :data, automatico = :setAuto  WHERE cod = :cod LIMIT 1");
    $UpdateData->bindParam(':cod', $cod);
    $UpdateData->bindParam(':data', $removeAuto);
    $UpdateData->bindParam(':setAuto', $SetAuto);

    $UpdateData->execute();

    if ($UpdateData->rowCount() > 0) {

      if ($automatico !== null) {
        $automatico = "S";
        $dateAuto = date('Y-m-d', strtotime('+1 months', strtotime($data)));
      } else {
        $automatico = "N";
        $dateAuto = null;
      }

      /////////////////////////////////////////////////////////////////
      //PESQUISA SALDO
      $searchinfos = $connection->prepare("SELECT cod, saldo FROM userstableapplication WHERE email = :email LIMIT 1");
      $searchinfos->bindParam(':email', $_SESSION['user_email']);

      $searchinfos->execute();

      if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
          $user_cod      =   $getdata['cod'];
          $user_Saldo    =   $getdata['saldo'];
        }
      }
      //////////////////////////////////////////////////////////////
      //INSERT OPERATION

      try {



        $getValor       = str_replace(',', '.', str_replace('.', '', $valor));

        $insert = $connection->prepare("INSERT INTO operationsapplication (idUser, tipo , data, categoria, descricao, valor, automatico, proximoAuto) VALUES (:cod_user,:tipo, :data, :cate,  :descri, :valor, :auto,:dateAuto)");

        $insert->bindParam(':cod_user', $user_cod);
        $insert->bindParam(':tipo', $tipo);
        $insert->bindParam(':cate', $categoria);
        $insert->bindParam(':descri', $descricao);
        $insert->bindParam(':data', $data);
        $insert->bindParam(':valor', $getValor);
        $insert->bindParam(':auto', $automatico);
        $insert->bindParam(':dateAuto', $dateAuto);

        $insert->execute();


        if ($insert->rowCount() > 0) {


          //SALDO

          ///////////////
          //RECEITA
          if ($tipo == 'receita') {

            $saldo_atual    = str_replace(',', '.', str_replace('.', '', $user_Saldo));

            $newSaldo = $saldo_atual + $getValor;


            try {
              $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
              $UpdateSaldo->bindParam(':id', $user_cod);
              $UpdateSaldo->bindParam(':saldo', $newSaldo);

              $UpdateSaldo->execute();


              if ($UpdateSaldo->rowCount() > 0) {
                header('Location: index.php');
              }
            } catch (PDOException $error) {
              $_SESSION['Msg_error']  =   "Erro ao Tentar Adicionar Nova " . $tipo;
              header('Location: index.php');
              die();
            }
          }

          ////////////// 
          ////DESPESA
          if ($tipo == 'despesa') {

            $saldo_atual    = str_replace(',', '.', str_replace('.', '', $user_Saldo));

            $newSaldo = $saldo_atual - $getValor;

            try {
              $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
              $UpdateSaldo->bindParam(':id', $user_cod);
              $UpdateSaldo->bindParam(':saldo', $newSaldo);

              $UpdateSaldo->execute();


              if ($UpdateSaldo->rowCount() > 0) {
                header('Location: index.php');
                die();
              }
            } catch (PDOException $error) {
              $_SESSION['Msg_error_01']  =   "Erro ao Tentar Adicionar Nova " . $tipo;
              header('Location: ../index.php');
              die();
            }
          }
        } else {
          die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
        }
      } catch (PDOException $error) {
        die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
      }
    }
  } catch (PDOException $error) {
    header('Location: index.php');
    die();
  }
}



//////////////////////////////////////////////////////////////////////////////////////////////////


//automatização de operações

//pesquisa lancamentos
try {

  $searchLancamento = $connection->prepare(
    "SELECT cod, idUser, tipo , data, categoria, descricao, valor, automatico, proximoAuto
    FROM operationsapplication 
    WHERE idUser   =   :cod  AND automatico = 'S' AND proximoAuto =  now()
    "
  );
  $searchLancamento->bindParam(':cod', $user_cod);

  $searchLancamento->execute();

  if ($searchLancamento->rowCount() > 0) {

    $rowLancamentos = $searchLancamento->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rowLancamentos as $getdata) {
      $cod            =   $getdata['cod'];
      $idUser         =   $getdata['idUser'];
      $tipo           =   $getdata['tipo'];
      $data           =   $getdata['data'];
      $categoria      =   $getdata['categoria'];
      $descricao      =   $getdata['descricao'];
      $valor          =   $getdata['valor'];
      $automatico     =   $getdata['automatico'];
      $proximoAuto    =   $getdata['proximoAuto'];
    }

    newOperation($cod, $tipo, $data, $categoria, $descricao, $valor, $automatico, $connection);
    $searchLancamento = null;
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//PESQUISA DE NOTIFICAÇÕES
$getActualDate = date('Y-m-d');
try {

  $searchNotify = $connection->prepare("SELECT * FROM notificationtableapplication WHERE date = :date");
  $searchNotify->bindParam(':date', $getActualDate);
  $searchNotify->execute();

  if ($searchNotify->rowCount() > 0) {

    $notifyData = $searchNotify->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
//PESQUISA EVENTOS PARA NOTIFICAÇÕES
$getActualDate = date('Y-m-d');
try {

  $searchNotifyEvents = $connection->prepare("SELECT * FROM eventstableapplicartion WHERE start = :date AND coduser = :idUser");
  $searchNotifyEvents->bindParam(':date', $getActualDate);
  $searchNotifyEvents->bindParam(':idUser',  $user_cod);
  $searchNotifyEvents->execute();

  if ($searchNotifyEvents->rowCount() > 0) {

    $notifyDataEvents = $searchNotifyEvents->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
//BUSCA CATEGORIAS

try {

  $searchCat = $connection->prepare("SELECT categorias FROM userstableapplication WHERE email = :email LIMIT 1");
  $searchCat->bindParam(':email', $_SESSION['user_email']);

  $searchCat->execute();

  if ($searchCat->rowCount() > 0) {

    $rowCategorias = $searchCat->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rowCategorias as $getCategorias) {
      $user_categories = $getCategorias['categorias'];
      $decode_Json  = json_decode($user_categories, true);
    }
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}
/////////////////////////////////////////////////////////////////////////////////////////////////

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Poupa+</title>
  <link rel="shortcut icon" href="../../Favicon.svg" type="image/x-icon">

  <!--Jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../../source/jquery/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
  <script src="../../source/jquery/StartMask/main.js"></script>

  <!--Bootstrap v5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




  <!--Icones FontAwesome-->
  <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- DarkMode -->
  <script src="js/dark_mode/main.js"></script>
  <link rel="stylesheet" href="../../source/root/darkmode.css">

  <link rel="stylesheet" href="../../source/root/root.css">
  <link rel="stylesheet" href="../../source/styles/dashboard/main.css">
  <link rel="stylesheet" href="../..//source/styles/components/left-bar/main.css">
  <link rel="stylesheet" href="../../source/styles/dashboard/popupDashboard/main.css">
  <link rel="stylesheet" href="../../source/styles/dashboard/popup_categories/main.css">
  <link rel="stylesheet" href="../../source/styles/mobile/dash_page/main.css">
  <link rel="stylesheet" href="../../source/styles/dashboard/SwitchButton/main.css">
  <link rel="stylesheet" href="../../source/styles/components/nav-bar-mobile/main.css">

  <script src="js/api_money/main.js"></script>
  <script src="js/buttons/btn_add_receita.js"></script>
  <script src="js/popup/main.js"></script>



  <script>
    <?php
    //mensagem de erro
    if (isset($_SESSION['Msg_error_01']) and ($_SESSION['Msg_error_01'] !== null)) {
      echo "alert('" . $_SESSION['Msg_error_01'] . "')";
      unset($_SESSION['Msg_error_01']);
    }

    ?>
  </script>


</head>

<body>
  <!--NavBar Mobile-->
  <div class="nav_bar_top_mobile">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile-navbar">
      <div class="container-fluid mobile">
        <a class="navbar-brand" href="#">Poupa+</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars btn_menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="pages/Minha_conta/index.php">Minha Conta</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/Transacoes/index.php">Transações</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../blog/index.php">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/Ajuda/index.php">Ajuda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../login/index.php?login=logout">Sair</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <!------------------>
  <div class="container_page">

    <!--NavBar Desktop-->
    <div class="nav-bar-left-desktop" id="nav-bar-left-desktop">

      <div class="user_info">
        <div class="image_user_icon">
          <img src="../../<?php echo $image_user; ?>" alt="">
        </div>
        <div class="text_name_user">
          <span>
            <?php
            echo $user_name;
            ?>
          </span>
        </div>
      </div>

      <a href="pages/Minha_conta/index.php" class="link_menu">
        <i class="fas fa-user-alt"></i>
        Minha Conta
      </a>
      <a href="pages/Transacoes/index.php" class="link_menu">
        <i class="fas fa-coins"></i>
        Transações
      </a>
      <a href="pages/Calendario/index.php" class="link_menu">
        <i class="far fa-calendar-alt"></i>
        Calendário
      </a>

      <a href="../blog/index.php" class="link_menu">
        <i class="fas fa-rss-square"></i>
        Blog
      </a>

      <?php if ($access_user === 'master') { ?>

        <a href="pages/Painel_do_Administrador/index.php" class="link_menu">
          <i class="fas fa-tachometer-alt"></i>
          Painel ADM
        </a>

      <?php } ?>

      <a href="pages/Ajuda/index.php" class="link_menu">
        <i class="fas fa-question"></i>
        Ajuda
      </a>




      <a href="../login/index.php?login=logout" class="link_menu">
        <i class="fas fa-door-open"></i>
        Sair
      </a>

    </div>
    <!------------------>

    <div class="content_page" id="content-page">

      <div class="notification_button">
        <div class="title_page" style="width: 73%;">
          <h2>DashBoard</h2>
        </div>
        <div class="toggle-dark-mode-button">
          <span class="text-dark-mode-label">Modo Noturno</span>
          <label class="switch">
            <input type="checkbox" id="toggle_darkmode">
            <span class="slider round"></span>

          </label>
        </div>

        <button class="btn btn-secondary" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false" title="Notificações" style="margin-right: 10px;">
          <i class="fas fa-bell"></i>

        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">

          <strong class="text-center">
            &nbsp;
            🔔&nbsp;Notificações
            &nbsp;
          </strong>
          <li>
            <hr class="dropdown-divider">
          </li>
          <?php
          if (isset($notifyData)) {
            if ($notifyData != null) { ?>
              <?php
              foreach ($notifyData as $dataset) { ?>


                <li>
                  <a class="dropdown-item" href="<?php echo $dataset['link']; ?>">
                    &nbsp;<?php echo $dataset['text']; ?>
                  </a>
                </li>
              <?php } ?>
            <?php }
          } else { ?>
            <li>
              <a class="dropdown-item" href="#">
                Nenhuma Notificação
              </a>
            </li>
          <?php } ?>

          <li><br></li>

          <strong class="text-center">
            &nbsp;
            📅&nbsp;Eventos
            &nbsp;
          </strong>
          <li>
            <hr class="dropdown-divider">
          </li>
          <?php
          if (isset($notifyDataEvents)) {
            if ($notifyDataEvents != null) { ?>
              <?php foreach ($notifyDataEvents as $datasetEvents) { ?>
                <li>
                  <a class="dropdown-item" href="#">
                    &nbsp;<?php echo $datasetEvents['title'] . ' - ' . date('d/m/y', strtotime($datasetEvents['start'])); ?>
                  </a>
                </li>
              <?php } ?>
            <?php }
          } else { ?>
            <li>
              <a class="dropdown-item" href="#">
                Nenhuma Evento Hoje
              </a>
            </li>
          <?php } ?>


          <!-- <li>
            <hr class="dropdown-divider">
          </li> -->
        </ul>
      </div>

      <div class="container">

        <!--////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- Mensagem de erro ao apagar categoria -->
        <?php
        if (isset($_SESSION['MsgCategorieError'])) {
          if (($_SESSION['MsgCategorieError'] !== '')) {
            echo '<div class="alert alert-danger" role="alert" >
                    ' . $_SESSION['MsgCategorieError'] . '
                  </div> ';

            $_SESSION['MsgCategorieError'] = '';
            unset($_SESSION['MsgCategorieError']);

            echo '<script>
                    setTimeout(function () {
                      $(".alert").hide(); //oculta a mensagem de erro.
                    }, 2500)
                </script>';
          }
        }
        ?>
        <!--------------------------------------------------------------------------------------------->
        <div class="grid-display">

          <div class="card-01 cards">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-landmark icon-01"></i>
                <h2>Saldo</h2>
              </div>
              <span class="Saldo_total">R$ <?php echo number_format($saldo_user, 2, ',', '.') ?></span>
            </div>
          </div>

          <div class="card-02 cards">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-arrow-circle-up icon-01"></i>
                <h2>Receitas</h2>
              </div>
              <span class="Saldo_total text-success">R$ <?php echo number_format($receitas, 2, ',', '.') ?></span>
            </div>
          </div>

          <div class="card-03 cards">
            <div class="card-saldo">
              <div class="icon_card_saldo">
                <i class="fas fa-arrow-circle-down icon-01"></i>
                <h2>Despesas</h2>
              </div>
              <span class="Saldo_total text-danger">R$ <?php echo number_format($despesas, 2, ',', '.') ?></span>
            </div>
          </div>

          <!--COTAÇÃO DAS MOEDAS COM API AWESOME-->

          <div class="card-04 cards">
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

          <div class="card-05 cards">
            <div class="card-saldo" style="height: 300px;">
              <div class="icon_card_saldo">
                <i class="far fa-calendar-alt icon-01"></i>
                <h2>Lançamentos Futuros</h2>
              </div>
              <?php
              if (isset($rowLancamentos)) {
                foreach ($rowLancamentos as $getLancamentos) { ?>
                  <div class="Row_lancamentos">
                    <div class="span-left">
                      <span>
                        <?php echo $getLancamentos['descricao']; ?>
                      </span>
                    </div>
                    <div class="span-right">
                      <span id="date_event" style="font-weight: bold;">
                        <?php echo date('d/m/y', strtotime($getLancamentos['proximoAuto'])); ?>
                      </span>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>

          <div class="card-06 cards">
            <div class="card-saldo" style="height: 300px;">
              <div class="icon_card_saldo">
                <i class="fas fa-balance-scale icon-01"></i>
                <h2>Balanço Mensal</h2>
              </div>
              <span class="Saldo_total text-success">R$ <?php echo number_format($receitasPerMonth, 2, ',', '.') ?></span>
              <span class="Saldo_total text-danger">R$ <?php echo number_format($despesasPerMonth, 2, ',', '.') ?></span>
              <hr>
              <span class="Saldo_total">R$ <?php echo number_format($receitasPerMonth - $despesasPerMonth, 2, ',', '.') ?></span>
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
              <button title="Nova Receita" id="openPopReceita">
                <img src="../../source/assets/icons/icon_line_up.png" alt="" style="width: 20px; height: auto;">
              </button>
            </a>
          </li>
          <li>
            <a href="#">
              <button title="Nova Despesa" id="openPopDespesa">
                <img src="../../source/assets/icons/icon_line_down.png" alt="" style="width: 20px; height: auto;">
              </button>
            </a>
          </li>
          <li>
            <a href="pages/Grafico_mensal/index.php?page=chart">
              <button title="Gráfico Mensal">
                <i class="fas fa-chart-bar"></i>
              </button>
            </a>
          </li>
        </ul>
      </div>
      <!--------------------->

    </div>


    <!--POPUP-->
    <div class="popup_actions hidden">
      <div class="row_content">
        <div class="column_content col-con01">

          <div class="content" style="margin-top: 30px;">
            <br>
            <div class="title_popup">
              <h1 class="title_pop">
                <!--Aqui Vai o Titulo da Janela-->
              </h1>
            </div>
            <form action="" method="POST" id="form_actions" autocomplete="off">

              <div class="col_dates" style="margin-top: 10px;">
                <input type="text" name="value" class="fieds-pop money2" placeholder="Valor R$" required autocomplete="off">
                <br>
                <div class="row_categories">
                  <select name="categorias" id="" class="fieds-pop" required>
                    <option value="">Categorias</option>

                    <?php
                    if (isset($rowCategorias)) {
                      foreach ($decode_Json as $showCategorias) { ?>
                        <option value="<?php echo $showCategorias['description']; ?>"><?php echo $showCategorias['description']; ?> </option>
                    <?php }
                    } ?>
                  </select>
                  &nbsp;
                  <button type="button" id="openCategories" class="btn-new-categories">
                    <i class="fas fa-plus icon-menu-plus" id="icon-menu-plus"></i>
                  </button>
                </div>
                <br>
                <input type="text" name="descricao" class="fieds-pop" placeholder="Descrição" required>
                <br>
                <input type="date" name="date" class="fieds-pop" maxlength="9" required>
                <br>
                <label for="chkMensal">

                  <label class="switch">
                    <input type="checkbox" name="automatico">
                    <span class="slider round"></span>
                  </label>
                  <br>
                  <span>
                    Mensal
                  </span>
              </div>


              <div class="row_btn_submit">
                <button type="submit">
                  Salvar
                  &nbsp;
                  <i class="fas fa-check"></i>
                </button>
                <button id="close_pop_up" class="close-button-bottom">
                  Fechar
                  &nbsp;
                  <i class="fas fa-times"></i>
                </button>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
    <!---FIM POPUP-->

    <!--POPUP-->
    <div class="popup_categories hidden">
      <div class="row_content">
        <!-- <div class="col_button_popup_close">
          <button id="close_pop_up_02" class="close_pop_up">
            <i class="fas fa-times"></i>
          </button>
        </div> -->
        <div class="column_content col-con02">

          <div class="content" style="margin-top: 30px;">
            <br>
            <div class="title_popup">
              <h1 class="title_pop_02">
                Categorias
              </h1>
            </div>
            <form action="model/categories/addCategories.php" method="POST" id="form_actions" autocomplete="false">

              <div class="row_fields">
                <input type="text" name="newCategorie" class="fieds-pop" placeholder="Adicionar Categoria" required autocomplete="off">
                <button type="submit">
                  Adicionar
                </button>
              </div>
              <br><br>
              <div class="list_categories">
                <ul>

                  <?php
                  if (isset($rowCategorias)) {
                    foreach ($decode_Json as $showCategorias) { ?>

                      <li> <?php echo $showCategorias['description']; ?>
                        <a href="model/categories/deleteCategories.php?id=<?php echo $showCategorias['id']; ?>">
                          <i class="fas fa-trash"></i>
                        </a>
                      </li>
                  <?php }
                  } ?>
                </ul>
              </div>

              <div class="row_btn_submit" style="margin-bottom: 25px;">
                <button id="close_pop_up_02" class="close-button-bottom">
                  Fechar
                  &nbsp;
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!---FIM POPUP-->

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
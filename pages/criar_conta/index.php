<?php
session_start();

if (isset($_GET['register'])) {
  if ($_GET['register'] == 'true') {
    $param  = $_SESSION['email_user'];
  }
}

if (isset($_GET['page'])) {
  $_SESSION['Msg_error'] = '';
}

if (isset($_GET['wrong_fields'])) {
  if ($_GET['wrong_fields'] == 'true') {
    $param1  = $_SESSION['user_name_create_account'];
    $param2  = $_SESSION['user_email_create_account'];
    $param3  = $_SESSION['user_phone_create_account'];
    $param4  = $_SESSION['user_pass_create_account'];
    $param5  = $_SESSION['user_passconfirm_create_account'];
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Conta | Poupa+</title>
  <link rel="shortcut icon" href="../../Favicon.svg" type="image/x-icon">
  <!--Criado em 06/08/2021-->

  <!--Jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!--Bootstrap v5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!--Icones FontAwesome-->
  <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

  <!--Importante-->
  <link rel="stylesheet" href="../../source/root/root.css" />

  <!--Estilos-->
  <link rel="stylesheet" href="../../source/styles/main.css" />
  <link rel="stylesheet" href="../../source/styles/mobile/main_page/main.css" />

  <link rel="stylesheet" href="../../source/styles/newAccount/main.css" />
  <link rel="stylesheet" href="../../source/styles/mobile/newAccount_page/main.css" />

  <!-- Mask Input JS -->
  <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>
</head>

<body>
  <!--NavBar Desktop-->
  <div class="nav_bar_top">
    <div class="row_nav_bar">
      <div class="left_logo">
        <a href="#">
          <h1>Poupa<sup>+</sup></h1>
        </a>
      </div>

      <div class="right_menu">
        <a href="../../index.php">
          <span> Home </span>
        </a>
        <a href="../../index.php#Info_section">
          <span> O Que Somos? </span>
        </a>
        <a href="../../index.php#form_contact">
          <span> Fale Conosco </span>
        </a>

        <a href="../../pages/login/index.php?page=login+from+create">
          <span>Entrar</span>
        </a>
      </div>
    </div>
  </div>
  <!------------------>

  <!--NavBar Mobile-->
  <div class="nav_bar_top_mobile">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php">Poupa<sup>+</sup></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars" style="color: #FFFF;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../index.php#Info_section">O Que Somos?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../index.php#form_contact">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../blog/index.php">Blog</a>
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



  <main>
    <div class="background_cover_newaccount">
      <div class="container_newaccount">
        <div class="content">
          <h1>Criar Conta</h1>
          <?php if (isset($_SESSION['Msg_error'])) { ?>
            <span class="text-danger p-4"><?php echo $_SESSION['Msg_error']; ?></span>
          <?php } ?>

          <?php if (isset($_SESSION['sucess_msg'])) { ?>
            <span class="text-success p-4"><?php echo $_SESSION['sucess_msg']; ?></span>
          <?php } ?>
          <form action="Model/main.php" method="POST" class="form_content">
            <input type="text" name="name_user" id="name_user" placeholder="Nome Completo" required value="<?php if ((isset($param1))) {
                                                                                                                                          echo $param1;
                                                                                                                                        } else {
                                                                                                                                          echo '';
                                                                                                                                        } ?>"/>
            <input type="email" name="email_user" id="email_user" placeholder="Email" required value="<?php if ((isset($param2))) {
                                                                                                                                    echo $param2;
                                                                                                                                  } else {
                                                                                                                                    echo '';
                                                                                                                                  } ?>"/>
            <input type="text" name="phonenumber_user" id="phonenumber_user" class="inputnumberphoneformat" placeholder="Telefone" required value="<?php if ((isset($param3))) {
                                                                                                                                                                                echo $param3;
                                                                                                                                                                               } else {
                                                                                                                                                                                echo '';
                                                                                                                                                                               } ?>"/>

            <div class="fields">
              <input type="password" name="pass_user" id="id_password" placeholder="Senha" required value="<?php if ((isset($param4))) {
                                                                                                                                        echo $param4;
                                                                                                                                        } else {
                                                                                                                                         echo '';
                                                                                                                                        } ?>"/>
              <i class="fas fa-eye-slash" id="togglePassword01"></i>
            </div>

            <div class="fields">
              <input type="password" name="pass_user_confirm" id="id_password_confirm" placeholder="Confirmar Senha" required value="<?php if ((isset($param5))) {
                                                                                                                                                echo $param5;
                                                                                                                                              } else {
                                                                                                                                                echo '';
                                                                                                                                              } ?>"/>
              <i class="fas fa-eye-slash" id="togglePassword02"></i>
            </div>
            <button type="submit">Criar</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    $('#togglePassword01').click(function() {

      if (($('#togglePassword01').attr('class') === 'fas fa-eye-slash') && ($('#id_password').attr('type') === 'password')) {
        $('#id_password').attr('type', 'text')
        $('#togglePassword01').removeClass('fa-eye-slash')
        $('#togglePassword01').addClass('fa-eye')
      } else {
        $('#id_password').attr('type', 'password')
        $('#togglePassword01').removeClass('fa-eye')
        $('#togglePassword01').addClass('fa-eye-slash')

      }

    })

    $('#togglePassword02').click(function() {

      if (($('#togglePassword02').attr('class') === 'fas fa-eye-slash') && ($('#id_password_confirm').attr('type') === 'password')) {
        $('#id_password_confirm').attr('type', 'text')
        $('#togglePassword02').removeClass('fa-eye-slash')
        $('#togglePassword02').addClass('fa-eye')
      } else {
        $('#id_password_confirm').attr('type', 'password')
        $('#togglePassword02').removeClass('fa-eye')
        $('#togglePassword02').addClass('fa-eye-slash')

      }

    })
  </script>

</body>

</html>
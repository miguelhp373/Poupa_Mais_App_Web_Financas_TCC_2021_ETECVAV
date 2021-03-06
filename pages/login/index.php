<?php
require_once('../../source/controller/connection.php');
session_start();



///LOGOUT
if (isset($_GET['login'])) {

  if ($_GET['login'] == 'logout') {

    //clean cookies
    setcookie('email_storage_remember','', time() - (3600 * 5),'/',NULL,false, true);
    setcookie('pass_storage_remember','',time() - (3600 * 5),'/',NULL,false, true);

    //clean session
    session_unset();
    session_destroy();
  }
}


//caso usuário optou por lembrar a senha

if((isset($_COOKIE['email_storage_remember']))&&(isset($_COOKIE['pass_storage_remember']))){


  $passDecode = base64_decode($_COOKIE['pass_storage_remember']);

  $_SESSION['user_email'] = $_COOKIE['email_storage_remember'];
  $_SESSION['user_pass']  = $_COOKIE['pass_storage_remember'];

  try {

    $loginquery = $connection->prepare("SELECT email, senha FROM userstableapplication WHERE email = :email LIMIT 1");
    $loginquery->bindParam(':email', $_COOKIE['email_storage_remember']);

    $loginquery->execute();
} catch (PDOException $error) {
    die('<br>Erro Ao Tentar se comunicar com o Servidor! Tente Novamente Mais Tarde');
}


if ($loginquery->rowCount() > 0) {

    $row = $loginquery->fetch();

    if (password_verify($passDecode, $row["senha"])) {
        $_SESSION['Authentication'] = rand(1, 9);

        if (isset($_SESSION['sucess_msg'])) {
            $_SESSION['sucess_msg'] =   '';
        }

        header('Location: ../dashboard/index.php');
    } else {
        $_SESSION['user_email'] = '';
        $_SESSION['user_pass']  = '';
        $_SESSION['Authentication'] = '';
        $_SESSION['Msg_error'] = 'Senha Incorreta!';
        header('Location: index.php');
        die;
        //enviar uma mensagem de erro pro login
    }
} else {
  $_SESSION['user_email'] = '';
  $_SESSION['user_pass']  = '';
    $_SESSION['Msg_error'] = 'Usuário Não Encontrado!';
    $_SESSION['Authentication'] = '';
    header('Location: index.php');
    die;
    //enviar uma mensagem de erro pro login
}
}



if (isset($_GET['register'])) {
  if ($_GET['register'] == 'true') {
    $param  = $_SESSION['email_user'];
  }
}

if (isset($_GET['wrong_fields'])) {
  if ($_GET['wrong_fields'] == 'true') {
    $param  = $_SESSION['user_email'];
    $param1  = $_SESSION['user_pass'];
  }
}

if (isset($_GET['page'])) {
  $_SESSION['Msg_error'] = '';
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Poupa+</title>
  <link rel="shortcut icon" href="../../Favicon.png" type="image/x-icon">
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
  <link rel="stylesheet" href="../../source/styles/mobile/main_page/main.css">

  <link rel="stylesheet" href="../../source/styles/login/main.css">
  <link rel="stylesheet" href="../../source/styles/mobile/login_page/main.css">
  <link rel="stylesheet" href="../../source/styles/components/nav-bar-mobile/main.css">

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

        <a href="../criar_conta/index.php">
          <span>Criar Conta</span>
        </a>
      </div>
    </div>
  </div>
  <!------------------>

  <!--NavBar Mobile-->
  <div class="nav_bar_top_mobile">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile-navbar">
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
              <a class="nav-link" href="../criar_conta/index.php">Criar Conta</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </div>
  <!------------------>



  <main>
    <div class="background_cover_login">
      <div class="container_login">
        <div class="content">

          <h1>Login</h1>
          <?php if (isset($_SESSION['Msg_error'])) { ?>
            <span class="text-danger p-4"><?php echo $_SESSION['Msg_error']; ?></span>
          <?php } ?>

          <?php if (isset($_SESSION['sucess_msg'])) { ?>
            <span class="text-success p-4"><?php echo $_SESSION['sucess_msg']; ?></span>
          <?php } ?>
          <form action="Model/main.php" method="POST" class="form_content">
            <input type="email" name="email_user" id="email_user" value="<?php if ((isset($param))) {
                                                                            echo $param;
                                                                          } else {
                                                                            echo '';
                                                                          } ?>" placeholder="Email" required />
            <div class="fields_pass">
              <input type="password" name="user_pass" id="pass_field" placeholder="Senha" required  value="<?php if ((isset($param1))) {
                                                                                                             echo $param1;
                                                                                                                  } else {
                                                                                                                  echo '';
                                                                                                                  } ?>"/>
              <i class="fas fa-eye-slash" id="togglePassword01"></i>
            </div>
            <button type="submit">Entrar</button>

            <div class="remember-password">
              <div class="left-items">
                <input type="checkbox" name="remember_password" id="chkrememberpassword">
                <span>Lembrar Senha?</span>
              </div>
              <div class="right-items">
                <span>
                  <a href="../recuperar_senha/index.php?email=<?php if ((isset($param))) {
                                                                echo $param;
                                                              } else {
                                                                echo '';
                                                              } ?>">
                    Esqueceu Sua Senha?
                  </a>
                </span>
              </div>
            </div>


          </form>
        </div>
      </div>
    </div>
  </main>
  <script>
    $('#togglePassword01').click(function() {

      if (($('#togglePassword01').attr('class') === 'fas fa-eye-slash') && ($('#pass_field').attr('type') === 'password')) {
        $('#pass_field').attr('type', 'text')
        $('#togglePassword01').removeClass('fa-eye-slash')
        $('#togglePassword01').addClass('fa-eye')
      } else {
        $('#pass_field').attr('type', 'password')
        $('#togglePassword01').removeClass('fa-eye')
        $('#togglePassword01').addClass('fa-eye-slash')

      }

    })
  </script>
</body>

</html>
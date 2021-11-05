<?php
session_start();

if (isset($_SESSION['sucess_msg'])) {
  $_SESSION['sucess_msg'] = '';
}
if (isset($_SESSION['Msg_error'])) {
  $_SESSION['Msg_error'] = '';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Poupa+ | Web</title>
  <link rel="shortcut icon" href="Favicon.svg" type="image/x-icon">

  <link rel="manifest" href="manifest.json">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="application-name" content="Poupa+">
  <meta name="apple-mobile-web-app-title" content="Poupa+">
  <meta name="theme-color" content="#8854d0">
  <meta name="msapplication-navbutton-color" content="#8854d0">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-starturl" content="/">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" type="image/png" sizes="192x192" href="icon-192x192.png">
  <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="icon-192x192.png">
  <link rel="icon" type="image/png" sizes="256x256" href="icon-256x256.png">
  <link rel="apple-touch-icon" type="image/png" sizes="256x256" href="icon-256x256.png">
  <link rel="icon" type="image/png" sizes="384x384" href="icon-384x384.png">
  <link rel="apple-touch-icon" type="image/png" sizes="384x384" href="icon-384x384.png">
  <link rel="icon" type="image/png" sizes="512x512" href="icon-512x512.png">
  <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="icon-512x512.png">

  <!--Criado em 06/08/2021-->

  <!--Jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!--Bootstrap v5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!--Icones FontAwesome-->
  <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

  <!--Importante-->
  <link rel="stylesheet" href="source/root/root.css" />

  <!--Estilos-->
  <link rel="stylesheet" href="source/styles/main.css" />
  <link rel="stylesheet" href="source/styles/mobile/main_page/main.css">

  <!-- Mask Input JS -->
  <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>

  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('generate-sw.js');
    }
  </script>

  <style>
    .email-link {
      color: #FFF;
      transition: 0.2s;
    }

    .email-link :hover {
      color: #ecf0f1;
    }
  </style>

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
        <a href="#Info_section">
          <span> O Que Somos? </span>
        </a>
        <!-- <a href="#planos_account">
          <span>Nossos Planos</span>
        </a> -->
        <a href="#form_contact">
          <span> Fale Conosco </span>
        </a>
        <a href="pages/blog/index.php">
          <span> Blog </span>
        </a>
        <a href="pages/login/index.php?page=login+from+main">
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
        <a class="navbar-brand" href="#">Poupa<sup>+</sup></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars btn_menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#Info_section">O Que Somos?</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#planos_account">Nossos Planos</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="#form_contact">Fale Conosco</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/blog/index.php">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/login/index.php?page=login+from+main">Entrar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </div>
  <!------------------>

  <main>
    <!--Sessão de Apresentação do Site-->
    <div class="cover_background">
      <div class="coluna_top_left">
        <img src="source/assets/udraw_images/Personal finance-bro.svg" alt="landing_image" />
      </div>
      <div class="coluna_top_right">
        <h1>Bem Vindo</h1>
        <p>
          O Poupa+ é o seu melhor amigo no controle financeiro. <br> Adicione seus rendimentos,
          gastos e despesas na plataforma e tenha a sua vida financeira <br> sempre sob controle.
        </p>
        <a href="pages/criar_conta/index.php">
          <button class="btn_discovery">
            Começar
          </button>
        </a>

      </div>
    </div>
    <!--------------------------------->

    <!--Sessão de Informações-->
    <div class="info_section" id="Info_section">
      <div class="coluna_01">
        <h1>Quem Somos?</h1>
        <p>
          Essa plataforma foi desenvolvida para facilitar a gestão de suas finanças pessoais,
          descomplicando o dia a dia e trazendo informações de fácil visualização para que você
          entenda para onde está indo seu dinheiro e onde você pode economizar.
        </p>
        <a href="pages/criar_conta/index.php">
          <button class="btn_info">Começar</button>
        </a>
      </div>

      <div class="coluna_02">
        <img src="source/assets/udraw_images/undraw_personal_finance_tqcd.svg" alt="" />
      </div>
    </div>
    <!-------------------------->

    <!-- Form De Contato -->
    <div class="form_contact" id="form_contact" style="margin-top: 12px;">
      <section class="page-section" id="contact">
        <div class="container-fluid">
          <h2 class="
                page-section-heading
                text-center text-uppercase 
                mb-0
              ">
            Entre em contato conosco!
          </h2>
          <div class="row">
            <div class="col-lg-8 mx-auto container_contact">
              <form id="contactForm" action="https://formspree.io/f/mvodnbre" method="POST">
                <div class="control-group">
                  <div class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      ">
                    <label class="p-1">Nome</label>
                    <input class="form-control" id="name" name="nome" type="text" required="required" data-validation-required-message="Por favor insira seu nome." />
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      ">
                    <label class="p-1">Email</label>
                    <input class="form-control" id="email" type="email" name="email" required="required" data-validation-required-message="Insira seu endereço de email." />
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      ">
                    <label class="p-1">Telefone</label>
                    <input class="form-control inputnumberphoneformat" id="phone" name='telefone' type="tel" required="required" data-validation-required-message="Insira seu telefone." />
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div class="control-group">
                  <div class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      ">
                    <label class="p-1">Mensagem</label>
                    <textarea class="form-control message_area" id="message" name="mensagem" rows="5" required="required" data-validation-required-message="Digite sua mensagem."></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <br />
                <div id="sucesso"></div>
                <div class="form-group d-flex justify-content-center">
                  <button class="btn btn-primary btn-xl btn_submit_form" id="my-form-button">
                    Enviar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!------------------------>

    <!--Botão Voltar Ao Topo / Deve Ficar Em Baixo de Tudo, Mas dentro da Main-->
    <div class="btn_top">
      <a href="#">
        <button title="Ir Para o Topo">
          <i class="fas fa-chevron-up"></i>
        </button>
      </a>
    </div>
    <!-------------------------------------------------------------------------->
    <div class="footer_bar">
      <div class="copyright_text mx-auto text-center p-2">
        <span> 2021 | &copy;Poupa+</span>
        <br>
        <span><a href="mailto: apppoupamais@gmail.com" class="email-link">apppoupamais@gmail.com</a></span>
      </div>

    </div>
  </main>
  <script src="source/js/Formspree/home.js"></script>
</body>

</html>
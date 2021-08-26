<?php
  session_start();

  if(isset($_SESSION['sucess_msg'])){
    $_SESSION['sucess_msg'] = '';
  }
  if(isset($_SESSION['Msg_error'])){
    $_SESSION['Msg_error'] = '';
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aplicativo Web de Finanças</title>

    <!--Criado em 06/08/2021-->

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <!--Icones FontAwesome-->
    <script
      src="https://kit.fontawesome.com/bb41ae50aa.js"
      crossorigin="anonymous"
    ></script>

    <!--Importante-->
    <link rel="stylesheet" href="source/root/root.css" />

    <!--Estilos-->
    <link rel="stylesheet" href="source/styles/main.css" />
    <link rel="stylesheet" href="source/styles/mobile/main_page/main.css">

    <!-- Mask Input JS -->
    <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>

  </head>
  <body>
    <!--NavBar Desktop-->
    <div class="nav_bar_top">
      <div class="row_nav_bar">
        <div class="left_logo">
          <a href="#">
            <h1>LOGO</h1>
          </a>
        </div>

        <div class="right_menu">
          <a href="#Info_section">
            <span> O Que Somos? </span>
          </a>
          <a href="#planos_account">
            <span>Nossos Planos</span>
          </a>
          <a href="#form_contact">
            <span> Fale Conosco </span>
          </a>
          <a href="pages/dicas/index.php">
            <span> Dicas </span>
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
              <a class="navbar-brand" href="#">Logo</a>
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
                    <a class="nav-link" href="pages/dicas/index.php">Dicas</a>
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
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos,
            suscipit, laborum dolorem iste iure molestias
          </p>
          <a href="pages/criar conta/index.php">
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
          <h1>Teste</h1>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempora
            non quia, quas doloremque voluptas exercitationem necessitatibus
            tempore, mollitia commodi voluptates obcaecati fugit. Facere eaque
            cum iusto at. Itaque, repudiandae culpa.
          </p>
          <button class="btn_info">Começar</button>
        </div>

        <div class="coluna_02">
          <img src="source/assets/udraw_images/undraw_personal_finance_tqcd.svg" alt="" />
        </div>
      </div>
      <!-------------------------->

      <!-- Cards Container -->
      <div class="cards_price container" id="planos_account">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">Nossos Planos</h1>
            <!-- <p class="fs-5 text-muted">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p> -->
          </div>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Free</h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">
                  $0<small class="text-muted fw-light">/mo</small>
                </h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>10 users included</li>
                  <li>2 GB of storage</li>
                  <li>Email support</li>
                  <li>Help center access</li>
                </ul>
                <button
                  type="button"
                  class="w-100 btn btn-lg btn-outline-primary btn_cards"
                >
                  Sign up for free
                </button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm card_02_container">
              <div class="card-header text-white bg-primary py-3 card_02">
                <h4 class="my-0 fw-normal">Pro</h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">
                  $15<small class="text-muted fw-light">/mo</small>
                </h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>20 users included</li>
                  <li>10 GB of storage</li>
                  <li>Priority email support</li>
                  <li>Help center access</li>
                </ul>
                <button
                  type="button"
                  class="w-100 btn btn-lg btn-primary btn_cards"
                >
                  Get started
                </button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm border-primary">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Enterprise</h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">
                  $29<small class="text-muted fw-light">/mo</small>
                </h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>30 users included</li>
                  <li>15 GB of storage</li>
                  <li>Phone and email support</li>
                  <li>Help center access</li>
                </ul>
                <button
                  type="button"
                  class="w-100 btn btn-lg btn-outline-primary btn_cards"
                >
                  Contact us
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-------------------------->

      <!-- Form De Contato -->
      <div class="form_contact" id="form_contact">
        <section class="page-section" id="contact">
          <div class="container-fluid">
            <h2
              class="
                page-section-heading
                text-center text-uppercase 
                mb-0
              "
            >
              Entre em contato conosco!
            </h2>
            <div class="row">
              <div class="col-lg-8 mx-auto container_contact">
                <form
                  id="contactForm"
                  action="source/email/main.php"
                  method="POST"
                >
                  <div class="control-group">
                    <div
                      class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      "
                    >
                      <label class="p-1">Nome</label>
                      <input
                        class="form-control"
                        id="name"
                        name="nome"
                        type="text"
                        required="required"
                        data-validation-required-message="Por favor insira seu nome."
                      />
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  <div class="control-group">
                    <div
                      class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      "
                    >
                      <label class="p-1">Email</label>
                      <input
                        class="form-control"
                        id="email"
                        type="email"
                        name="email"
                        required="required"
                        data-validation-required-message="Insira seu endereço de email."
                      />
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  <div class="control-group">
                    <div
                      class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      "
                    >
                      <label class="p-1">Telefone</label>
                      <input
                        class="form-control inputnumberphoneformat"
                        id="phone"
                        type="tel"
                        required="required"
                        data-validation-required-message="Insira seu telefone."
                      />
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  <div class="control-group">
                    <div
                      class="
                        form-group
                        floating-label-form-group
                        controls
                        mb-0
                        pb-2
                      "
                    >
                      <label class="p-1">Mensagem</label>
                      <textarea
                        class="form-control message_area"
                        id="message"
                        name="msg"
                        rows="5"
                        required="required"
                        data-validation-required-message="Digite sua mensagem."
                      ></textarea>
                      <p class="help-block text-danger"></p>
                    </div>
                  </div>
                  <br />
                  <div id="sucesso"></div>
                  <div class="form-group d-flex justify-content-center">
                    <button
                      class="btn btn-primary btn-xl btn_submit_form"
                      id="sendMessageButton"
                      type="submit"
                    >
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
            <span>&copy;team - 2021</span>
          </div>
         
      </div>
    </main>
  </body>
</html>

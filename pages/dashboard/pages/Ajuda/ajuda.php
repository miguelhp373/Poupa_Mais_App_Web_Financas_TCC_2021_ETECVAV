<?php
session_start();
require_once('../../source/controller/connection.php');
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!--Icones FontAwesome-->
  <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

  <!--Importante-->
  <link rel="stylesheet" href="root/root.css" />

  <!--Estilos-->
  <link rel="stylesheet" href="styles/main.css" />
  <link rel="stylesheet" href="styles/mobile/main_page/main.css">

  <!-- Mask Input JS -->
  <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>

</head>

<body>




  <main>

    <div class="form_contact" id="form_contact">
      <section class="page-section" id="contact">
        <div class="container-fluid">
          <h2 class="
                page-section-heading
                text-center text-uppercase 
                mb-0
              ">
            Entre em contato conosco por Email
          </h2>
          <div class="row">
            <div class="col-lg-8 mx-auto container_contact">
              <form id="contactForm" action="source/email/main.php" method="POST">
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
                    <label class="p-1">Assunto</label>
                    <input class="form-control" id="assunto" type="assunto" required="required" data-validation-required-message="Informe o assunto" />
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
                    <textarea class="form-control message_area" id="message" name="msg" rows="5" required="required" data-validation-required-message="Digite sua mensagem."></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <br />
                <div id="sucesso"></div>
                <div class="form-group d-flex justify-content-center">
                  <button class="btn btn-primary btn-xl btn_submit_form" id="sendMessageButton" type="submit">
                    Enviar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>

</html>
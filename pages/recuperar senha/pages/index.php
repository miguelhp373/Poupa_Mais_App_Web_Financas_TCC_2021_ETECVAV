<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location: ../index.php');
    $_SESSION['Msg_error'] = 'Você não tem Acesso a Essa Página!';
}

if(!isset($_SESSION['Validation'])||(!isset($_GET['verificationcode']))){
    header('Location: ../index.php');
    $_SESSION['Msg_error'] = 'Você não tem Acesso a Essa Página!';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Código de Recuperação | Poupa+</title>
    <link rel="shortcut icon" href="../../../Favicon.svg" type="image/x-icon">
    <!--Criado em 06/08/2021-->

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <!--Importante-->
    <link rel="stylesheet" href="../../../source/root/root.css" />

    <!--Estilos-->
    <link rel="stylesheet" href="../../../source/styles/main.css" />
    <link rel="stylesheet" href="../../../source/styles/mobile/main_page/main.css">

    <link rel="stylesheet" href="../../../source/styles/login/main.css">
    <link rel="stylesheet" href="../../../source/styles/mobile/login_page/main.css">
    <link rel="stylesheet" href="../../..//source/styles/validacao/main.css">

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
                <a href="../../index.php">
                    <span> Home </span>
                </a>
                <a href="../../index.php#Info_section">
                    <span> O Que Somos? </span>
                </a>
                <a href="../../index.php#planos_account">
                    <span>Nossos Planos</span>
                </a>
                <a href="../../index.php#form_contact">
                    <span> Fale Conosco </span>
                </a>

                <a href="../criar conta/index.php">
                    <span>Criar Conta</span>
                </a>
            </div>
        </div>
    </div>
    <!------------------>

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
                            <a class="nav-link" href="pages/dicas/index.php">Dicas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../criar conta/index.php">Criar Conta</a>
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
               
                    <h1 class="text-center">Código de Recuperação</h1>
                    <?php if (isset($_SESSION['Msg_error'])) { ?>
                        <span class="text-danger p-4"><?php echo $_SESSION['Msg_error']; ?></span>
                    <?php } ?>
                    <form action="Model/main.php" method="POST" class="form_content">
                        <div class="row_fields">
                            <input type="text" class="fields_cod" oninput="validation1(this)" id="cod_01" name="code01" maxlength="1" required>
                            <input type="text" class="fields_cod" oninput="validation2(this)" id="cod_02" name="code02" maxlength="1" required>
                            <input type="text" class="fields_cod" oninput="validation3(this)" id="cod_03" name="code03" maxlength="1" required>
                            <input type="text" class="fields_cod" oninput="validation4(this)" id="cod_04" name="code04" maxlength="1" required>
                        </div>
                        <button type="submit">Enviar</button>
                    </form>
                    <br />
                    <span class="text-center">
                        <strong>
                            Verifique seu email.
                        </strong>
                    </span>
                    <span class="text-center">
                        <strong>
                            Caso o código não esteja na caixa de entrada, verifique no spam.
                        </strong>
                    </span>
                </div>
            </div>
        </div>
    </main>

    <script>
        //validação do campo de código
        function validation1(number){
            var numberValidation = number.value;

            if (isNaN(numberValidation[numberValidation.length - 1])) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if (numberValidation.length > 1) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if(numberValidation.length == 1){
                document.getElementById('cod_02').focus();
            }
        }
        function validation2(number){
            var numberValidation = number.value;

            if (isNaN(numberValidation[numberValidation.length - 1])) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if (numberValidation.length > 1) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            if(numberValidation.length == 1){
                document.getElementById('cod_03').focus();
            }
        }
        function validation3(number){
            var numberValidation = number.value;

            if (isNaN(numberValidation[numberValidation.length - 1])) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if (numberValidation.length > 1) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if(numberValidation.length == 1){
                document.getElementById('cod_04').focus();
            }
        }
        function validation4(number){
            var numberValidation = number.value;

            if (isNaN(numberValidation[numberValidation.length - 1])) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }

            
            if (numberValidation.length > 1) {
            // Proibir caractere que não seja número
            number.value = numberValidation.substring(0, numberValidation.length - 1);
            return;
            }
        }
    </script>
</body>

</html>
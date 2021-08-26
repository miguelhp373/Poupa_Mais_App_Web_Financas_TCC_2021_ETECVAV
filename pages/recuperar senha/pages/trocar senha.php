<?php
session_start();

if (isset($_SESSION['AlterPassWord']) && isset($_SESSION['ValidationCode']) && isset($_GET['validation'])) {
    if ($_SESSION['ValidationCode'] != $_GET['validation']) {
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Senha | Nome do App</title>
    <!--Criado em 06/08/2021-->

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../../source/root/root.css" />

    <!--Estilos-->
    <link rel="stylesheet" href="../../../source/styles/main.css" />
    <link rel="stylesheet" href="../../../source/styles/mobile/main_page/main.css">

    <link rel="stylesheet" href="../../../source/styles/newpassword/main.css">
    <link rel="stylesheet" href="../../../source/styles/mobile/newpassword_page/main.css">
    <link rel="stylesheet" href="../../../source/styles/validacao/main.css">


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
                    <h1>Trocar Senha</h1>
                    <form action="Model/newPassword/main.php" method="POST" class="form_content">
                        <div class="fields">
                            <input type="password" name="newpass_user" id="newpass_user" required placeholder="Nova Senha" />
                            <i class="fas fa-eye-slash" id="togglePassword01"></i>
                        </div>
                        <div class="fields">
                            <input type="password" name="newpass_user_confirm" id="newpass_user_confirm" required placeholder="Confirme Sua Nova Senha" />
                            <i class="fas fa-eye-slash" id="togglePassword02"></i>
                        </div>
                        <button type="submit">Enviar</button>
                    </form>
                    <?php if (isset($_SESSION['Msg_error'])) { ?>
                        <span class="text-danger p-4"><?php echo $_SESSION['Msg_error']; ?></span>
                    <?php } ?>

                </div>
            </div>
        </div>
    </main>
    <script>
        $('#togglePassword01').click(function() {

            if (($('#togglePassword01').attr('class') === 'fas fa-eye-slash') && ($('#newpass_user').attr('type') === 'password')) {
                $('#newpass_user').attr('type', 'text')
                $('#togglePassword01').removeClass('fa-eye-slash')
                $('#togglePassword01').addClass('fa-eye')
            } else {
                $('#newpass_user').attr('type', 'password')
                $('#togglePassword01').removeClass('fa-eye')
                $('#togglePassword01').addClass('fa-eye-slash')

            }

        })

        $('#togglePassword02').click(function() {

            if (($('#togglePassword02').attr('class') === 'fas fa-eye-slash') && ($('#newpass_user_confirm').attr('type') === 'password')) {
                $('#newpass_user_confirm').attr('type', 'text')
                $('#togglePassword02').removeClass('fa-eye-slash')
                $('#togglePassword02').addClass('fa-eye')
            } else {
                $('#newpass_user_confirm').attr('type', 'password')
                $('#togglePassword02').removeClass('fa-eye')
                $('#togglePassword02').addClass('fa-eye-slash')

            }

        })
    </script>
</body>

</html>
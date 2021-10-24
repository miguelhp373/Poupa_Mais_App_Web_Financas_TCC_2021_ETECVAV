<?php

session_start();
require_once('../../../../../../../source/controller/connection.php');

////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../../../../login/index.php');
    }
}

if (isset($_SESSION['ADM_USER'])) {
    if ($_SESSION['ADM_USER'] != 'root_user_acept') {
        header('Location: ../../../../../../../../dashboard/index.php');
        die();
    }
} else {
    header('Location: ../../../../../../../../dashboard/index.php');
    die();
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

$get_Id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

//busca posts

try {

    $searchPost = $connection->prepare("SELECT id, title, description, text, date, creatorpost, origin FROM blog_posts WHERE id = :id AND email = :email");
    $searchPost->bindParam(':id', $get_Id);
    $searchPost->bindParam(':email', $_SESSION['user_email']);
    $searchPost->execute();

    if ($searchPost->rowCount() > 0) {
        $row = $searchPost->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $get_Data) {
            $Title_Post         =   $get_Data['title'];
            $Description_Post   =   $get_Data['description'];
            $Text_Post          =   $get_Data['text'];
            $Origin_Post        =   $get_Data['origin'];
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
    <title>Editar Meu Post</title>
    <link rel="stylesheet" href="../../../../../../../source/root/root.css">
    <link rel="stylesheet" href="../../../../../../../source/styles/components/button-back/main.css">

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--Bootstrap v5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!--Icones FontAwesome-->
    <script src="https://kit.fontawesome.com/bb41ae50aa.js" crossorigin="anonymous"></script>
</head>
<style>
    body {
        background-color: var(--input-background);
    }

    .container {
        width: 100%;
        height: 100vh;

        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;

        background-color: var(--input-background);

        margin-top: 100px;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        height: 100%;
        width: 100%;
    }

    .container-new-post {
        width: 800px;
        height: 800px;
        background-color: #FFFF;
        border-radius: 12px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    .title-container {
        margin: 25px;
    }

    .col-fields>form {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .col-fields>form>input,
    textarea,
    button {
        margin: 20px;
    }

    .col-fields>form>input,
    textarea {
        margin: 20px;
        width: 700px;

        border: none;
        border-radius: 12px;
        background-color: var(--input-background);
        padding: 8px;
    }

    .col-fields>form>textarea {
        max-width: 700px;
        min-width: 700px;
        max-height: 256px;
        min-height: 256px;
    }

    .col-fields>form>button {
        width: 50%;
        height: 60px;
        background-color: var(--primary-color);
        color: var(--text-primary);
        border: none;
        border-radius: 12px;


    }
</style>

<body>
<?php if(isset($row)){?>
    <div class="container">
        <div class="content">
            <div class="btn_back_home">
                <a href="../index.php" title="Voltar Para Tela Inicial">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="container-new-post">
                <h1 class="title-container">Editar Meu Post</h1>
                <div class="col-fields">
                    <form action="models/main.php?id=<?php echo $get_Id;?>" method="post">
                        <input type="text" name="title" placeholder="Titulo" required autocomplete="off" value="<?php echo  $Title_Post; ?>">
                        <input type="text" name="resumo" placeholder="Resumo" required autocomplete="off" value="<?php echo  $Description_Post; ?>">
                        <input type="text" name="link" placeholder="Link De Origem (Se Houver)" autocomplete="off" value="<?php echo  $Origin_Post; ?>">
                        <textarea name="text" id="" cols="30" rows="10" placeholder="Texto" required autocomplete="off" ><?php echo  $Text_Post; ?></textarea>
                        <button type="submit">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        

<?php } else{
    header('Location: ../index.php');
    }
?>
<br><br>
</body>

</html>
<?php
require_once('../../../source/controller/connection.php');


$get_Id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

//busca posts

try {

    $searchPost = $connection->prepare("SELECT id, title, description, text, date, creatorpost, origin, views FROM blog_posts WHERE id = :id");
    $searchPost->bindParam(':id', $get_Id);
    $searchPost->execute();

    if ($searchPost->rowCount() > 0) {
        $row = $searchPost->fetchAll(PDO::FETCH_ASSOC);
        foreach($row as $postView){
            $getView    =   $postView['views'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}


//adiciona visualizações ao post

if(isset($getView)){
    try{
        $setNewValue = $getView;
        if($getView == 0){
            $setNewValue = 1;
        }
    
        $setNewValue += 1;
    
        $AddViewOnPost = $connection->prepare("UPDATE blog_posts SET views = :Newview WHERE id = :id");
        $AddViewOnPost->bindParam(':id', $get_Id);
        $AddViewOnPost->bindParam(':Newview',$setNewValue);
        $AddViewOnPost->execute();
    
    } catch(PDOException $error){
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog | <?php foreach ($row as $get_Data) {echo $get_Data['title']; }?></title>

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
    <link rel="stylesheet" href="../../../source/styles/blog_page/main.css" />
    <link rel="stylesheet" href="../../../source/styles/mobile/blog_page/main.css">
    <link rel="stylesheet" href="../../../source/styles/components/button-back/main.css">

    <!-- Mask Input JS -->
    <script src="https://cdn.jsdelivr.net/gh/miguelhp373/MaskInputJS/maskjs@1.3/maskjs.min.js"></script>

</head>
<style>
    .left_logo>a>h1>sup {
        font-size: 18px;
    }

    .navbar-brand>sup {
        font-size: 18px;
    }
</style>

<body>
    <!--NavBar Desktop-->
    <div class="nav_bar_top">
        <div class="row_nav_bar">
            <div class="left_logo">
                <a href="../index.php">
                    <h1>Poupa+
                        <sup>Blog</sup>
                    </h1>
                </a>
            </div>
        </div>
    </div>
    <!------------------>

    <!--NavBar Mobile-->
    <div class="nav_bar_top_mobile">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mobile">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">
                    Poupa+
                    <sup>Blog</sup>
                </a>
            </div>
        </nav>

    </div>
    <!------------------>

    <div class="container-content-post">
        <div class="content-post">
        <div class="btn_back_home">
                <a href="../index.php" title="Voltar Para Tela Inicial">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <?php
            if (isset($row)) {
                if ($row != null) {
                    foreach ($row as $get_Data) {
            ?>
                        <div class="title-post-view">
                            <h1><?php echo $get_Data['title']; ?></h1>
                        </div>
                        <div class="date_post">
                            <span><i class="fas fa-eye"></i> &nbsp; <?php echo $get_Data['views']; ?> &nbsp; | &nbsp; Enviado Por
                                <strong>
                                    <?php echo $get_Data['creatorpost']; ?>
                                </strong>
                                &nbsp; - &nbsp; 
                                <span class="date-send">
                                <?php echo date('d/m/y', strtotime($get_Data['date'])); ?>
                                </span>
                            </span>
                            <hr>                
                        </div>

                        <div class="intro-description">
                            <h2>Introdução</h2>
                            <p>
                                <?php echo $get_Data['description']; ?>
                            </p>
                        </div>

                        <br>
                        <br>
                        <div class="text-notice">
                            <p>
                                <?php echo nl2br($get_Data['text']); ?>
                            </p>
                        </div>
                        <?php if($get_Data['origin'] !== ''){?>
                        <div class="autor">
                            <span>Adaptado de
                                <a href="<?php echo $get_Data['origin']; ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo $get_Data['origin']; ?>
                                </a>
                            </span>
                            <br><br>
                        </div>
                        <?php }?>
            <?php }
                }
            } else {
                echo "<h1 >Post Não Encontrado</h1>";
            } ?>
        </div>
    </div>
</body>

</html>
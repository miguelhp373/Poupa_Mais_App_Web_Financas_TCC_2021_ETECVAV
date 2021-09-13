<?php
require_once('../../source/controller/connection.php');


//busca posts

try {

  $searchPosts = $connection->prepare("SELECT id, title, description, text, date, creatorpost, origin FROM blog_posts ORDER BY date DESC");

  $searchPosts->execute();

  if ($searchPosts->rowCount() > 0) {
    $row = $searchPosts->fetchAll(PDO::FETCH_ASSOC);
  }
} catch (PDOException $error) {
  die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dicas | Nome Do App</title>

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
  <link rel="stylesheet" href="../../source/styles/blog_page/main.css" />
  <link rel="stylesheet" href="../../source/styles/mobile/blog_page/main.css">

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
        <a href="../../index.php">
          <h1>LOGO
            <sup>Blog</sup>
          </h1>
        </a>
      </div>
      <div class="right_menu">
        <div class="search-field">
          <input type="search" placeholder="Procurar">
        </div>
      </div>
    </div>
  </div>
  <!------------------>



  <!--NavBar Mobile-->
  <div class="nav_bar_top_mobile">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mobile">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php">
          Logo
          <sup>Blog</sup>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars btn_menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">

          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

  </div>
  <!------------------>

  <div class="container-content">
    <div class="content">
      <?php
      foreach ($row as $getdata) { ?>
        <a href="view/post.php?id=<?php echo $getdata['id']; ?>">
          <div class="card-poster">
            <div class="title-post">
              <h1><?php echo $getdata['title']; ?></h1>
            </div>
            <div class="post_content">
              <p><?php echo  substr($getdata['description'],0,200); ?>...</p>
             
              <strong>
              <span class="read_more">Continue Lendo</span>
              </strong>
             
            </div>
            
          </div>
        </a>
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>
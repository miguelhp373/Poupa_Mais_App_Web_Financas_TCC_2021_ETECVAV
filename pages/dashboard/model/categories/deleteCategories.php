<?php 
    session_start();
    require_once('../../../../source/controller/connection.php');
    
    if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
        if ($_SESSION['Authentication'] == '') {
            $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
            header('Location: ../../login/index.php');
            die();
        }
    }

    $CategorieGet                   =   filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
    $_SESSION['MsgCategorieError']  =   '';

    try {

        $searchCat = $connection->prepare("SELECT categorias FROM userstableapplication WHERE email = :email LIMIT 1");
        $searchCat->bindParam(':email', $_SESSION['user_email']);
      
        $searchCat->execute();
      
        if ($searchCat->rowCount() > 0) {
      
          $rowCategorias = $searchCat->fetchAll(PDO::FETCH_ASSOC);
      
          foreach ($rowCategorias as $getCategorias) {
            $user_categories = $getCategorias['categorias'];
            $decode_Json  = json_decode($user_categories, true);
          }
        }
      } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
      }

      switch ($CategorieGet) {
        case 0:
            $_SESSION['MsgCategorieError']  = 'Você Não Pode Apagar Essa Categoria.';   
            header('Location: ../../index.php');
            die();
            break;
        case 1:
            $_SESSION['MsgCategorieError']  = 'Você Não Pode Apagar Essa Categoria.';   
            header('Location: ../../index.php');
            die();
            break;
        case 2:
            $_SESSION['MsgCategorieError']  = 'Você Não Pode Apagar Essa Categoria.';   
            header('Location: ../../index.php');
            die();
            break;
        case 3:
            $_SESSION['MsgCategorieError']  = 'Você Não Pode Apagar Essa Categoria.';   
            header('Location: ../../index.php');
            die();
        break;
    }



        foreach ($decode_Json as $showCategorias) { 

            if($showCategorias['id'] == $CategorieGet){
                $deleteCategories = true;
            }

        }


        if($deleteCategories == true){
            unset($decode_Json[$CategorieGet]);
        }
        else{
            $_SESSION['MsgCategorieError']  = 'Você Não Pode Apagar Essa Categoria.';   
            header('Location: ../../index.php');
            die();
        }


         
                try {

                    $UpdateJsonCategories = $connection->prepare("UPDATE userstableapplication SET categorias = :jsonnew  WHERE email = :email LIMIT 1");
                    $UpdateJsonCategories->bindParam(':jsonnew',json_encode($decode_Json));
                    $UpdateJsonCategories->bindParam(':email', $_SESSION['user_email']);
                  
                    $UpdateJsonCategories->execute();
                  
                    if ($UpdateJsonCategories->rowCount() > 0) {
                        $_SESSION['MsgCategorieError']  = '';
                        header('Location: ../../index.php');
                        die();
                    }else{
                        $_SESSION['MsgCategorieError']  = 'Erro, Ao Tentar Apagar a Categoria.';   
                        header('Location: ../../index.php');
                        die();  
                    }
                } catch (PDOException $error) {
                    header('location: ../../../Page404/index.php');
                    die;
                }
        

?>
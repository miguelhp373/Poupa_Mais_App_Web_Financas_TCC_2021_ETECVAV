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

    $_SESSION['MsgCategorieError']  =   '';
    $descriptionNewCategories        =   filter_input(INPUT_POST,'newCategorie',FILTER_SANITIZE_STRING);

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
        
        header('location: ../../../Page404/index.php');
        die;
      }
        $PushArrayNewItem   = $decode_Json; //armazena a array antes de alterar

        end($decode_Json); //pega o ultimo item do array
        $getFinalKey    =   key($decode_Json);//pega o ultimo id
        $PushArrayNewItem[]   =   ["id"=>$getFinalKey + 1,"description"=>$descriptionNewCategories];//inclui o novo item

        $SetJsonUpdate = json_encode($PushArrayNewItem);
     
                try {

                    $UpdateJsonCategories = $connection->prepare("UPDATE userstableapplication SET categorias = :jsonnew  WHERE email = :email LIMIT 1");
                    $UpdateJsonCategories->bindParam(':jsonnew', $SetJsonUpdate);
                    $UpdateJsonCategories->bindParam(':email', $_SESSION['user_email']);
                  
                    $UpdateJsonCategories->execute();
                  
                    if ($UpdateJsonCategories->rowCount() > 0) {
                        $_SESSION['MsgCategorieError']  = '';
                        header('Location: ../../index.php');
                        die();
                    }else{
                        $_SESSION['MsgCategorieError']  = 'Erro, Ao Tentar Adicionar a Categoria.';   
                        header('Location: ../../index.php');
                        die();  
                    }
                } catch (PDOException $error) {
                  header('location: ../../../Page404/index.php');
                  die;
                }
        

?>
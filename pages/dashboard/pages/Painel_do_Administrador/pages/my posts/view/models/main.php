<?php 
session_start();
require_once('../../../../../../../source/controller/connection.php');

////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../../../login/index.php');
    }
}


    $title_post         =   filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
    $description_post   =   filter_input(INPUT_POST,'resumo',FILTER_SANITIZE_STRING);
    $link_post          =   filter_input(INPUT_POST,'link',FILTER_SANITIZE_URL);
    $text_post          =   filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);
    $getID              =   filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);

    try {

        $searchinfos = $connection->prepare("SELECT nome FROM userstableapplication WHERE email = :email LIMIT 1");
        $searchinfos->bindParam(':email', $_SESSION['user_email']);
    
        $searchinfos->execute();
    
        if ($searchinfos->rowCount() > 0) {
    
            $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($row as $getdata) {
                $user_name      =   $getdata['nome'];        
            }
        }
    } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }


    try {

        $EditPost = $connection->prepare("UPDATE blog_posts SET title =   :title, description =   :description, text = :text,  origin  = :link WHERE   email  = :emailUser AND id = :id");
        $EditPost->bindParam(':title', $title_post);
        $EditPost->bindParam(':description', $description_post);
        $EditPost->bindParam(':link', $link_post);
        $EditPost->bindParam(':text', $text_post);
        $EditPost->bindParam(':emailUser',$_SESSION['user_email']);
        $EditPost->bindParam(':id',$getID);
        
    
        $EditPost->execute();
    
        if ($EditPost->rowCount() > 0) {
            header('Location: ../EditPost.php');
        }else{
            echo 'Erro 404';
            die();
        }
    } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }

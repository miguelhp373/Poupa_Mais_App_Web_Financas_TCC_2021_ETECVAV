<?php 

session_start();
require_once('../../../../../../source/controller/connection.php');

////////////
//VALIDA USUÁRIO
if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../../../login/index.php');
    }
}


    $title_post     =       filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
    $description_post     =       filter_input(INPUT_POST,'resumo',FILTER_SANITIZE_STRING);
    $link_post     =       filter_input(INPUT_POST,'link',FILTER_SANITIZE_URL);
    $text_post     =       filter_input(INPUT_POST,'text',FILTER_SANITIZE_STRING);

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

        $createPost = $connection->prepare(
            "INSERT INTO blog_posts
            (
                title, 
                description, 
                text, 
                date, 
                creatorpost, 
                origin,
                email
            )
            VALUES
            (
                :title, 
                :description, 
                :text, 
                NOW(), 
                :creatorpost, 
                :link,
                :emailUser
            )"
        );
        $createPost->bindParam(':title', $title_post);
        $createPost->bindParam(':description', $description_post);
        $createPost->bindParam(':link', $link_post);
        $createPost->bindParam(':text', $text_post);
        $createPost->bindParam(':creatorpost', $user_name);
        $createPost->bindParam(':emailUser',$_SESSION['user_email']);
        
    
        $createPost->execute();
    
        if ($createPost->rowCount() > 0) {
            header('Location: ../../../index.php');
        }else{
            echo 'nao';
        }
    } catch (PDOException $error) {
        die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
    }

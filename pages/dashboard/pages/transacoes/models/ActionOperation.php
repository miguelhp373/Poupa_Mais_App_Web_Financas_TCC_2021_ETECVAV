<?php

require_once('../../../../../source/controller/connection.php');
session_start();

if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ((empty($_SESSION['Authentication']))||(empty($_SESSION['user_email']))) {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../../../login/index.php');
        

    }
}

$getUrlParam         =   filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
$getUrlParamValue    =   filter_input(INPUT_GET,'EditValue',FILTER_SANITIZE_STRING);

$DecriptoParam =   base64_decode($getUrlParam);



try {

    $searchinfos = $connection->prepare("SELECT cod, nome, email, telefone, image_user FROM userstableapplication WHERE email = :email LIMIT 1");
    $searchinfos->bindParam(':email', $_SESSION['user_email']);

    $searchinfos->execute();

    if ($searchinfos->rowCount() > 0) {

        $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $getdata) {
            $user_cod       =   $getdata['cod'];
            $user_name      =   $getdata['nome'];
            $user_email     =   $getdata['email'];
            //$user_cpf       =   $getdata['cpf'];
            $user_telefone  =   $getdata['telefone'];
            $image_user     =   $getdata['image_user'];
        }
    }
} catch (PDOException $error) {
    die('Erro Ao Tentar Se Comunicar com o Servidor, Tente Novamente Mais Tarde.');
}


/////////////////////////////////////////////////////////////////
//PESQUISA SALDO
$searchinfos = $connection->prepare("SELECT cod, saldo FROM userstableapplication WHERE email = :email LIMIT 1");
$searchinfos->bindParam(':email', $_SESSION['user_email']);

$searchinfos->execute();

if ($searchinfos->rowCount() > 0) {

    $row = $searchinfos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getdata) {
        $user_cod      =   $getdata['cod'];
        $user_Saldo      =   $getdata['saldo'];
    }
}
//////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////
//PESQUISA Valor
$searchValor = $connection->prepare("SELECT tipo, valor FROM operationsapplication WHERE idUser = :cod AND cod = :chave LIMIT 1");
$searchValor->bindParam(':cod', $user_cod);
$searchValor->bindParam(':chave',$DecriptoParam);

$searchValor->execute();

if ($searchValor->rowCount() > 0) {

    $row = $searchValor->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $getValor) {
        $Operation_Value      =   $getValor['valor'];
        $Operation_Type      =   $getValor['tipo'];
    }
}
//////////////////////////////////////////////////////////////







function DeleteOperation($cod,$connection,$user,$Operation_Value,$user_Saldo,$Operation_Type){

    $getValor       = str_replace (',', '.', str_replace ('.', '', $Operation_Value));

    if(is_int($Operation_Value)){
        $getValor  = $Operation_Value; 
    }


    if($Operation_Type == 'receita'){
        $newSaldo = $user_Saldo - $getValor;
    }else{
        $newSaldo = $user_Saldo + $getValor;
    }


    

    $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
    $UpdateSaldo->bindParam(':id', $user);
    $UpdateSaldo->bindParam(':saldo', $newSaldo);

    $UpdateSaldo->execute();


    if ($UpdateSaldo->rowCount() > 0) {

        $DeleteOperation = $connection->prepare("DELETE FROM operationsapplication WHERE idUser = :id AND cod = :cod LIMIT 1");
        $DeleteOperation->bindParam(':id',$user) ;
        $DeleteOperation->bindParam(':cod',$cod) ;
         
        $DeleteOperation->execute();
         
        if ($DeleteOperation->rowCount() > 0) {
            header('Location: ../../Transacoes/index.php');
        }
        
    }


}

function EditOperation($connection,$user,$setCod,$setData,$setCategoria,$setDescricao,$setValor,$user_Saldo,$before_Value){

    $getValor            = str_replace (',', '.', str_replace ('.', '', $setValor));
    $getValor_Before     = str_replace (',', '.', str_replace ('', '.', $before_Value));
    
    $UpdateOperation = $connection->prepare("UPDATE operationsapplication SET data = :data, categoria = :categoria, descricao = :descricao, valor = :valor  WHERE idUser = :id AND cod = :cod LIMIT 1");
    $UpdateOperation->bindParam(':id',$user) ;
    $UpdateOperation->bindParam(':cod',$setCod) ;
    $UpdateOperation->bindParam(':data',$setData) ;
    $UpdateOperation->bindParam(':categoria',$setCategoria) ;
    $UpdateOperation->bindParam(':descricao',$setDescricao) ;
    $UpdateOperation->bindParam(':valor',$getValor) ;
     
    $UpdateOperation->execute();   
    
    if ($UpdateOperation->rowCount() > 0) {
        if($getValor_Before == $getValor ){
            header('Location: ../../Transacoes/index.php');
        }else{

            $newSaldo   = ($user_Saldo - $before_Value) + $getValor;
    
            $UpdateSaldo = $connection->prepare("UPDATE userstableapplication SET saldo = :saldo  WHERE cod = :id LIMIT 1");
            $UpdateSaldo->bindParam(':id', $user);
            $UpdateSaldo->bindParam(':saldo', $newSaldo);
        
            $UpdateSaldo->execute();
    
            if ($UpdateSaldo->rowCount() > 0) {
                header('Location: ../../Transacoes/index.php');
            }else{
                $_SESSION['WRONG_OPERATION'] = 'true';
                header('Location: ../../Transacoes/index.php');
            }
        }
    }else{
        $_SESSION['WRONG_OPERATION'] = 'true';
        header('Location: ../../Transacoes/index.php');
    }    

   

}

    //verifica se o parametro é numerico, pois está sendo criptografado em base64
    if(is_numeric($getUrlParam)){
        header('Location: ../../../index.php');
        die();
    }

 
    

    if($_GET['operation'] == 'delete'){
        DeleteOperation($DecriptoParam,$connection,$user_cod,$Operation_Value,$user_Saldo,$Operation_Type);
    }
    if($_GET['operation'] == 'edit'){

        $getCurrency    =   filter_input(INPUT_POST,'currency',FILTER_SANITIZE_STRING);
        $getDate        =   filter_input(INPUT_POST,'date',FILTER_SANITIZE_STRING);
        $getDescription =   filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
        $getCategoria   =   filter_input(INPUT_POST,'categorias',FILTER_SANITIZE_STRING);

        EditOperation($connection,$user_cod,$DecriptoParam,$getDate,$getCategoria,$getDescription,$getCurrency,$user_Saldo,$Operation_Value);
    }

?>
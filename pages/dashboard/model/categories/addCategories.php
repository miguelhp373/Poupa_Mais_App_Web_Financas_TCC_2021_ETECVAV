<?php
session_start();
require_once('../../../source/controller/connection.php');


if (!isset($_SESSION['user_email']) || (!isset($_SESSION['Authentication']))) {
    if ($_SESSION['Authentication'] == '') {
        $_SESSION['Msg_error'] = 'Usuário Não Permitido!';
        header('Location: ../../login/index.php');
    }
}


//manipularei o json vindo do banco e adicionarei mais dados
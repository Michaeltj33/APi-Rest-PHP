<?php
session_start();
include_once 'logServ.php';
$senha = $_POST['senha'];

$vSenha = new connect();
if($vSenha->verSenha($senha) == true){
    $_SESSION['senha'] = true;
    header("Location:index.php");
}else{
    header("Location:login.php");
}




?>
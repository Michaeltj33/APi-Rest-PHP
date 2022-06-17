<?php
 class connect {
    function conectar(){
        $servidor = "INFORME O SERVIDOR:3306";
        $usuario = "admin";
        $senha = "";
        $bancodedados = "bd";

        $conn = new mysqli($servidor, $usuario, $senha, $bancodedados);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }
        return $conn;
    } 
    function inserirLog($inputLog, $recebidas,$LeadInputLog,$leadRecebidas,$buscaLead) {
        $conn = $this -> conectar();
        $data = $this -> pegarData();
        $hora = $this -> pegarHora();
        $sql = "INSERT into logLead (data,hora,inputLog,recebidas,LeadInputLog,leadRecebidas,buscaLead) VALUES ('$data','$hora','$inputLog', '$recebidas','$LeadInputLog','$leadRecebidas','$buscaLead')";
        $conn->query($sql);
    }

    function mostrarLog(){
        $conn = $this -> conectar();
        $sql = "SELECT * from logLead";
        return $conn->query($sql);         
    }

    function totalLeads(){        
        $conn = $this -> conectar();
        $sql = "SELECT count(*) as resultado from logLead;";
        $resultado = $conn->query($sql);
        foreach($resultado as $res){
           $pg = $res['resultado'];
        }
        return $pg;  
    }

    function verSenha($senha){
        $ver = false;
        $conn = $this -> conectar();
        $sql = "SELECT * from loginSenha";
        $resposta = $conn->query($sql);
        foreach($resposta as $res){
            if($res['senha'] == $senha){
                $ver = true;
            }
        }
        return $ver;
    }

    function pegarData()
    {
        date_default_timezone_set('America/Sao_Paulo');
        return date('d-m-Y');
    }

    function pegarHora()
    {
        date_default_timezone_set('America/Sao_Paulo');
        return date('H:i:s');
    }

}

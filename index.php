<!DOCTYPE html>
<html lang="pt-br">
<?php include_once "logServ.php"; ?>

<head>
    <meta charset="utf-8">
    <title>Analisando Log</title>
    <style>
        h1 {
            color: #393287;
            text-align: center;
        }

        p {
            color: #393287;
            text-align: center;
            font-size: 180%;

        }

        b {
            color: #393287;
        }
    </style>

</head>

<body>
    <h1>Leads que vem pelo Facebook</h1>

    <?php
    session_start();
    if (($_SESSION['senha']) == false) {
        header("Location:login.php");
        exit();
    } else {

        $pegaLog = new connect();
        echo "<p><b>" . "Total de Leads: " . ($pegaLog->totalLeads()) . "<hr>" . "</b></p>";
        $capturaLead = $pegaLog->mostrarLog();

        $arr = array();

        foreach ($capturaLead as $cl) {
            $arr[] = ($cl);
        }

        rsort($arr);
        foreach ($arr as $ar) {
            echo "<pre><b>";
            print_r($ar);
            echo "</b><hr>";
        } 
    }//Finaliza a Section
    ?>

</body>

</html>
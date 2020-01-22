<?php
    date_default_timezone_set('America/Araguaina');
    include_once("../conection/connection.php");
    $pdo=conectar();

    $updateAprovado=$pdo->prepare("UPDATE agendamentos SET id_status_auditoria=2 WHERE date(data_cadastro_agendamento) = date(NOW()) - 1");
    $updateAprovado->execute();
    
?>
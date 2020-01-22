<?php

	include_once("../conection/connection.php");
	$pdo=conectar();
	$updateAgendamento=$pdo->prepare("UPDATE agendamentos SET id_comparecimento=:comparecimento WHERE id_agendamentos=:idAgendamento");
	$updateAgendamento->bindValue(":comparecimento", 1);
	$updateAgendamento->bindValue(":idAgendamento", $_GET['ID']);
	$updateAgendamento->execute();
	header("Location: ".$_SERVER['HTTP_REFERER']."");


?>
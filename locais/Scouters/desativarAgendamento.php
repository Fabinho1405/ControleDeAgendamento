<?php 
	include_once("../../conection/connection.php");
	$pdo=conectar();

	$idAgendamento=$_GET['ag'];


	$updateAg=$pdo->prepare("UPDATE agendamentos SET id_status_sistema=0 WHERE id_agendamentos=:idAg");
	$updateAg->bindValue(":idAg", $idAgendamento);
	$updateAg->execute();
	header("Location: ".$_SERVER['HTTP_REFERER']."");



?>
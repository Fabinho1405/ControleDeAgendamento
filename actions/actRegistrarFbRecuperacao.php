<?php
	session_start();
	ob_start();

	$idFuncionario = $_SESSION['id_usuario'];
	$unidadeFunc = $_SESSION['unidade'];

	include_once("../conection/connection.php");
	$pdo=conectar();

	//GET
	$idAgendamento=$_GET['idAgendamento'];
	$idCliente=$_GET['idCliente'];

	//POST
	$status=$_POST['fbAgendamento'];

	//Verifica qual status foi Selecionado
	if($status == 3 || $status == 4 || $status == 6 || $status == 8){
		//NAO CONSEGUIU CONTATO
		//Aumenta um feedback no agendamento e registra o log do status
		$pegarNumeroFB=$pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamentos=:idAgendamento");
		$pegarNumeroFB->bindValue(":idAgendamento", $idAgendamento, PDO::PARAM_INT);
		$pegarNumeroFB->execute();

		$linhaNumeroFB=$pegarNumeroFB->fetch(PDO::FETCH_OBJ);
		$numeroFB = $linhaNumeroFB->qtd_fb_recuperacao;
		$novoNumeroFB = $numeroFB + 1;

		$updateNumeroFB=$pdo->prepare("UPDATE agendamentos SET qtd_fb_recuperacao=:novoNumero WHERE id_agendamentos=:idAgendamento");
		$updateNumeroFB->bindValue(":novoNumero", $novoNumeroFB);
		$updateNumeroFB->bindValue(":idAgendamento", $idAgendamento);
		$updateNumeroFB->execute();

		$registraLog=$pdo->prepare("INSERT INTO  log_fedback_recuperacao VALUES (NULL, :funcionario, :nFedback , :idUnidade, NOW() , :idAgendamento, :status)");
		$registraLog->bindValue(":funcionario", $idFuncionario);
		$registraLog->bindValue(":nFedback", $novoNumeroFB);
		$registraLog->bindValue(":idUnidade", $unidadeFunc);
		$registraLog->bindValue(":idAgendamento", $idAgendamento);
		$registraLog->bindValue(":status", $status);
		$registraLog->execute();

		header("Location: ../listaRecuperacaoAgendamento.php");

	}elseif($status == 7){
		//CLIENTE PERDEU O INTERESSE
		header("Location: ../semInteresseRecuperacao.php?ag=$idAgendamento&cli=$idCliente");	
	}elseif($status == 9){
		//CLIENTE REAGENDOU
		header("Location: ../reagendarRecuperacao.php?ag=$idAgendamento&cli=$idCliente&rec=1");
	}





?>
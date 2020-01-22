<?php

    session_start();
    ob_start();

	$idFuncionario = $_SESSION['id_usuario'];
	$unidadeFunc = $_SESSION['unidade'];

	include_once("../conection/connection.php");
	$pdo=conectar();

	//GET
	$idAgendamento=$_GET['ag'];

	//POST
	$motivoSInteresse=$_POST['motivo'];

	 //Verifica se o agendamento está na posse do scouter ainda
    $autenticaAgendamento=$pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamentos=:idAgend");
    $autenticaAgendamento->bindValue(":idAgend", $idAgendamento);
    $autenticaAgendamento->execute();
    $linhaAutentica=$autenticaAgendamento->fetch(PDO::FETCH_OBJ); 

    if($linhaAutentica->func_recuperacao == $idFuncionario){
    	//Desativa Agendamento Anterior
    	$desativaAgendamento=$pdo->prepare("UPDATE agendamentos SET id_status_sistema='0' WHERE id_agendamentos=:idAgendamento");
    	$desativaAgendamento->bindValue(":idAgendamento", $idAgendamento);
    	$desativaAgendamento->execute();

        //Aumenta um feedback no agendamento e registra o log do status
        $pegarNumeroFB=$pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamentos=:idAgendamento");
        $pegarNumeroFB->bindValue(":idAgendamento", $idAgendamento, PDO::PARAM_INT);
        $pegarNumeroFB->execute();

        $linhaNumeroFB=$pegarNumeroFB->fetch(PDO::FETCH_OBJ);
        $numeroFB = $linhaNumeroFB->qtd_fb_recuperacao;
        $novoNumeroFB = $numeroFB + 1;
        $idCliente=$linhaNumeroFB->id_cliente;


        $updateNumeroFB=$pdo->prepare("UPDATE agendamentos SET qtd_fb_recuperacao=:novoNumero WHERE id_agendamentos=:idAgendamento");
        $updateNumeroFB->bindValue(":novoNumero", $novoNumeroFB);
        $updateNumeroFB->bindValue(":idAgendamento", $idAgendamento);
        $updateNumeroFB->execute();

        $registraLog=$pdo->prepare("INSERT INTO  log_fedback_recuperacao VALUES (NULL, :funcionario, :nFedback , :idUnidade, NOW() , :idAgendamento, :status)");
        $registraLog->bindValue(":funcionario", $idFuncionario);
        $registraLog->bindValue(":nFedback", $novoNumeroFB);
        $registraLog->bindValue(":idUnidade", $unidadeFunc);
        $registraLog->bindValue(":idAgendamento", $idAgendamento);
        $registraLog->bindValue(":status", 7);
        $registraLog->execute();        

    	$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Cliente Desinteressado Realizado com Sucesso! 
                             </div>";
        header("Location: ../semInteresseRecuperacao.php");
    }else{
    	$_SESSION['msgcad'] = "<div class='alert alert-waring' role='alert'>
                                           Este agendamento não esta mais sobre sua posse. Converse com seu supervisor. 
                             </div>";
    	header("Location: ../semInteresseRecuperacao.php");
    }







?>
<?php
    session_start();
    ob_start();
	include_once("../conection/connection.php");
    $pdo=conectar(); 

    if($_GET['conf'] == 1){
        $idFuncionarioAg= $_GET['funcAg'];
        $idFuncionario= $_SESSION['id_usuario'];
        $meioCaptado=$_GET['meioCap'];
    }else{
        $idFuncionario = $_SESSION['id_usuario'];
    }
    $unidadeFunc = $_SESSION['unidade'];

    //GET'S
    $idAgendamento=$_GET['ag'];
    $idCliente=$_GET['cli'];

    //POST'S
    $dataReagendado=$_POST['dataAgendado']; 
    $horaReagendado=$_POST['horaAgendado'];


    //Verifica se o agendamento está na posse do scouter ainda
    $autenticaAgendamento=$pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamentos=:idAgend");
    $autenticaAgendamento->bindValue(":idAgend", $idAgendamento);
    $autenticaAgendamento->execute();
    $linhaAutentica=$autenticaAgendamento->fetch(PDO::FETCH_OBJ); 

    if($linhaAutentica->id_func == $idFuncionario || $_GET['conf'] == 1){
    	//Desativa Agendamento Anterior
    	$desativaAgendamento=$pdo->prepare("UPDATE agendamentos SET id_status_sistema='0' WHERE id_agendamentos=:idAgendamento");
    	$desativaAgendamento->bindValue(":idAgendamento", $idAgendamento);
    	$desativaAgendamento->execute(); 

    	//Insere o Agendamento
        if($_GET['conf'] == 1){
             $insereAgendamento=$pdo->prepare("INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_cliente, id_status_sistema, id_func, id_comparecimento,id_unidade, reagendado, reagendadoConfirmacao, id_meio_captado, id_func_conf) VALUES (:dataAgendado,:horaAgendado,NOW(),:idCliente,1,:idFuncionario,3,:idUnidade, 1, 1, :meioCaptado, :funConf)");
        }else{
    	   $insereAgendamento=$pdo->prepare("INSERT INTO agendamentos (data_agendada_agendamento, hora_agendada_agendamento, data_cadastro_agendamento, id_cliente, id_status_sistema, id_func, id_comparecimento,id_unidade, reagendado, reagendadoConfirmacao, id_meio_captado) VALUES (:dataAgendado,:horaAgendado,NOW(),:idCliente,1,:idFuncionario,3,:idUnidade, 1, 1, 3)");
        };

    	$insereAgendamento->bindValue(":dataAgendado", $dataReagendado);
    	$insereAgendamento->bindValue(":horaAgendado", $horaReagendado);
    	$insereAgendamento->bindValue(":idCliente", $idCliente);
        if($_GET['conf'] == 1){
            $insereAgendamento->bindValue(":idFuncionario", $idFuncionarioAg); 
            $insereAgendamento->bindValue(":meioCaptado", $meioCaptado);
            $insereAgendamento->bindValue(":funConf", $idFuncionario);   
        }else{
            $insereAgendamento->bindValue(":idFuncionario", $idFuncionario);    
        };    	
    	$insereAgendamento->bindValue(":idUnidade", $unidadeFunc);
    	$insereAgendamento->execute();

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
        $registraLog->bindValue(":status", 9);
        $registraLog->execute();        

    	$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Reagendamento Realizado com Sucesso! 
                             </div>";
        header("Location: ../reagendarConfirmacao.php");
    }else{
    	$_SESSION['msgcad'] = "<div class='alert alert-waring' role='alert'>
                                           Este agendamento não esta mais sobre sua posse. Converse com seu supervisor. 
                             </div>";
    	header("Location: ../reagendarConfirmacao.php");
    }



?>
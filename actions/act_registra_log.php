<?php
	session_start();
    ob_start();
	include_once("../conection/conexao.php");
	$acao = $_GET['acao'];
	$idagendamento = $_GET['idagdm'];

	if($acao == 1){
		//Registra log de inicio de auditoria e encaminha para detalhes do agendamento.
		//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'iniciou auditoria do agendamento->$idagendamento', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
             header("Location:../detalhes_auditar_agendamento.php?idagdm=$idagendamento");
         //FIM LOG
	}else if($acao == 2){
		//Registra log de inicio de re-análise da  auditoria e encaminha para detalhes do agendamento.
		//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'iniciou a re-analise do agendamento->$idagendamento', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
             header("Location:../detalhes_re_auditar_agendamento.php?idagdm=$idagendamento");
         //FIM LOG
	}



?>
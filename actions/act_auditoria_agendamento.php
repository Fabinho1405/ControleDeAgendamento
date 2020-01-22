<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	include_once("../log.php");

	$decisao = $_GET['dec'];
	$idagendamento = $_GET['idagdm'];
	$idfunc = $_SESSION['id_usuario'];


	if($decisao == 1){
		//Aprova o agendamento normalmente.
		$update_agendamentos = "UPDATE agendamentos SET id_status_auditoria = 2, auditor_agendamentos = $idfunc, hora_auditoria = NOW() WHERE id_agendamentos = '$idagendamento'";
		$exec_update_agendamentos = mysqli_query($conn, $update_agendamentos);
		//LOG                                   
           $ip_log = $_SERVER['REMOTE_ADDR'];
           $idfuncionario = $_SESSION['id_usuario'];
           $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento aprovado pela auditoria -> IDAG: $idagendamento', 'ALERTA', '$idfuncionario');";
          $exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG		
		header("Location:../auditar_agendamento.php");
	}else if($decisao == 2){
		//Agendamento Reprovado | Pede o motivo de reprovação.
		header("Location:../motivo_negar_agendamento.php?idagdm=$idagendamento");
	}else if($decisao == 3){
		//Registra negação do agendamento
		$grau = $_POST['select_grau'];
		$motivo = $_POST['motivo'];
		$reanalise = $_POST['aut_reanalise'];
			if(!empty($motivo)){
				$update_agendamento_auditado = "UPDATE agendamentos SET id_status_auditoria = 3, motivo_reprovacao_auditoria = '$motivo', id_ga = '$grau', auditor_agendamentos = '$idfunc', hora_auditoria = NOW(), aut_re_analise_auditoria = '$reanalise'  WHERE id_agendamentos = '$idagendamento'";
				$exec_agendamento_auditado = mysqli_query($conn, $update_agendamento_auditado);
				//LOG                                   
		           $ip_log = $_SERVER['REMOTE_ADDR'];
		           $idfuncionario = $_SESSION['id_usuario'];
		           $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento reprovado pela auditoria -> IDAG: $idagendamento | GRAV: $grau | MOT: $motivo | AUT_REAN: $reanalise', 'ALERTA', '$idfuncionario');";
		          $exec_insert_log = mysqli_query($conn, $insert_log);
        		//FIM LOG
				header("Location:../auditar_agendamento.php");
			}else{
				$_SESSION['msgcad'] = "<div class='alert alert-danger' role='alert'>
                                            Preencha o Motivo!
                                    </div>";
                                    header("Location: ".$_SERVER['HTTP_REFERER']."");
			}
	}else if($decisao == 4){
		//Agendamento aprovado pela re-análise
		//Aprova o agendamento normalmente.
		$update_agendamentos = "UPDATE agendamentos SET id_status_auditoria = 2, auditor_agendamentos = $idfunc, hora_auditoria = NOW() WHERE id_agendamentos = '$idagendamento'";
		$exec_update_agendamentos = mysqli_query($conn, $update_agendamentos);
		//LOG                                   
           $ip_log = $_SERVER['REMOTE_ADDR'];
           $idfuncionario = $_SESSION['id_usuario'];
           $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'agendamento aprovado pela re-analise -> IDAG: $idagendamento', 'ALERTA', '$idfuncionario');";
          $exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG		
		header("Location:../reanalisar_agendamento_scouter.php");
	};

?>
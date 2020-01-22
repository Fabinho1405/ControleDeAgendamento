<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$identificacao = $_GET['idp'];
	$funcionario = $_SESSION['id_usuario'];
	if($identificacao == 1){
		$select_possui_almoco = "SELECT * FROM pausas WHERE id_func = '$funcionario' AND date(dia_vigente) = date(NOW()) AND almoco = '1'";
		$exec_select_possui_almoco = mysqli_query($conn, $select_possui_almoco);
		$conf_possui_almoco = mysqli_num_rows($exec_select_possui_almoco);
		//IDENTIFICAR SE JA POSSUI ALMOÇO INICIADO
		if($conf_possui_almoco == 0){
			$insere_inicio_almoco = "INSERT INTO pausas(id_func, almoco, hora_inicio_almoco, dia_vigente) VALUES ($funcionario, 1, NOW(), NOW())";		
			$exec_inicio_almoco = mysqli_query($conn, $insere_inicio_almoco);
			//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'iniciou o horario de almoco', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         //FIM LOG
			header("Location:../php/deslogar.php");
		}else{
			$insere_fim_almoco = "UPDATE pausas SET hora_fim_almoco = NOW(), libera_pausa = '1' WHERE id_func = '$funcionario' AND date(dia_vigente) = date(NOW())";
			$exec_fim_almoco = mysqli_query($conn, $insere_fim_almoco);
			//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'finalizou o horario de almoco', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         //FIM LOG
			header("Location: ../index.php");
		}	

	}else if($identificacao == 2){
		$verificar_pausa = "SELECT * FROM pausas WHERE id_func = '$funcionario' AND date(dia_vigente) = date(NOW()) AND libera_pausa = '1'";
		$exec_verifica_pausa = mysqli_query($conn, $verificar_pausa);
		$row_pausa = mysqli_fetch_assoc($exec_verifica_pausa);
		if($row_pausa['libera_pausa'] == 1 && $row_pausa['pausa'] == 0){
			$inicio_hora_pausa = "UPDATE pausas SET pausa = '1', hora_inicio_pausa = NOW() WHERE id_func = '$funcionario' AND date(dia_vigente) = date(NOW())";
			$exec_inicio_pausa = mysqli_query($conn, $inicio_hora_pausa);
			//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'iniciou a pausa', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         //FIM LOG
			header("Location: ../php/deslogar.php");
		}else if($row_pausa['pausa'] == 1){
			$fim_hora_pausa = "UPDATE pausas SET hora_fim_pausa = NOW(), pausas_finalizadas = '1' WHERE id_func = '$funcionario' AND date(dia_vigente) = date(NOW())";
			$exec_fim_hora_pausa = mysqli_query($conn, $fim_hora_pausa);
			//LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'finalizou a pausa', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         	//FIM LOG
			header("Location: ../index.php");
		}	

	};

	




?>
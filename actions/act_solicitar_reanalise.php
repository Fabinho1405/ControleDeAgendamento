<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$idagendamento = $_GET['idagdm'];
	$idfuncionario = $_SESSION['id_usuario'];
	$motivoreanalise = $_POST['motivo'];
	//Procurar o agendamento e verificar se é do usuário mesmo
	$select_encontrar_agendamento = "SELECT * FROM agendamentos WHERE id_agendamentos = '$idagendamento' AND id_func = '$idfuncionario'";
	$exec_select_encontrar_agendamento = mysqli_query($conn, $select_encontrar_agendamento);
	$existe_agendamento = mysqli_num_rows($exec_select_encontrar_agendamento);
	$row_agendamento = mysqli_fetch_assoc($exec_select_encontrar_agendamento);
	if($existe_agendamento > 0){
		$auditor = $row_agendamento['auditor_agendamentos'];
		//executa o update
		$qtd_vezes_re_analise = $row_agendamento['qtd_re_analise_auditoria'] + 1;

		$update_reanalise = "UPDATE agendamentos SET motivo_reanalise_auditoria = '$motivoreanalise', qtd_re_analise_auditoria = '$qtd_vezes_re_analise', id_status_auditoria = '4' WHERE id_agendamentos = '$idagendamento' AND id_func = '$idfuncionario'";
		$exec_update_reanalise = mysqli_query($conn, $update_reanalise);
		//LOG                                   
		           $ip_log = $_SERVER['REMOTE_ADDR'];
		           $idfuncionario = $_SESSION['id_usuario'];
		           $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'pedido de re-analise -> IDAG: $idagendamento | AUDITOR: $auditor | MOT_REAN: $motivoreanalise', 'ALERTA', '$idfuncionario');";
		      	$exec_insert_log = mysqli_query($conn, $insert_log);
        //FIM LOG

		header("Location: ../listar_agendamentos_negados.php");
	}else{
		//tentativa de fraude com o agendamento 

	}




?>
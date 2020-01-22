<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$idcontrole = $_GET['idcontrole'];
	$idfuncionario = $_SESSION['id_usuario'];
	$motivo = $_POST['motivo'];

	//Pesquisa se ficha é mesmo do funcionario
		$select_ficha = "SELECT * FROM controle_ligacao WHERE id_controle = '$idcontrole' AND id_func = '$idfuncionario'";
		$exec_select_ficha = mysqli_query($conn, $select_ficha);
		$qtd_select_ficha = mysqli_num_rows($exec_select_ficha);

		if($qtd_select_ficha > 0){
			//
			




			// Desativa ficha do sistema
				$update_ficha = "UPDATE controle_ligacao SET id_status_sistema = 0, ultimo_fedback = NOW(), motivo_si = '$motivo' WHERE id_controle = '$idcontrole'";
				$exec_update_ficha = mysqli_query($conn, $update_ficha);

				$log_ficha_seminteresse = "INSERT controle_fb_ligacao(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha,status) VALUES ($usuario,$qtd_final_n_fedback,$unidade,NOW(),$idcontrole, $select)";
		        mysqli_query($conn, $log_ficha_seminteresse);

		        //LOG                                   
		             $ip_log = $_SERVER['REMOTE_ADDR'];
		             $idfuncionario = $_SESSION['id_usuario'];
		             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'declarou como sem interesse | IDFICHA: $idcontrole | MOT: $motivo', 'ALERTA', '$idfuncionario');";
		             $exec_insert_log = mysqli_query($conn, $insert_log);
		        //FIM LOG
		        header("Location: ../lista_telefonica.php");
    }else{

    }


?>
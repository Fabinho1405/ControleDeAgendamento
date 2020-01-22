<?php
	session_start();
	include_once("conection/conexao.php");
	$select = $_POST['select_status'];
	$idcontrole = $_GET['idcontrole'];
	$usuario = $_SESSION['id_usuario'];
	$unidade = $_SESSION['unidade'];

	if($select == 1){
		echo "EM ABERTO AINDA";
	}else if($select == 2){
		$result_agenda = "SELECT * FROM controle_fichas WHERE id_controle = $idcontrole";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		$log_ficha_agendado = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha,status) VALUES ($usuario,2,$unidade,NOW(),$idcontrole, $select)";
		mysqli_query($conn, $log_ficha_agendado);

		while($row_agenda = mysqli_fetch_assoc($resultado_agenda)){
		header("Location: cadastrar_agendamento_ligacao.php?idcontrole=".$row_agenda['id_controle']."&nomeresponsavel=".$row_agenda['nome_responsavel_controle']."&nomemodelo=".$row_agenda['nome_modelo_controle']."&telefoneprincipal=".$row_agenda['telefone_principal_controle']."&telefonesecundario=".$row_agenda['telefone_secundario_controle']."&idfuncionario=".$row_agenda['id_func']."&extracao=".$row_agenda['id_extracao']);
		}
	}else if($select == 3 || $select == 4 || $select == 5 || $select == 6 || $select == 8 ){
		$result_agenda = "SELECT * FROM controle_fichas WHERE id_controle = $idcontrole";
		$resultado_agenda = mysqli_query($conn, $result_agenda);
		while($row_agenda = mysqli_fetch_assoc($resultado_agenda)){

		if($row_agenda['fb_7'] <> 0){		
				$insert_off = "UPDATE controle_fichas SET id_status_sistema = 0 WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_off);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_1'] == 1){
				$insert_fb1 = "UPDATE controle_fichas SET fb_1 = $select, fb_1_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb1);

				$log_ficha1 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha,status) VALUES ($usuario,1,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha1);

				header("lista_telefonica.php");
			}else if($row_agenda['fb_2'] == 0){
				$insert_fb2 = "UPDATE controle_fichas SET fb_2 = $select, fb_2_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb2);
				$log_ficha2 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,2,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha2);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_3'] == 0){
				$insert_fb3 = "UPDATE controle_fichas SET fb_3 = $select, fb_3_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb3);
				$log_ficha3 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,3,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha3);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_4'] == 0){
				$insert_fb4 = "UPDATE controle_fichas SET fb_4 = $select, fb_4_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb4);
				$log_ficha4 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,4,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha4);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_5'] == 0){
				$insert_fb5 = "UPDATE controle_fichas SET fb_5 = $select, fb_5_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb5);				
				$log_ficha5 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,5,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha5);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_6'] == 0){
				$insert_fb6 = "UPDATE controle_fichas SET fb_6 = $select, fb_6_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb6);
				$log_ficha6 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,6,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha6);
				header("lista_telefonica.php");
			}else if($row_agenda['fb_7'] == 0){
				$insert_fb7 = "UPDATE controle_fichas SET fb_7 = $select, fb_7_hour = NOW() WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_fb7);
				$log_ficha7 = "INSERT log_fedback(id_func, num_fedback, id_unidade, hora_ligacao, id_ficha, status) VALUES ($usuario,7,$unidade,NOW(),$idcontrole, $select)";
				mysqli_query($conn, $log_ficha7);
				header("lista_telefonica.php");
			}
			
		}
		//$result_status = "UPDATE controle_fichas SET id_status_ligacao = $select, modified = NOW() WHERE id_controle = $idcontrole";
		//$resultado_status = mysqli_query($conn, $result_status);
		header("location: lista_telefonica.php");
	}else if($select == 7){
		$insert_desabilitar_ficha = "UPDATE controle_fichas SET id_status_sistema = 0, fb_1 = 7, fb_2 = 7, fb_3 = 7, fb_4 = 7, fb_5 = 7, fb_6 = 7, fb_7 = 7 WHERE id_controle = $idcontrole";
				mysqli_query($conn, $insert_desabilitar_ficha);
				//LOG                                   
		           $ip_log = $_SERVER['REMOTE_ADDR'];
		           $idfuncionario = $_SESSION['id_usuario'];
		           $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'indexou a ficha->$idcontrole como sem interesse | UNID: $unidade', 'ALERTA', '$idfuncionario');";
		          $exec_insert_log = mysqli_query($conn, $insert_log);
        		//FIM LOG
				header("Location:lista_telefonica.php");
	}




?>
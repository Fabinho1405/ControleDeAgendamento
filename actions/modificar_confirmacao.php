<?php

	include_once("../conection/conexao.php");
	ob_start();
	

	$dataconfirmacao =  $_GET['dataconfirmacao'];
	$idagendamento = $_GET['idagendamento'];
	$idcliente = $_GET['cli'];
	$nfedback = $_GET['fb'];
	$sts_conf = $_POST['status_confirmacao'];	 
	if($nfedback == 1){
		// Registra primeiro contato com status e idagendamento 
		if($sts_conf == 4 || $sts_conf == 5 || $sts_conf == 6 || $sts_conf == 8 || $sts_conf == 9){

			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 2){
			 
			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW(), confirmado = '1' WHERE id_agendamentos = '$idagendamento'";

			$query_conf_sts = mysqli_query($conn, $query_conf);

			header('Location: '.$_SERVER['HTTP_REFERER']);  

		}else if($sts_conf == 3){
			//EXECUTAR REAGENDAMENTO
			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW(), confirmado = '0' WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf); 
			if($_GET['conf'] == 1){ 
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente&conf=1"); 
			}else{
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente"); 	
			};
					
		}else if($sts_conf == 7){
			//DESATIVA AGENDAMENTO DO CLIENTE
			$desativa_agendamento = "UPDATE agendamentos SET id_status_sistema = '0', fbc_1 = '7', fbc_2 = '7', fbc_3 = '7', fbc_4 = '7', fbc_1_hour = NOW(), fbc_2_hour = NOW(), fbc_3_hour = NOW(), fbc_4_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$exec_desativa_agendamento = mysqli_query($conn, $desativa_agendamento);
			header('Location: '.$_SERVER['HTTP_REFERER']); 
		}
	}else{

	}
	if($nfedback == 2){
		// Registra segundo contato com status e idagendamento
		if($sts_conf == 4 || $sts_conf == 5 || $sts_conf == 6 || $sts_conf == 8 || $sts_conf == 9){

			$query_conf = "UPDATE agendamentos SET fbc_2 = '$sts_conf', fbc_2_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 2){
			
			$query_conf = "UPDATE agendamentos SET fbc_2 = '$sts_conf', fbc_2_hour = NOW(), confirmado = '1' WHERE id_agendamentos = '$idagendamento'";

			$query_conf_sts = mysqli_query($conn, $query_conf);

			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 3){
			//EXECUTAR REAGENDAMENTO
			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW(), confirmado = '0' WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			if($_GET['conf'] == 1){ 
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente&conf=1"); 
			}else{
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente"); 	
			};
		}else if($sts_conf == 7){
			$desativa_agendamento = "UPDATE agendamentos SET id_status_sistema = '0', fbc_1 = '7', fbc_2 = '7', fbc_3 = '7', fbc_4 = '7', fbc_1_hour = NOW(), fbc_2_hour = NOW(), fbc_3_hour = NOW(), fbc_4_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$exec_desativa_agendamento = mysqli_query($conn, $desativa_agendamento);
			header('Location: '.$_SERVER['HTTP_REFERER']); 
		}	
	}else if($nfedback == 3){
		// Registra terceiro contato com status e idagendamento
		if($sts_conf == 4 || $sts_conf == 5 || $sts_conf == 6 || $sts_conf == 8 || $sts_conf == 9){

			$query_conf = "UPDATE agendamentos SET fbc_3 = '$sts_conf', fbc_3_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 2){
			
			$query_conf = "UPDATE agendamentos SET fbc_3 = '$sts_conf', fbc_3_hour = NOW(), confirmado = '1' WHERE id_agendamentos = '$idagendamento'";

			$query_conf_sts = mysqli_query($conn, $query_conf); 

			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 3){
			//EXECUTAR REAGENDAMENTO
			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW(), confirmado = '0' WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			if($_GET['conf'] == 1){ 
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente&conf=1"); 
			}else{
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente"); 	
			};
		}else if($sts_conf == 7){
			$desativa_agendamento = "UPDATE agendamentos SET id_status_sistema = '0', fbc_1 = '7', fbc_2 = '7', fbc_3 = '7', fbc_4 = '7', fbc_1_hour = NOW(), fbc_2_hour = NOW(), fbc_3_hour = NOW(), fbc_4_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$exec_desativa_agendamento = mysqli_query($conn, $desativa_agendamento);
			header('Location: '.$_SERVER['HTTP_REFERER']); 
		}
		
	}else if($nfedback == 4){
		// Registra quarto contato com status e idagendamento
		if($sts_conf == 4 || $sts_conf == 5 || $sts_conf == 6 || $sts_conf == 8 || $sts_conf == 9){

			$query_conf = "UPDATE agendamentos SET fbc_4 = '$sts_conf', fbc_4_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 2){
			
			$query_conf = "UPDATE agendamentos SET fbc_4 = '$sts_conf', fbc_4_hour = NOW(), confirmado = '1' WHERE id_agendamentos = '$idagendamento'";

			$query_conf_sts = mysqli_query($conn, $query_conf);

			header('Location: '.$_SERVER['HTTP_REFERER']);

		}else if($sts_conf == 3){
			//EXECUTAR REAGENDAMENTO
			$query_conf = "UPDATE agendamentos SET fbc_1 = '$sts_conf', fbc_1_hour = NOW(), confirmado = '0' WHERE id_agendamentos = '$idagendamento'";
			$query_conf_sts = mysqli_query($conn, $query_conf);
			if($_GET['conf'] == 1){ 
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente&conf=1"); 
			}else{
				header("Location:../reagendarConfirmacao.php?ag=$idagendamento&cli=$idcliente"); 	
			};
		}else if($sts_conf == 7){
			$desativa_agendamento = "UPDATE agendamentos SET id_status_sistema = '0', fbc_1 = '7', fbc_2 = '7', fbc_3 = '7', fbc_4 = '7', fbc_1_hour = NOW(), fbc_2_hour = NOW(), fbc_3_hour = NOW(), fbc_4_hour = NOW() WHERE id_agendamentos = '$idagendamento'";
			$exec_desativa_agendamento = mysqli_query($conn, $desativa_agendamento);
			header('Location: '.$_SERVER['HTTP_REFERER']); 
		}
		
	}

?>

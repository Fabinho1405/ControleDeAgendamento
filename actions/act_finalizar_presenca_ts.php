<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_SESSION['id_usuario'];
	$unidadefunc = $_SESSION['unidade'];
	$procedimento = $_GET['pcdm'];

	if($unidadefunc == 1){
		$update_acp = "UPDATE estudio_exclusive SET final_atendimento_ec = NOW(), atendimento_finalizado = '1', atendimento_andamento_ec = '0' WHERE id_ec = '$procedimento'";
		$exec_update_acp = mysqli_query($conn, $update_acp);
		header("Location:../pegar_procedimento_estudio.php");
	}else if($unidadefunc == 4){
		$update_acp = "UPDATE estudio_concept SET final_atendimento_ec = NOW(), atendimento_finalizado = '1', atendimento_andamento_ec = '0' WHERE id_ec = '$procedimento'";
		$exec_update_acp = mysqli_query($conn, $update_acp);
		header("Location:../pegar_procedimento_estudio.php");
	}


	

?>

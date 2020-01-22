<?php

	session_start();
	ob_start();
	$unidade = $_SESSION['unidade'];
	include_once("../conection/conexao.php");

	$idacompanhamento = $_GET['idpcdm'];
	$teste = $_GET['teste'];
	$motivo = $_POST['motivodispensa'];

	if(!empty($motivo)){
		//FINALIZAR ATENDIMENTO
		if($unidade == 4){
			$update_finaliza = "UPDATE acompanhamento_concept SET final_atendimento = NOW(), andamento_atendimento = '0', fechamento = '0', motivo_dispensa = '$motivo', finaliza_cliente = '1' WHERE id_acompanhamento = $idacompanhamento";
			$exec_update_finaliza = mysqli_query($conn, $update_finaliza);
			header("Location: ../");
		}else if($unidade == 1){
			if($teste == 0){
			$update_finaliza = "UPDATE acompanhamento_exclusive SET final_atendimento = NOW(), andamento_atendimento = '0', fechamento = '0', motivo_dispensa = '$motivo', finaliza_cliente = '1' WHERE id_acompanhamento = $idacompanhamento";
			$exec_update_finaliza = mysqli_query($conn, $update_finaliza);
			header("Location: ../");
			}else if($teste == 1){
				$update_finaliza = "UPDATE acompanhamento_exclusive SET final_resultado = NOW(), andamento_resultado = '0', fechamento = '0', motivo_dispensa = '$motivo', finaliza_cliente = '1' WHERE id_acompanhamento = $idacompanhamento";
			$exec_update_finaliza = mysqli_query($conn, $update_finaliza);
			header("Location: ../");
			}
		}
	}else{
		echo '<script> Alert("PREENCHA O MOTIVO"); </script>';
	};





?>
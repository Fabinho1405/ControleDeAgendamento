<?php
	session_start();
	ob_start();
	
	include_once("../conection/conexao.php");

	$idfuncionario = $_SESSION['id_usuario'];
    $unidade = $_SESSION['unidade'];


	$procedimento = $_GET['pcdm'];
	$id_trab_sel = $_GET['idts'];
	$contrato = $_GET['cnt'];

	if($procedimento == 1){
		//Procedimento de marcar presença para seleção
		if($unidade == 1){
		
		//PROCURA O ID DO TRABALHOOU SELEÇÃO
		$select_ts = "SELECT * FROM trab_e_sele_exclusive WHERE id_ts = '$id_trab_sel'";
		$exec_select_ts = mysqli_query($conn, $select_ts);
		$row_ts = mysqli_fetch_assoc($exec_select_ts);

		//MARCA PRESENÇA NO ID DE TRABALHO OU SELEÇÃO
		$update_ts = "UPDATE trab_e_sele_exclusive SET compareceu = '1', hora_compareceu = NOW() WHERE id_ts = '$id_trab_sel'";
		$exec_update_ts = mysqli_query($conn, $update_ts);

		//ENCAMINHA PARA O ESTÚDIO
		$marca = $row_ts['id_marcas'];
		$insert_estudio = "INSERT INTO estudio_exclusive(id_ts, contrato_cc, func_encaminhou_producao_ec, liberado_espera_producao_ec, id_motivo_estudio, id_marca_sel_trab) VALUES ('$id_trab_sel', '$contrato', '$idfuncionario', '1', '4', '$marca');";
		$exec_insert_estudio = mysqli_query($conn, $insert_estudio);

		//DIRECIONA A RECEPCIONISTA PARA MARCA UMA NOVA PRESENÇA
		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Presença Marcada com Sucesso!
        </div>";
        header("Location: ../marcar_presenca.php");
		}else if($unidade == 4){
			//PROCURA O ID DO TRABALHOOU SELEÇÃO
		$select_ts = "SELECT * FROM trab_e_sele_concept WHERE id_ts = '$id_trab_sel'";
		$exec_select_ts = mysqli_query($conn, $select_ts);
		$row_ts = mysqli_fetch_assoc($exec_select_ts);

		//MARCA PRESENÇA NO ID DE TRABALHO OU SELEÇÃO
		$update_ts = "UPDATE trab_e_sele_concept SET compareceu = '1', hora_compareceu = NOW() WHERE id_ts = '$id_trab_sel'";
		$exec_update_ts = mysqli_query($conn, $update_ts);

		//ENCAMINHA PARA O ESTÚDIO
		$marca = $row_ts['id_marcas'];
		$insert_estudio = "INSERT INTO estudio_concept(id_ts, contrato_cc, func_encaminhou_ec, liberado_espera_producao_ec, id_motivo_estudio, id_marca_sel_trab) VALUES ('$id_trab_sel', '$contrato', '$idfuncionario', '1', '4', '$marca');";
		$exec_insert_estudio = mysqli_query($conn, $insert_estudio);

		//DIRECIONA A RECEPCIONISTA PARA MARCA UMA NOVA PRESENÇA
		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Presença Marcada com Sucesso!
        </div>";
        header("Location: ../marcar_presenca.php");

		}
	}else if($procedimento == 2){
		//Procedimento de marcar presença para trabalho
		if($unidade == 1){
		
		//PROCURA O ID DO TRABALHOOU SELEÇÃO
		$select_ts = "SELECT * FROM trab_e_sele_exclusive WHERE id_ts = '$id_trab_sel'";
		$exec_select_ts = mysqli_query($conn, $select_ts);
		$row_ts = mysqli_fetch_assoc($exec_select_ts);

		//MARCA PRESENÇA NO ID DE TRABALHO OU SELEÇÃO
		$update_ts = "UPDATE trab_e_sele_exclusive SET compareceu = '1', hora_compareceu = NOW() WHERE id_ts = '$id_trab_sel'";
		$exec_update_ts = mysqli_query($conn, $update_ts);

		//ENCAMINHA PARA O ESTÚDIO
		$marca = $row_ts['id_marcas'];
		$insert_estudio = "INSERT INTO estudio_exclusive(id_ts, contrato_cc, func_encaminhou_ec, liberado_espera_ec, id_motivo_estudio, id_marca_sel_trab) VALUES ('$id_trab_sel', '$contrato', '$idfuncionario', '1', '3', '$marca');";
		$exec_insert_estudio = mysqli_query($conn, $insert_estudio);

		//DIRECIONA A RECEPCIONISTA PARA MARCA UMA NOVA PRESENÇA
		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Presença Marcada com Sucesso!
        </div>";
        header("Location: ../marcar_presenca.php");
		}else if($unidade == 4){
			//PROCURA O ID DO TRABALHOOU SELEÇÃO
		$select_ts = "SELECT * FROM trab_e_sele_concept WHERE id_ts = '$id_trab_sel'";
		$exec_select_ts = mysqli_query($conn, $select_ts);
		$row_ts = mysqli_fetch_assoc($exec_select_ts);

		//MARCA PRESENÇA NO ID DE TRABALHO OU SELEÇÃO
		$update_ts = "UPDATE trab_e_sele_concept SET compareceu = '1', hora_compareceu = NOW() WHERE id_ts = '$id_trab_sel'";
		$exec_update_ts = mysqli_query($conn, $update_ts);

		//ENCAMINHA PARA O ESTÚDIO
		$marca = $row_ts['id_marcas'];
		$insert_estudio = "INSERT INTO estudio_concept(id_ts, contrato_cc, func_encaminhou_ec, liberado_espera_ec, id_motivo_estudio, id_marca_sel_trab) VALUES ('$id_trab_sel', '$contrato', '$idfuncionario', '1', '3', '$marca');";
		$exec_insert_estudio = mysqli_query($conn, $insert_estudio);

		//DIRECIONA A RECEPCIONISTA PARA MARCA UMA NOVA PRESENÇA
		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Presença Marcada com Sucesso!
        </div>";
        header("Location: ../marcar_presenca.php");
		}





	};
?>
<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	$idfuncionario = $_SESSION['id_usuario'];
	$unidadefunc = $_SESSION['unidade'];
	$contrato = $_GET['cn'];
	$motivo_encaminhado = $_POST['motivo_encaminhamento'];
	$obsprod = $_POST['obs_prod'];

	//Verificar Unidade
	if($unidadefunc == 4){
		//Verifica se o contrato realmente existe
		$select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$contrato' LIMIT 1";
		$exec_select_contrato = mysqli_query($conn, $select_contrato);
		$qtd_select_contrato = mysqli_num_rows($exec_select_contrato);
		$row_contrato = mysqli_fetch_assoc($exec_select_contrato);

		if($qtd_select_contrato > 0){
			// Informa que o contrato existe e cadastra na planilha do estúdio a solicitação
			$insere_solicitacao_estudio = "INSERT estudio_concept (contrato_cc, func_encaminhou_ec, liberado_espera_ec, id_motivo_estudio, created) VALUES ('$contrato', '$idfuncionario', '1', '$motivo_encaminhado', NOW())";
			$exec_insert_solicitacao_estudio = mysqli_query($conn, $insere_solicitacao_estudio);
			header("Location: ../index.php");
		}else{
			// Informa que o contrato NÃO foi cadastrado corretamente
		}
	}else if($unidadefunc == 1){
		///Verifica se o contrato realmente existe
		$select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$contrato' LIMIT 1"; 
		$exec_select_contrato = mysqli_query($conn, $select_contrato);
		$qtd_select_contrato = mysqli_num_rows($exec_select_contrato);
		$row_contrato = mysqli_fetch_assoc($exec_select_contrato);

		if($qtd_select_contrato > 0){
			// Informa que o contrato existe e cadastra na planilha do estúdio a solicitação
			$insere_solicitacao_estudio = "INSERT estudio_exclusive (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, liberado_espera_ec, id_motivo_estudio, created) VALUES ('$contrato', '$idfuncionario', '$obsprod', '1', '$motivo_encaminhado', NOW())";
			$exec_insert_solicitacao_estudio = mysqli_query($conn, $insere_solicitacao_estudio);
			$_SESSION['msgDetails'] = "<div class='alert alert-success' role='alert'>
                                            Modelo Encaminhado Com Sucesso para o Estúdio !
                             </div>";
			header("Location: ../detailsContrato.php?ncontrato=$contrato");

		}else{
			// Informa que o contrato NÃO foi cadastrado corretamente
		}
	}


?>
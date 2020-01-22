<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");

	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
	$qtd_fichas = $_POST['qtd_fichas'];
	$colaborador = $_POST['idcolaborador'];
	$tipoficha = $_POST['tipoficha'];

	//VERIFICA SE A QUANTIDADE DO PEDIDO EXISTE EM STAND BY
	$select_quantidade = "SELECT * FROM controle_ligacao WHERE stand_by = '1' AND unid_stand_by = '$unidadefunc' ORDER BY id_controle ASC";
    $exec_quantidade = mysqli_query($conn, $select_quantidade);
    $qtd_stand_by = mysqli_num_rows($exec_quantidade);
		if($qtd_fichas <= $qtd_stand_by){
			//Faz a migração das fichas para o funcionário solicitado
			$update_fichas = "UPDATE controle_ligacao SET stand_by = '0', id_func = '$colaborador', data_liberada_stand_by = NOW() WHERE unid_stand_by = '$unidadefunc' AND stand_by = '1' AND tipo_ficha = '$tipoficha' ORDER BY id_controle ASC LIMIT $qtd_fichas";
			$exec_update_fichas = mysqli_query($conn, $update_fichas);
			$_SESSION['msg_cad'] = "<div class='alert alert-success' role='alert'>Fichas encaminhadas com Sucesso!</div>";
			header("Location: ../liberar_fichas.php");
		}else{
			//Envia mensagem dizendo que a quantidade solicitada não tem em stand by
			$_SESSION['msg_cad'] = "<div class='alert alert-warning' role='alert'>Quantidade Solicitada Excede o Valor de Fichas Disponíveis.</div>";
			header("Location: ../liberar_fichas.php");
		}







?>
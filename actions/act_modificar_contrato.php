<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	include_once("../conection/connection.php");
	$pdo=conectar();

	$idfuncionario = $_SESSION['id_usuario']; 
    $unidade = $_SESSION['unidade'];
	

	$ncontrato = $_GET['ncontrato'];
	$gerente = $_SESSION['gerencial'];

	//PESQUISA O CONTRATO
	if($unidade == 1){
		$select_contrato = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$ncontrato'";
		$exec_contrato = mysqli_query($conn, $select_contrato);
		$agencia = "clientes_exclusive";
		$insertUpdate=$pdo->prepare("INSERT INTO log_update_contrato_exclusive(n_contrato, campo_update, valor_anterior, valor_novo, data_update)VALUES(:ncontrato, :campoUpdate, :valorAnterior, :valorNovo, NOW())"); 

	}else if($unidade == 4){
		$select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$ncontrato'";
		$exec_contrato = mysqli_query($conn, $select_contrato);
		$agencia = "clientes_concept";
		$insertUpdate=$pdo->prepare("INSERT INTO log_update_contrato_concept(n_contrato, campo_update, valor_anterior, valor_novo, data_update)VALUES(:ncontrato, :campoUpdate, :valorAnterior, :valorNovo, NOW())"); 
	};

	$row_contrato = mysqli_fetch_assoc($exec_contrato);

	//VERIFICA SE HOUVE MODIFICAÇÃO NO MATERIAL
	if($_POST['select_material'] <> $row_contrato['material_cc']){
		$material_new = $_POST['select_material'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET material_cc = '$material_new' WHERE contrato_cc = '$ncontrato'";
			//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "material_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['material_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['select_material']);
			$insertUpdate->execute();

		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET material_cc = '$material_new' WHERE contrato_cc = '$ncontrato'";
			//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "material_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['material_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['select_material']);
			$insertUpdate->execute();
		}
		$exec_update = mysqli_query($conn, $update_contrato);


	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO NO VALOR DO MATERIAL
	if($_POST['valor_material'] <> $row_contrato['valor_material_cc']){
		$valor_new = $_POST['valor_material'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET valor_material_cc = '$valor_new' WHERE contrato_cc = '$ncontrato'";
			//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "valor_material_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['valor_material_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['valor_material']);
			$insertUpdate->execute();

		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET valor_material_cc = '$valor_new' WHERE contrato_cc = '$ncontrato'";
			//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "valor_material_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['valor_material_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['valor_material']);
			$insertUpdate->execute();
		}
		$exec_update = mysqli_query($conn, $update_contrato);
	}else{

	}

	//VERIFICA SE DESATIVOU ALGUM LANÇAMENTO
	if(isset($_POST['lancamentos_on'])){
		foreach ($_POST['lancamentos_on'] as $escolhidos) {
			if($unidade == 1){
				$update_contrato = "UPDATE lancamento_exclusive SET status = '0' WHERE id_lancamento = '$escolhidos' AND n_contrato_lancamento = '$ncontrato' ";
				//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "lancamentos");
			$insertUpdate->bindValue(":valorAnterior", "lancamento OFF");
			$insertUpdate->bindValue(":valorNovo", $escolhidos);
			$insertUpdate->execute();

			}else if($unidade == 4){
				$update_contrato = "UPDATE lancamento_concept SET status = '0' WHERE id_lancamento = '$escolhidos' AND n_contrato_lancamento = '$ncontrato' ";
				//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "lancamentos");
			$insertUpdate->bindValue(":valorAnterior", "lancamento OFF");
			$insertUpdate->bindValue(":valorNovo", $escolhidos);
			$insertUpdate->execute();
			}
			$exec_update = mysqli_query($conn, $update_contrato);
			};
	}else{

	}



	//DESTRÓI A GLOBAL DA SENHA DA GERÊNCIA
	unset($_SESSION['gerencial']);
	unset($_SESSION['nome_gerencial']);
	echo "<script>
			window.close();
		</script>";
	

?>
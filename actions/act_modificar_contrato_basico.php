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
		$select_contrato = "SELECT * FROM clientes_concept WHERE contrato_cc = '$ncontrato'";
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

	//VERIFICA SE HOUVE MODIFICAÇÃO NO NOME DO MODELO
	if($_POST['nome_modelo'] <> $row_contrato['nome_modelo_cc']){
		$nome_new = $_POST['nome_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET nome_modelo_cc = '$nome_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET nome_modelo_cc = '$nome_new' WHERE contrato_cc = '$ncontrato'";
		}
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "nome_modelo_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['nome_modelo_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['nome_modelo']);
			$insertUpdate->execute();
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO RG DO MODELO
	if($_POST['rg_modelo'] <> $row_contrato['rg_modelo_cc']){
		$rg_new = $_POST['rg_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET rg_modelo_cc = '$rg_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET rg_modelo_cc = '$rg_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "rg_modelo_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['rg_modelo_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['rg_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO CPF MODELO
	if($_POST['cpf_modelo'] <> $row_contrato['cpf_modelo_cc']){
		$cpf_new = $_POST['cpf_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET cpf_modelo_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET cpf_modelo_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "cpf_modelo_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['cpf_modelo_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['cpf_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO NOME  DO RESPONSAVEL
	if($_POST['nome_responsavel'] <> $row_contrato['nome_responsavel_cc']){
		$responsavel_new = $_POST['nome_responsavel'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET nome_responsavel_cc = '$responsavel_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET nome_responsavel_cc = '$responsavel_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "nome_responsavel_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['nome_responsavel_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['nome_responsavel']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO RG DO RESPONSAVEL
	if($_POST['rg_responsavel'] <> $row_contrato['rg_responsavel_cc']){
		$rg_new = $_POST['rg_responsavel'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET rg_responsavel_cc = '$rg_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET rg_responsavel_cc = '$rg_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "rg_responsavel_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['rg_responsavel_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['rg_responsavel']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO CPF DO RESPONSAVEL
	if($_POST['cpf_responsavel'] <> $row_contrato['cpf_responsavel_cc']){
		$cpf_new = $_POST['cpf_responsavel'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET cpf_responsavel_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET cpf_responsavel_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "cpf_responsavel_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['cpf_responsavel_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['cpf_responsavel']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO NASCIMENTO DO MODELO
	if($_POST['nascimento_modelo'] <> $row_contrato['nascimento_cc']){
		$nascimento_new = $_POST['nascimento_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET nascimento_cc = '$nascimento_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET nascimento_cc = '$nascimento_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "nascimento_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['nascimento_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['nascimento_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO IDADE DO MODELO
	if($_POST['idade_modelo'] <> $row_contrato['idade_cc']){
		$idade_new = $_POST['idade_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET idade_cc = '$idade_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET idade_cc = '$idade_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "idade_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['idade_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['idade_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO ENDEREÇO
	if($_POST['endereco_modelo'] <> $row_contrato['endereco_cc']){
		$endereco_new = $_POST['endereco_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET endereco_cc = '$endereco_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET endereco_cc = '$endereco_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "endereco_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['endereco_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['endereco_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO NUMERO
	if($_POST['numero_modelo'] <> $row_contrato['numero_cc']){
		$numero_new = $_POST['numero_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET numero_cc = '$numero_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET numero_cc = '$numero_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "numero_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['numero_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['numero_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO COMPLEMENTO
	if($_POST['complemento_modelo'] <> $row_contrato['complemento_cc']){
		$complemento_new = $_POST['complemento_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET complemento_cc = '$complemento_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET complemento_cc = '$complemento_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "complemento_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['complemento_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['complemento_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO BAIRRO
	if($_POST['bairro_modelo'] <> $row_contrato['bairro_cc']){
		$bairro_new = $_POST['bairro_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET bairro_cc = '$bairro_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET bairro_cc = '$bairro_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "bairro_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['bairro_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['bairro_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO CEP
	if($_POST['CEP_modelo'] <> $row_contrato['CEP_cc']){
		$cep_new = $_POST['CEP_modelo'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET CEP_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET CEP_cc = '$cpf_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "CEP_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['CEP_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['CEP_modelo']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO TELEFONE PRINCIPAL
	if($_POST['telefone_principal'] <> $row_contrato['telefone_residencial_cc']){
		$principal_new = $_POST['telefone_principal'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET telefone_residencial_cc = '$principal_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET telefone_residencial_cc = '$principal_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "telefone_residencial_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['telefone_residencial_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['telefone_principal']);
			$insertUpdate->execute();
	}else{

	}

	//VERIFICA SE HOUVE MODIFICAÇÃO TELEFONE SECUNDARIO
	if($_POST['telefone_secundario'] <> $row_contrato['telefone_celular_cc']){
		$secundario_new = $_POST['telefone_secundario'];
		if($unidade == 1){
			$update_contrato = "UPDATE clientes_exclusive SET telefone_celular_cc = '$secundario_new' WHERE contrato_cc = '$ncontrato'";
		}else if($unidade == 4){
			$update_contrato = "UPDATE clientes_concept SET telefone_celular_cc = '$secundario_new' WHERE contrato_cc = '$ncontrato'";
		}
		$exec_update = mysqli_query($conn, $update_contrato);
		//GRAVAR LOG DE MODIFICAÇÃO
		//GRAVAR LOG DE MODIFICAÇÃO
			$insertUpdate->bindValue(":ncontrato", $ncontrato);
			$insertUpdate->bindValue(":campoUpdate", "telefone_celular_cc");
			$insertUpdate->bindValue(":valorAnterior", $row_contrato['telefone_celular_cc']);
			$insertUpdate->bindValue(":valorNovo", $_POST['telefone_secundario']);
			$insertUpdate->execute();
	}else{

	}


	//DESTRÓI A GLOBAL DA SENHA DA GERÊNCIA
	echo "<script>
			window.close();
		</script>";
	

?>
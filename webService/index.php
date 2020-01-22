<?php
	require_once('xml.Class.php');
	include_once('../conection/connection.php');
	$pdo=conectar();


	$xml = new Xml();

	$erro = 0;

	$cpfCliente = $_GET['cpf'];

	$xml->openTag("response");

	if($cpfCliente == ''){
		$erro = 1;
		$msgerro = 'Codigo Invalido';
	}else{
		$selectContrato=$pdo->prepare("SELECT * FROM Clientes_exclusive WHERE cpf_modelo_cc=:cpfModelo");
		$selectContrato->bindValue(":cpfModelo", $cpfCliente, PDO::PARAM_INT);
		$selectContrato->execute();
		$qtdContrato=$selectContrato->rowCount();

		if($qtdContrato > 0){
			$rowContrato=$selectContrato->fetch(PDO::FETCH_OBJ);

			$xml->addTag('nomeCliente', $rowContrato->nome_modelo_cc);
			$xml->addTag('valorContrato', $rowContrato->valor_material_cc);
		}else{
			$erro = 2;
			$msgerro = "Cliente Não Encontrato";
		}
	}
	$xml->addTag('erro', $erro);
	$xml->addTag('msgerro', $msgerro);
	$xml->closeTag("response");

	echo $xml;







?>
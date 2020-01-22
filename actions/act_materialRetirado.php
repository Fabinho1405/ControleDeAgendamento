<?php
	session_start();
	ob_start();
	include_once("../conection/connection.php");
	$pdo=conectar();
	$idFuncionario = $_SESSION['id_usuario']; 
    $unidade = $_SESSION['unidade'];
	$nContrato=$_GET['ncontrato'];


	if($unidade == 1){
		//LOCALIZA O SETOR E DIMINUI A QUANTIDADE DE MATERIAL
		$selectSetor=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE contrato_cc=:nContrato");
		$selectSetor->bindValue(":nContrato", $nContrato, PDO::PARAM_INT);
		$selectSetor->execute();
		$rowSetor=$selectSetor->fetch(PDO::FETCH_OBJ);
		$setorContrato=$rowSetor->setor_cc;
		echo $setorContrato;

		$localizaSetor=$pdo->prepare("SELECT * FROM setores_exclusive WHERE descSetor=:setor");
		$localizaSetor->bindValue(":setor", $setorContrato);
		$localizaSetor->execute();
		$rowLocaliza=$localizaSetor->fetch(PDO::FETCH_OBJ);
		$qtdSetor=$rowLocaliza->qtdSetor;
		echo $qtdSetor;

		$qtdNova=$qtdSetor-1;
		echo "<br>".$qtdNova;

		$updateSetor=$pdo->prepare("UPDATE setores_exclusive SET qtdSetor=:novaQuantidade WHERE descSetor=:setor");
		$updateSetor->bindValue(":novaQuantidade", $qtdNova);
		$updateSetor->bindValue(":setor", $setorContrato);
		$updateSetor->execute();

		//UPDATE NO CONTRATO COMO RETIRADO E LIBERA O TERMO DE RETIRADA
		$updateContrato=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, liberado_termo=:liberado, data_retirada=NOW() WHERE contrato_cc=:nContrato");
		$updateContrato->bindValue(":status", 14, PDO::PARAM_INT);
		$updateContrato->bindValue(":liberado", 1, PDO::PARAM_INT);
		$updateContrato->bindValue(":nContrato", $nContrato, PDO::PARAM_INT);
		$updateContrato->execute();

		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Termo Liberado com Sucesso! Todas as Baixas Foram Realizadas.
                             </div>";
        header("Location:../filaMaterialRetirado.php");
	}else if($unidade == 4){
		//LOCALIZA O SETOR E DIMINUI A QUANTIDADE DE MATERIAL
		$selectSetor=$pdo->prepare("SELECT * FROM clientes_concept WHERE contrato_cc=:nContrato");
		$selectSetor->bindValue(":nContrato", $nContrato, PDO::PARAM_INT);
		$selectSetor->execute();
		$rowSetor=$selectSetor->fetch(PDO::FETCH_OBJ);
		$setorContrato=$rowSetor->setor_cc;
		echo $setorContrato;

		$localizaSetor=$pdo->prepare("SELECT * FROM setores_concept WHERE descSetor=:setor");
		$localizaSetor->bindValue(":setor", $setorContrato);
		$localizaSetor->execute();
		$rowLocaliza=$localizaSetor->fetch(PDO::FETCH_OBJ);
		$qtdSetor=$rowLocaliza->qtdSetor;
		echo $qtdSetor;

		$qtdNova=$qtdSetor-1;
		echo "<br>".$qtdNova;

		$updateSetor=$pdo->prepare("UPDATE setores_concept SET qtdSetor=:novaQuantidade WHERE descSetor=:setor");
		$updateSetor->bindValue(":novaQuantidade", $qtdNova);
		$updateSetor->bindValue(":setor", $setorContrato);
		$updateSetor->execute();

		//UPDATE NO CONTRATO COMO RETIRADO E LIBERA O TERMO DE RETIRADA
		$updateContrato=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, liberado_termo=:liberado, data_retirada=NOW() WHERE contrato_cc=:nContrato");
		$updateContrato->bindValue(":status", 14, PDO::PARAM_INT);
		$updateContrato->bindValue(":liberado", 1, PDO::PARAM_INT);
		$updateContrato->bindValue(":nContrato", $nContrato, PDO::PARAM_INT);
		$updateContrato->execute();

		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Termo Liberado com Sucesso! Todas as Baixas Foram Realizadas.
                             </div>";
        header("Location:../filaMaterialRetirado.php");
	}

	


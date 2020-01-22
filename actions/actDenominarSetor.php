<?php
	session_start();
	ob_start();
	include_once("../conection/connection.php");
	$pdo=conectar();

	$idFuncionario = $_SESSION['id_usuario'];
	$unidadeFunc = $_SESSION['unidade'];
	$nContrato=$_GET['ncontrato'];

	if($unidadeFunc==1){
		$verificaSetores=$pdo->prepare("SELECT * FROM setores_exclusive");
		$verificaSetores->execute();
		$listarSetores=$verificaSetores->fetchall(PDO::FETCH_OBJ);
		$totalSetores=$verificaSetores->rowCount();
		$i=1;
		$erro=0;
		$vetSetores=array();

		foreach($listarSetores as $rowSetor){
			if($rowSetor->qtdSetor < $rowSetor->qtdMaxSetor){
				//Troca Status do Material
				$setorMaterial=$pdo->prepare("UPDATE clientes_exclusive SET denominado_setor_cc=NOW(), setor_cc=:setor, status_cc=:status WHERE contrato_cc=:contrato");
				$setorMaterial->bindValue(":setor", $rowSetor->descSetor, PDO::PARAM_INT);
				$setorMaterial->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
				$setorMaterial->bindValue(":status", 13, PDO::PARAM_INT);
				$setorMaterial->execute();

				//Aumentar o número do Setor
				$quantidade=$rowSetor->qtdSetor + 1;
				$novaQuatidade=$pdo->prepare("UPDATE setores_exclusive SET qtdSetor=:quantidade WHERE descSetor=:descricao ");
				$novaQuatidade->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
				$novaQuatidade->bindValue(":descricao", $rowSetor->descSetor, PDO::PARAM_INT);
				$novaQuatidade->execute();

				$_SESSION['msgSetor']="<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'> Coloque o Material {$nContrato} no Setor {$rowSetor->descSetor} </div>";
				header("Location:../fila_de_retirada.php");
				break;
			}else{ 
				$erro = $erro + 1;
			}
		}

		if($erro == $totalSetores){ 
			$_SESSION['msgSetor']="<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show' role='alert'> ERRO NA LOCAÇÃO DE MATERIAL - Todos os setores estão cheios. </div>";
				header("Location:../fila_de_retirada.php");
		}else{

		}




	}elseif($unidadeFunc==4){
		$verificaSetores=$pdo->prepare("SELECT * FROM setores_concept");
		$verificaSetores->execute();
		$listarSetores=$verificaSetores->fetchall(PDO::FETCH_OBJ);
		$totalSetores=$verificaSetores->rowCount();
		$i=1;
		$erro=0;
		$vetSetores=array();

		foreach($listarSetores as $rowSetor){
			if($rowSetor->qtdSetor < $rowSetor->qtdMaxSetor){
				//Troca Status do Material
				$setorMaterial=$pdo->prepare("UPDATE clientes_concept SET denominado_setor_cc=NOW(), setor_cc=:setor, status_cc=:status WHERE contrato_cc=:contrato");
				$setorMaterial->bindValue(":setor", $rowSetor->descSetor, PDO::PARAM_INT);
				$setorMaterial->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
				$setorMaterial->bindValue(":status", 13, PDO::PARAM_INT);
				$setorMaterial->execute();

				//Aumentar o número do Setor
				$quantidade=$rowSetor->qtdSetor + 1;
				$novaQuatidade=$pdo->prepare("UPDATE setores_concept SET qtdSetor=:quantidade WHERE descSetor=:descricao ");
				$novaQuatidade->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
				$novaQuatidade->bindValue(":descricao", $rowSetor->descSetor, PDO::PARAM_INT);
				$novaQuatidade->execute();

				$_SESSION['msgSetor']="<div class='sufee-alert alert with-close alert-success alert-dismissible fade show' role='alert'> Coloque o Material {$nContrato} no Setor {$rowSetor->descSetor} </div>";
				header("Location:../fila_de_retirada.php");
				break;
			}else{ 
				$erro = $erro + 1;
			}
		}

		if($erro == $totalSetores){ 
			$_SESSION['msgSetor']="<div class='sufee-alert alert with-close alert-danger alert-dismissible fade show' role='alert'> ERRO NA LOCAÇÃO DE MATERIAL - Todos os setores estão cheios. </div>";
				header("Location:../fila_de_retirada.php");
		}else{

		}




	}






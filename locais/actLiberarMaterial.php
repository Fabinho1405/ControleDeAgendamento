<?php
	
	include_once("../conection/connection.php");
	$pdo=conectar();

	$nContrato=$_GET['nContrato'];

	$liberarMaterial=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status WHERE contrato_cc=:contrato");
	$liberarMaterial->bindValue(":status", 1, PDO::PARAM_INT);
	$liberarMaterial->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
	if($liberarMaterial->execute()){
		$motivoLog="Liberação";
		$descricaoLog="Material Liberado Pelo Sistema para Fila de Edição.";

		$insereLOG=$pdo->prepare("INSERT INTO log_producao_exclusive(contrato_cc, motivo_pd, descricao_pd, created_pd) VALUES(:contrato, :motivoPd, :descricaoPd, NOW())");
        $insereLOG->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
        $insereLOG->bindValue(":motivoPd", $motivoLog, PDO::PARAM_STR);
        $insereLOG->bindValue(":descricaoPd", $descricaoLog, PDO::PARAM_STR);
        if($insereLOG->execute()){
        	header("Location:ContratosRestringidosEX.php"); 
        }else{
        	echo "<h1>ERRO NO LOG </h1>";
        }
	}else{
		echo "<h1>ERRO</h1>";
	}
?>
<?php
	include_once("../conection/connection.php");
	$pdo=conectar();



	$pesquisarMateriaisEdicao=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE status_cc=:statusContrato");
	$pesquisarMateriaisEdicao->bindValue(":statusContrato", 1);
	$pesquisarMateriaisEdicao->execute();
	$linhaMateriais=$pesquisarMateriaisEdicao->fetchAll(PDO::FETCH_OBJ);


	


	foreach($linhaMateriais as $rowMateriais){
		$contrato=$rowMateriais->contrato_cc;
		$material=$rowMateriais->material_cc;
		//echo $rowMateriais->contrato_cc."-".$rowMateriais->material_cc."<br>";
		if(mkdir('X:\EDIÇÃO\SEPARADAS\++ ENVIOS SISTEMA ++\2020\29.01 - SISTEMA\ '.$contrato.'-'.$material.'')){
			echo "criada com sucesso - ".$contrato."<br />";
		}else{
			echo "já existe<br>";  
		}
	};

	


?>
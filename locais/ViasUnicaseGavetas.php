<?php
	include_once("../conection/connection.php");
	$pdo=conectar();

	$unidade=1;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Vias Únicas e Contratos Gavetas</title>
</head>
<body>
	<table border="1">
		<thead>
			<th> Contratos </th>
			<th> Nome do Modelo </th>
			<th> Nome do Responsável </th>
			<th> Telefone 1 </th>
			<th> Telefone 2 </th>
			<th> Valor Total </th>
			<th> % Quitada </th>
		</thead>
		<?php
			$pesquisarProdutores=$pdo->prepare("SELECT * FROM funcionario WHERE menu_produtor=:menuProdutor AND id_unidade=:unidadeProdutor ORDER BY nome_completo_func ASC");
			$pesquisarProdutores->bindValue(":menuProdutor", 1);
			$pesquisarProdutores->bindValue(":unidadeProdutor", $unidade);
			$pesquisarProdutores->execute();
			$linhaProdutores=$pesquisarProdutores->fetchall(PDO::FETCH_OBJ);

			foreach($linhaProdutores as $rowProdutores){
				$pesquisaContrato=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE id_produtor=:idProdutor ORDER BY contrato_cc ASC");
				$pesquisaContrato->bindValue(":idProdutor", $rowProdutores->id_func);
				$pesquisaContrato->execute();
				$linhaContratos=$pesquisaContrato->fetchall(PDO::FETCH_OBJ);
					foreach($linhaContratos as $rowContratos){
						echo $rowContratos->contrato_cc." - ".$rowProdutores->nome_completo_func."<br>";
					};
			};

		?>
	</table>



</body>
</html>
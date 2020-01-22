<?php
	 //CONEXAO COM BANCO
	include_once("../conection/connection.php");
	$pdo=conectar();	
	//DEFINE O PERÍODO DE PESQUISA
	$d1 = '2019-08-01';
	$d2 = '2019-09-26';
	$timestamp1 = strtotime( $d1 );
	$timestamp2 = strtotime( $d2 );

?>
<!DOCTYPE html>
<html>
<head>
	<title>Conferencia Mensal de Fechamento</title>
</head>
<body>
	<center>

<?php
		while ( $timestamp1 <= $timestamp2 )
		{ 
			$dataexibida = date('d/m/Y', $timestamp1);
			$datapesquisa = date('Y-m-d', $timestamp1);
			$timestamp1 += 86400;
?>
	<table border="1">
		<thead>
			<th colspan="20"><center>Data: <?php echo $dataexibida; ?></center></th>
		</thead>
<?php
		$selectContratosDia=$pdo->prepare("SELECT * FROM clientes_concept WHERE date(data_cadastro_cc)=:dataCadastro");
		$selectContratosDia->bindValue(":dataCadastro", $datapesquisa);
		$selectContratosDia->execute();
		$listaContratosDia=$selectContratosDia->fetchall(PDO::FETCH_OBJ);
		$totalCVC=0;
		$contratoAnt=0;
?>
		<tbody>
			<tr>
				<td>Contratos</td>
				<td>Nome Modelo</td>
				<td>Valor do Contrato</td>
				<td>F. Pagamento</td>
				<td>Valor Lançamento</td>
				<td>Status Pgto</td>
				<td>Status Sistema</td>

			</tr>
			
				
<?php
		foreach($listaContratosDia as $rowContrato){
?>
		<tr>
<?php
			$selectLancamentos=$pdo->prepare("SELECT * FROM lancamento_concept lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento WHERE n_contrato_lancamento=:nContrato AND date(data_baixa_lancamento)=:datapesquisa");
			$selectLancamentos->bindValue(":nContrato", $rowContrato->contrato_cc);
			$selectLancamentos->bindValue(":datapesquisa", $datapesquisa);
			$selectLancamentos->execute();
			$listaLancamento=$selectLancamentos->fetchall(PDO::FETCH_OBJ);

			foreach($listaLancamento as $rowLancamento){				
?>
				<td><?php if($contratoAnt <> $rowContrato->contrato_cc){echo $rowContrato->contrato_cc;}else{echo "";}; ?></td>
				<td><?php if($contratoAnt <> $rowContrato->contrato_cc){echo $rowContrato->nome_modelo_cc;}else{echo "";}; ?></td>
				<td><?php if($contratoAnt <> $rowContrato->contrato_cc){echo $rowContrato->valor_material_cc;}else{echo "";}; ?></td>
				<td><?php echo $rowLancamento->descricao_tp; ?></td>
				<td><?php echo $rowLancamento->valor_lancamento; ?></td>
				<td><?php echo $rowLancamento->descricao_status_lancamento; ?></td>
				<td><?php echo $rowLancamento->status; ?></td>				
			</tr>
<?php
			$contratoAnt=$rowContrato->contrato_cc;
			if($rowLancamento->status == 1){
				if($rowLancamento->tipo_pagamento_lancamento == 1){
					$totalCVC = $totalCVC + $rowLancamento->valor_lancamento;
				}else if($rowLancamento->tipo_pagamento_lancamento == 4){
					$totalCVC = $totalCVC + $rowLancamento->valor_lancamento;
				}else if($rowLancamento->tipo_pagamento_lancamento == 5){
					$totalCVC = $totalCVC + $rowLancamento->valor_lancamento;
				}else if($rowLancamento->tipo_pagamento_lancamento == 6){
					$totalCVC = $totalCVC + $rowLancamento->valor_lancamento;
				}
			}

			}
?>
		
		<tr>
			<td colspan="20"> .. </td>

		</tr>
<?php
			
		}
?>
		<tr>
			<td colspan="20">TOTAL CVC: <?php echo $totalCVC; ?></td>
		</tr>
		</tbody>
	</table>
	<br><br>

<?php
		}



?>

</center>

</body>
</html>
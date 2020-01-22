<!DOCTYPE html>
<html>
<head>
	<title>Contratos em Aberto</title>
</head>
<body>
	<?php	
		include_once("../conection/connection.php");
		$pdo=conectar();


		
		try{
			//Verifica Contratos em Aberto
			$contratosAbertos=$pdo->prepare("SELECT * FROM clientes_exclusive ce INNER JOIN status_contrato sc ON ce.status_cc = sc.id_sc INNER JOIN funcionario func ON ce.id_produtor = func.id_func WHERE ce.status_cc IN('2','3','4','5') ORDER BY ce.data_cadastro_cc, func.nome_completo_func ASC");
			$contratosAbertos->execute();
			$qtdContratosAbertos=$contratosAbertos->rowCount();
			$linhaContratosAbertos=$contratosAbertos->fetchall(PDO::FETCH_OBJ); 

		}catch(Exception $e){
			echo $e->getMessage();
		}

		
		
	?>
	<center>

		<fieldset>
			<?php
				echo "Contratos com Restrição: ".$qtdContratosAbertos;
			?>
		<table>
			<thead> 
				<th style="border-bottom: 1px solid black"><center>Contrato</center></th>
				<th style="border-bottom: 1px solid black"><center>Nome Modelo</center></th>
				<th style="border-bottom: 1px solid black"><center>Nome Responsável</center></th>
				<th style="border-bottom: 1px solid black"><center>Telefone 1</center></th>
				<th style="border-bottom: 1px solid black"><center>Telefone 2</center></th>
				<th style="border-bottom: 1px solid black"><center>Data de Fechamento</center></th>
				<th style="border-bottom: 1px solid black"><center>Produtor</center></th>
				<th style="border-bottom: 1px solid black"><center>Material</center></th>
				<th style="border-bottom: 1px solid black"><center>Status</center></th>
				<th style="border-bottom: 1px solid black"><center>Valor do Contrato</center></th>
				<th style="border-bottom: 1px solid black"><center>Valor Pago</center></th>
				<th style="border-bottom: 1px solid black"><center>Porcentagem</center></th>
				<th style="border-bottom: 1px solid black"><center>Interno</center></th>
				<th style="border-bottom: 1px solid black"><center>Liberado?</center></th>
				<th style="border-bottom: 1px solid black"><center>Ação</center></th>

			</thead>
		<?php


			foreach($linhaContratosAbertos as $rowContratos){
				$nContrato=$rowContratos->contrato_cc;
		?>
			<tbody>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->contrato_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->nome_modelo_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->nome_responsavel_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->telefone_residencial_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->telefone_celular_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo date("d/m/Y", strtotime($rowContratos->data_cadastro_cc))?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->nome_completo_func; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->material_cc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo $rowContratos->descricao_sc; ?></td>
				<td style="border-right: 1px solid black;"><?php echo "R$".number_format($rowContratos->valor_material_cc,2,',','.'); ?></td>
		<?php
				//Verifica Valor Pago
				try{
					$valorPago=$pdo->prepare("SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento=:contrato AND status_lancamento=:statusLancamento AND status=:status");
					$valorPago->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
					$valorPago->bindValue(":statusLancamento", 2, PDO::PARAM_INT);
					$valorPago->bindValue(":status", 1, PDO::PARAM_INT);
					$valorPago->execute();
					$linhaValorPago=$valorPago->fetchall(PDO::FETCH_OBJ);
					$totalPago=0;
					foreach($linhaValorPago as $rowPago){
						$totalPago+=$rowPago->valor_lancamento;
					};
		?>
					<td style="border-right: 1px solid black;"><?php echo "R$".number_format($totalPago,2,',','.'); ?></td>
		<?php
				if($totalPago == 0){
					$porcentagem=0;
				}else{
				$porcentagem = ($totalPago * 100) / $rowContratos->valor_material_cc;
				}
		?>

					<td style="border-right: 1px solid black;"><?php 
						if($porcentagem == 0){
							echo "0%";
						}else{
						echo round($porcentagem, 2)."%"; 
						}

					?></td>
					<td style="border-right: 1px solid black;"><?php if($totalPago > 0){echo "<font color='green'><b>  </b></font>";}else{echo "<font color='red'><b> GVT </b></font> ";} ?></td>
					<td style="border-right: 1px solid black;"><?php if($porcentagem >= 40){echo "<font color='green'><b> Sim </b></font>";}else{echo "<font color='red'> Não </font> ";} ?></td>
					<td><?php if($porcentagem >= 40){?><a href="actLiberarMaterial.php?nContrato=<?php echo $nContrato; ?>">Liberar Material</a><?php }else{echo "<font color='red'> Não </font> ";} ?></td>
		<?php
				}catch(Exception $e){
					echo $e->getMessage();
				}
		?>
			</tbody>

		<?php
			};
		?>
		</table>
		</fieldset>
		<br />
	


		 <fieldset>
			<?php
				try{
					$contratosAguardando=$pdo->prepare("SELECT * FROM clientes_exclusive ce INNER JOIN funcionario func ON ce.id_produtor = func.id_func WHERE ce.status_cc = 12");
					$contratosAguardando->execute();
					$qtdContratosAguardando=$contratosAguardando->rowCount();
					$linhaContratosAguardando=$contratosAguardando->fetchall(PDO::FETCH_OBJ);
				}catch(Exception $e){
					echo $e->getMessage();
				}

			?>
			<?php
				echo "Contratos Aguardando Liberação: ".$qtdContratosAguardando;
			?>
			<table>
				<thead>
					<th style="border-bottom: 1px solid black"> Contrato </th>
					<th style="border-bottom: 1px solid black"> Material </th>
					<th style="border-bottom: 1px solid black"> Data de Fechamento </th>
					<th style="border-bottom: 1px solid black"> Modelo </th>
					<th style="border-bottom: 1px solid black"> Responsável </th>
					<th style="border-bottom: 1px solid black"> Produtor </th>
					<th style="border-bottom: 1px solid black"> Valor do Material </th>
					<th style="border-bottom: 1px solid black"> Valor Pago </th>
					<th style="border-bottom: 1px solid black"> Interno </th>
				</thead>
			<?php
				foreach($linhaContratosAguardando as $rowContratoAguardando){
					$nContrato=$rowContratoAguardando->contrato_cc;
			?>
				<tbody>
					<td style="border-right: 1px solid black;"><?php echo $rowContratoAguardando->contrato_cc ?> </td>
					<td style="border-right: 1px solid black;"><?php echo $rowContratoAguardando->material_cc; ?></td>
					<td style="border-right: 1px solid black;"><?php echo date("d/m/Y", strtotime($rowContratoAguardando->data_cadastro_cc)); ?></td>
					<td style="border-right: 1px solid black;"><?php echo $rowContratoAguardando->nome_modelo_cc; ?></td>
					<td style="border-right: 1px solid black;"><?php if(!empty($rowContratoAguardando->nome_responsavel_cc)){echo $rowContratoAguardando->nome_responsavel_cc;}else{echo "o mesmo(a)";} ?></td>
					<td style="border-right: 1px solid black;"><?php echo $rowContratoAguardando->nome_completo_func; ?></td>
					<td style="border-right: 1px solid black;"><?php echo "R$".number_format($rowContratoAguardando->valor_material_cc,2,',','.'); ?></td>	
			<?php
				//Verifica Valor Pago
				try{
					$valorPago=$pdo->prepare("SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento=:contrato AND status_lancamento=:statusLancamento AND status=:status");
					$valorPago->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
					$valorPago->bindValue(":statusLancamento", 2, PDO::PARAM_INT);
					$valorPago->bindValue(":status", 1, PDO::PARAM_INT);
					$valorPago->execute();
					$linhaValorPago=$valorPago->fetchall(PDO::FETCH_OBJ);
					$totalPago=0;
					foreach($linhaValorPago as $rowPago){
						$totalPago+=$rowPago->valor_lancamento;
					};
				}catch(Exception $e){
					echo $e->getMessage();
				}
			?>
				<td style="border-right: 1px solid black;"><?php echo "R$".number_format($totalPago,2,',','.'); ?></td>
				<td><?php if($totalPago > 0){echo "<font color='green'><b>  </b></font>";}else{echo "<font color='red'><b> GVT </b></font> ";} ?></td>				
				</tbody>			
			<?php
				};
			?>
			</table>



		</fieldset>

	</center>
</body>
</html>


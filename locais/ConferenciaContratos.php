<!DOCTYPE html>
<html>
<head>
	<title>Conferência de Contratos</title>
</head>
<body>
	<?php

		include("../conection/connection.php");

		$d1 = $_GET['d1'];
		$d2 = $_GET['d2'];

		$timestamp1 = strtotime( $d1 );
		$timestamp2 = strtotime( $d2 );

		?>

		
		<table border="1">
			<thead>
				<th> Fechamento </th>
				<th> Contrato </th>
				<th> E / F </th>
				<th> RF </th>
				<th> Status Atual</th>
			</thead>
			<tbody>				
				
				


		<?php
		while ( $timestamp1 <= $timestamp2 )
						{
							$pdo=conectar();
							$dataexibida = date('d/m/Y', $timestamp1);
							$datapesquisa = date('Y-m-d', $timestamp1);

							//Pesquisar Contratos do Dia
							$contratosDia=$pdo->prepare("SELECT * FROM clientes_exclusive ce INNER JOIN status_contrato sc ON ce.status_cc = sc.id_sc WHERE date(ce.data_cadastro_cc) = :dataP AND ce.status_cc <> 6");
							$contratosDia->bindValue(":dataP", $datapesquisa);
							$contratosDia->execute();
							$linhaContratosDia = $contratosDia->fetchAll(PDO::FETCH_OBJ);
							
							foreach($linhaContratosDia as $rowContrato){
								$numeroContrato = $rowContrato->contrato_cc;

							//Pesquisa envio para estúdio
							$enviadoEstudio=$pdo->prepare("SELECT * FROM estudio_exclusive WHERE contrato_cc=:nContrato AND id_ts = 0 ORDER BY date(created) DESC LIMIT 1");
							$enviadoEstudio->bindValue(":nContrato", $numeroContrato);
							$enviadoEstudio->execute();

							$qtdEnviadoEstudio=$enviadoEstudio->rowCount();
							$linhaEnviadoEstudio=$enviadoEstudio->fetch(PDO::FETCH_OBJ);
							
							if($qtdEnviadoEstudio >= 1){
								$confirmacaoEstudio=1;
								$bgSquare="OK";
							}else{
								$confirmacaoEstudio=0;
								$bgSquare="██";
							};

							if($confirmacaoEstudio == 1){
								if($linhaEnviadoEstudio->atendimento_finalizado == 1){
									$bgEst = "OK";
									
									if($linhaEnviadoEstudio->marcou_retorno_ec == 1){
										$resumoFinal="Ret.";
									}else{
										
									};

									if($linhaEnviadoEstudio->enviado_analise_ec == 1){
										$resumoFinal="Fin.";
									}else{
									
									};

									if($linhaEnviadoEstudio->sem_info_ec == 1){
										$resumoFinal="S/Info.";
									}else{

									};

								}else{
									$bgEst = "██";
									$resumoFinal="Est.";
								};
							}else{
								$bgEst="██";
								$resumoFinal="";
							}




							echo "<tr>";
							echo "<td>".date("d/m/Y",strtotime($rowContrato->data_cadastro_cc))."</td>";
							echo "<td>".$rowContrato->contrato_cc."</td>";
							echo "<td>[".$bgSquare."] [".$bgEst."]</td>";
							echo "<td>".$resumoFinal."</td>";
							echo "<td>".$rowContrato->descricao_sc."</td>";
							echo "</tr>";
							};							
							$timestamp1 += 86400;
						}			
	?>
			
			</tbody>
		</table>
		
</body>
</html>
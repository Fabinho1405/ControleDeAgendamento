<!DOCTYPE>
<html>
<head>
	<title>Relatório Individual</title>
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
	  <link rel="stylesheet" href="../painel/assets/css/bootstrap.min.css"> 
</head>
<body>
	<fieldset>
		<legend> Informações do Scouter</legend>
	<?php
		include_once("../conection/conexao.php");
		$d1 = $_GET['d1'];
		$d2 = $_GET['d2'];

		$select_producao = "SELECT * FROM funcionario WHERE linha_producao = '0' AND status_sistema='1' AND id_unidade='1' AND menu_scouter_insta = '1' ";
		$exec_producao = mysqli_query($conn, $select_producao);
		while($row_producao = mysqli_fetch_assoc($exec_producao)){

		$idfuncionario = $row_producao['id_func'];
		$timestamp1 = strtotime( $d1 );
		$timestamp2 = strtotime( $d2 );
		$cont = 1;

		$pesquisar_funcionario = "SELECT * FROM funcionario WHERE id_func='$idfuncionario'";
		$exec_pesquisar_funcionario = mysqli_query($conn, $pesquisar_funcionario);
		$row_func = mysqli_fetch_assoc($exec_pesquisar_funcionario);
	?>	
		<center>
			<table border="0">
				<tr>
					<td>Identificação do Usuário: </td>
					<td><?php echo $row_func['id_func']; ?></td>
				</tr>
				<tr>
					<td>Nome Completo do Funcionário: </td>
					<td><?php echo $row_func['nome_completo_func']; ?> </td>
				</tr>
				<tr>
					<td>Período do Relatório:</td>
					<td><?php echo date('d/m/Y', $timestamp1)." à ".date('d/m/Y',$timestamp2); ?></td>
				</tr>
			</table>
		</center>
		</fieldset>
		<br>
		<?php 
			//VERIFICA SE O FUNCIONARIO PERTENCE AO INSTAGRAM
			if($row_func['menu_scouter_insta'] == 1){
		?>
		<!-- INICIO DO RELATORIO DE INSTAGRAM -->
		<fieldset>
			<legend>Informações Referente à Agendamentos na Modalidade de Instagram</legend>
			<center>
				<table border="1">
					<thead>
						<th colspan="10">Quantidade de Agendados do Período</th>
					</thead>
					<?php
						$select_total_periodo_concept = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept = mysqli_query($conn, $select_total_periodo_concept);
						$qtd_total_periodo_concept = mysqli_num_rows($exec_select_total_periodo_concept);

						$select_total_periodo_concept_apvd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '2' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_apvd = mysqli_query($conn, $select_total_periodo_concept_apvd);
						$qtd_total_periodo_concept_apvd = mysqli_num_rows($exec_select_total_periodo_concept_apvd);

						$select_total_periodo_concept_ngd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '3' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_ngd = mysqli_query($conn, $select_total_periodo_concept_ngd);
						$qtd_total_periodo_concept_ngd = mysqli_num_rows($exec_select_total_periodo_concept_ngd);

						$select_total_periodo_concept_psc = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_comparecimento = '1' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_psc = mysqli_query($conn, $select_total_periodo_concept_psc);
						$qtd_total_periodo_concept_psc = mysqli_num_rows($exec_select_total_periodo_concept_psc);

						$select_total_periodo_concept_rean = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '4' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_rean = mysqli_query($conn, $select_total_periodo_concept_rean);
						$qtd_total_periodo_concept_rean = mysqli_num_rows($exec_select_total_periodo_concept_rean);

						$select_total_periodo_matriz = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz = mysqli_query($conn, $select_total_periodo_matriz);
						$qtd_total_periodo_matriz = mysqli_num_rows($exec_select_total_periodo_matriz);

						$select_total_periodo_matriz_apvd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '2' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_apvd = mysqli_query($conn, $select_total_periodo_matriz_apvd);
						$qtd_total_periodo_matriz_apvd = mysqli_num_rows($exec_select_total_periodo_matriz_apvd);

						$select_total_periodo_matriz_ngd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '3' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_ngd = mysqli_query($conn, $select_total_periodo_matriz_ngd);
						$qtd_total_periodo_matriz_ngd = mysqli_num_rows($exec_select_total_periodo_matriz_ngd);

						$select_total_periodo_matriz_psc = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_comparecimento = '1' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_psc = mysqli_query($conn, $select_total_periodo_matriz_psc);
						$qtd_total_periodo_matriz_psc = mysqli_num_rows($exec_select_total_periodo_matriz_psc);

						$select_total_periodo_matriz_rean = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '4' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_rean = mysqli_query($conn, $select_total_periodo_matriz_rean);
						$qtd_total_periodo_matriz_rean = mysqli_num_rows($exec_select_total_periodo_matriz_rean);

					?>
					<tbody>
						<tr>
							<td>-</td>
							<td>Total</td>
							<td>Aprovados</td>
							<td>Aguardando Re-Análise</td>
							<td>Negados</td>
							<td>Comparecidos</td>
						</tr>
						<tr>
							<td>Concept</td>
							<td><?php echo $qtd_total_periodo_concept; ?></td>
							<td><?php echo $qtd_total_periodo_concept_apvd; ?></td>
							<td><?php echo $qtd_total_periodo_concept_rean; ?></td>
							<td><?php echo $qtd_total_periodo_concept_ngd; ?></td>
							<td><?php echo $qtd_total_periodo_concept_psc; ?></td>
						</tr>
						<tr>
							<td>Exclusive</td>
							<td><?php echo $qtd_total_periodo_matriz; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_apvd; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_rean; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_ngd; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_psc; ?></td>
						</tr>
					</tbody>
				</table>
			</center>
		<br>
		<center>
			<table border="1" style="width: 1200px;">
				<thead>
					<th colspan="10"> Agendamentos Negados </th>
				</thead>
				<tbody>
					
					<?php
					$select_negados = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND id_status_auditoria = '3' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2' ORDER BY aut_re_analise_auditoria ASC";
					$exec_select_negados = mysqli_query($conn, $select_negados);
					$qtd_select_negados = mysqli_num_rows($exec_select_negados);
					if($qtd_select_negados > 0){
						?>
					<tr>
						<td><b><center> ID Agendamento </center></b></td>
						<td><b><center> Motivo </center></b></td>
						<td><b><center> Aut. Re-Análise </center></b></td>
						<td style="width: 400px"><b><center> Réplica </center></b></td>
						<td><b><center> Qtd. Retorno </center></b></td>
						<td style="width: 150px"><b><center> Dta. Cadastro </center></b></td>
					</tr>
					<?php
					while($row_negados = mysqli_fetch_assoc($exec_select_negados)){
					?>
					<tr>
						<td><?php echo $row_negados['id_agendamentos']; ?></td>
						<td><?php echo $row_negados['motivo_reprovacao_auditoria']; ?></td>						
						<td><?php if($row_negados['aut_re_analise_auditoria'] == 0){echo "Não";}else{echo "Sim";}; ?></td>
						<td><?php echo $row_negados['motivo_reanalise_auditoria']; ?></td>
						<td><?php echo $row_negados['qtd_re_analise_auditoria']." Vezes"; ?></td>
						<td><?php echo $row_negados['data_cadastro_agendamento']; ?></td>
					</tr>
					<?php
						};
					}else{
					?>
						<tr>
							<td colspan="10"><center>Não há nenhum agendado pendente no período. Parabéns :)</center></td>
						</tr>
					<?php
					}
					?>
				</tbody>				
			</table>
		</center>		
	<br>
	<center>
		<table border="1">
			<thead>
				<th colspan="10"> Especificação Geral do Período </th>
			</thead>
			<tbody>
				<tr>
					<td>Data<font color="red">*</font></td>
					<td>Agendados <b>na</b> Data<font color="red">**</font></td>
					<td>Aprovados pela Auditoria</td>
					<td>Em Re-Análise</td>
					<td>Reprovado</td>
					<td>Agendados <b>para</b> a Data<font color="red">***</font></td>
					<td>Confirmados<font color="red">****</font></td>
					<td>Comparecimentos<font color="red">*****</font></td>
					<td>% de Aproveitamento<font color="red">******</font></td>
					<td>Pontuação<font color="red">*******</font></td>
				</tr>
				<?php	
				$timestamp1 = strtotime( $d1 );
				$timestamp2 = strtotime( $d2 );
				$total_pontuacao = 0;
				$total_agendados_na_data = 0;
				$total_prod = 0;
				$final = 0;
				$cont = 1;
					while ( $timestamp1 <= $timestamp2 )
						{ 
							$dataexibida = date('d/m/Y', $timestamp1);
							$datapesquisa = date('Y-m-d', $timestamp1);
						$select_clientes_na_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND date(data_cadastro_agendamento) = '$datapesquisa'";
						$exec_select_clientes_na_data = mysqli_query($conn, $select_clientes_na_data);
						$qtd_select_clientes_na_data = mysqli_num_rows($exec_select_clientes_na_data);

						$select_clientes_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND data_agendada_agendamento = '$datapesquisa'";
						$exec_select_clientes_para_data = mysqli_query($conn, $select_clientes_para_data);
						$qtd_select_clientes_para_data = mysqli_num_rows($exec_select_clientes_para_data);

						$select_clientes_conf_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND data_agendada_agendamento = '$datapesquisa' AND confirmado = '1'";
						$exec_select_clientes_conf_para_data = mysqli_query($conn, $select_clientes_conf_para_data);
						$qtd_select_clientes_conf_para_data = mysqli_num_rows($exec_select_clientes_conf_para_data);

						$select_clientes_comp_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND data_agendada_agendamento = '$datapesquisa' AND id_comparecimento = '1'";
						$exec_select_clientes_comp_para_data = mysqli_query($conn, $select_clientes_comp_para_data);
						$qtd_select_clientes_comp_para_data = mysqli_num_rows($exec_select_clientes_comp_para_data);

						$select_clientes_na_data_boni = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND date(data_cadastro_agendamento) = '$datapesquisa' AND id_status_auditoria = '2'";
						$exec_select_clientes_na_data_boni = mysqli_query($conn, $select_clientes_na_data_boni);
						$qtd_select_clientes_na_data_boni = mysqli_num_rows($exec_select_clientes_na_data_boni);

						$select_clientes_na_data_reana = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND date(data_cadastro_agendamento) = '$datapesquisa' AND id_status_auditoria = '4'";
						$exec_select_clientes_na_data_reana = mysqli_query($conn, $select_clientes_na_data_reana);
						$qtd_select_clientes_na_data_reana = mysqli_num_rows($exec_select_clientes_na_data_reana);

						$select_clientes_na_data_rpv = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '1' AND date(data_cadastro_agendamento) = '$datapesquisa' AND id_status_auditoria = '3'";
						$exec_select_clientes_na_data_rpv = mysqli_query($conn, $select_clientes_na_data_rpv);
						$qtd_select_clientes_na_data_rpv = mysqli_num_rows($exec_select_clientes_na_data_rpv);





				?>
					<tr>
						<td><?php echo $dataexibida; ?></td>
						<td><?php echo $qtd_select_clientes_na_data; ?></td>
						<td><?php echo $qtd_select_clientes_na_data_boni; ?></td>
						<td><?php echo $qtd_select_clientes_na_data_reana; ?></td>
						<td><?php echo $qtd_select_clientes_na_data_rpv; ?></td>
						<td><?php echo $qtd_select_clientes_para_data; ?></td>
						<td><?php echo $qtd_select_clientes_conf_para_data; ?></td>
						<td><?php echo $qtd_select_clientes_comp_para_data; ?> </td>
						<td>0 </td>
						<td> 
							<?php
									$agendados = $qtd_select_clientes_na_data_boni;
							if($agendados <= 25){
								echo "0 pontos";
								$final = 0;
							}else if($agendados > 25 && $agendados <= 30){
								$pontos = ($agendados-25) * 1.50;
								echo "".$pontos." pontos ";
								$final = $pontos;
							}else if($agendados > 30 && $agendados <= 40){
								$bon_anterior = 7.50;
								$pontos = ($agendados - 30) * 2.50;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}else if($agendados > 40 && $agendados <= 50){
								$bon_anterior = 32.50;
								$pontos = ($agendados - 40) * 3.50;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}else if($agendados > 50){
								$bon_anterior = 67.50;
								$pontos = ($agendados - 50) * 5.00;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}
								?>
								<?php
									$agend_prod = $qtd_select_clientes_na_data_boni * 2.50;
									echo " -- ".$agend_prod;
								?>
						</td>
					</tr>					
				<?php					
					$total_pontuacao = $total_pontuacao + $final;
					$total_prod = $total_prod + $agend_prod;
					$total_agendados_na_data = $total_agendados_na_data + $qtd_select_clientes_na_data;
					$timestamp1 += 86400;
					$cont++;
					};	
				?>
				<tr>
						<td><b>TOTAL:</b></td>
						<td><?php echo $total_agendados_na_data; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_pontuacao." pontos -- ".$total_prod; ?></td>
					</tr>
			</tbody>
		</table>
		<small><font color="red">*</font>: Data a qual está sendo tratado o parâmetro.</small><br>
		<small><font color="red">**</font>: Clientes que foram cadastrados no sistema no dia da data ao lado.</small><br>
		<small><font color="red">***</font>: Clientes que foram agendados no sistema para a data ao lado.</small><br>
		<small><font color="red">****</font>: Clientes confirmados que estavam agendados no sistema para a data ao lado.</small>
	</center>
</fieldset>
<!-- FIM DO RELATORIO DO INSTAGRAM -->
<?php
	}else{

	};
	if($row_func['menu_scouter_ligacao_new'] == 1){	
?>

<!-- INICIO DO RELATORIO DE LIGAÇÃO -->
<fieldset>
			<legend>Informações Referente à Agendamentos na Modalidade de Ligação</legend>
			<center>
				<table border="1">
					<thead>
						<th colspan="10">Quantidade de Agendados do Período</th>
					</thead>
					<?php
						$select_total_periodo_concept = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept = mysqli_query($conn, $select_total_periodo_concept);
						$qtd_total_periodo_concept = mysqli_num_rows($exec_select_total_periodo_concept);

						$select_total_periodo_concept_apvd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_status_auditoria = '2' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_apvd = mysqli_query($conn, $select_total_periodo_concept_apvd);
						$qtd_total_periodo_concept_apvd = mysqli_num_rows($exec_select_total_periodo_concept_apvd);

						$select_total_periodo_concept_ngd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_status_auditoria = '3' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_ngd = mysqli_query($conn, $select_total_periodo_concept_ngd);
						$qtd_total_periodo_concept_ngd = mysqli_num_rows($exec_select_total_periodo_concept_ngd);

						$select_total_periodo_concept_psc = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_comparecimento = '1' AND id_unidade = '4' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_concept_psc = mysqli_query($conn, $select_total_periodo_concept_psc);
						$qtd_total_periodo_concept_psc = mysqli_num_rows($exec_select_total_periodo_concept_psc);

						$select_total_periodo_matriz = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz = mysqli_query($conn, $select_total_periodo_matriz);
						$qtd_total_periodo_matriz = mysqli_num_rows($exec_select_total_periodo_matriz);

						$select_total_periodo_matriz_apvd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_status_auditoria = '2' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_apvd = mysqli_query($conn, $select_total_periodo_matriz_apvd);
						$qtd_total_periodo_matriz_apvd = mysqli_num_rows($exec_select_total_periodo_matriz_apvd);

						$select_total_periodo_matriz_ngd = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_status_auditoria = '3' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_ngd = mysqli_query($conn, $select_total_periodo_matriz_ngd);
						$qtd_total_periodo_matriz_ngd = mysqli_num_rows($exec_select_total_periodo_matriz_ngd);

						$select_total_periodo_matriz_psc = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND id_comparecimento = '1' AND id_unidade = '1' AND date(data_cadastro_agendamento) BETWEEN '$d1' AND '$d2'";
						$exec_select_total_periodo_matriz_psc = mysqli_query($conn, $select_total_periodo_matriz_psc);
						$qtd_total_periodo_matriz_psc = mysqli_num_rows($exec_select_total_periodo_matriz_psc);

					?>
					<tbody>
						<tr>
							<td>-</td>
							<td>Total</td>
							<td>Aprovados</td>
							<td>Negados</td>
							<td>Comparecidos</td>
						</tr>
						<tr>
							<td>Concept</td>
							<td><?php echo $qtd_total_periodo_concept; ?></td>
							<td><?php echo $qtd_total_periodo_concept_apvd; ?></td>
							<td><?php echo $qtd_total_periodo_concept_ngd; ?></td>
							<td><?php echo $qtd_total_periodo_concept_psc; ?></td>
						</tr>
						<tr>
							<td>Exclusive</td>
							<td><?php echo $qtd_total_periodo_matriz; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_apvd; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_ngd; ?></td>
							<td><?php echo $qtd_total_periodo_matriz_psc; ?></td>
						</tr>
					</tbody>
				</table>
			</center>
		<br>		
		<center>
		<table border="1">
			<thead>
				<th colspan="10"> Especificação Geral do Período </th>
			</thead>
			<tbody>
				<tr>
					<td>Data<font color="red">*</font></td>
					<td>Fichas Liberadas <b>na</b> Data </td>
					<td>Agendados <b>na</b> Data<font color="red">**</font></td>
					<td>Aprovados pela Auditoria</td>
					<td>Agendados <b>para</b> a Data<font color="red">***</font></td>
					<td>Confirmados<font color="red">****</font></td>
					<td>Comparecimentos<font color="red">*****</font></td>
					<td>% de Aproveitamento<font color="red">******</font></td>
					<td>Pontuação<font color="red">*******</font></td>
				</tr>
				<?php	
				$timestamp1 = strtotime( $d1 );
				$timestamp2 = strtotime( $d2 );
				$total_pontuacao = 0;
				$total_prod = 0;
				$final = 0;
				$cont = 1;
					while ( $timestamp1 <= $timestamp2 )
						{ 
							$dataexibida = date('d/m/Y', $timestamp1);
							$datapesquisa = date('Y-m-d', $timestamp1);
						$select_clientes_na_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND date(data_cadastro_agendamento) = '$datapesquisa'";
						$exec_select_clientes_na_data = mysqli_query($conn, $select_clientes_na_data);
						$qtd_select_clientes_na_data = mysqli_num_rows($exec_select_clientes_na_data);

						$select_clientes_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND data_agendada_agendamento = '$datapesquisa'";
						$exec_select_clientes_para_data = mysqli_query($conn, $select_clientes_para_data);
						$qtd_select_clientes_para_data = mysqli_num_rows($exec_select_clientes_para_data);

						$select_clientes_conf_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND data_agendada_agendamento = '$datapesquisa' AND confirmado = '1'";
						$exec_select_clientes_conf_para_data = mysqli_query($conn, $select_clientes_conf_para_data);
						$qtd_select_clientes_conf_para_data = mysqli_num_rows($exec_select_clientes_conf_para_data);

						$select_clientes_comp_para_data = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND data_agendada_agendamento = '$datapesquisa' AND id_comparecimento = '1'";
						$exec_select_clientes_comp_para_data = mysqli_query($conn, $select_clientes_comp_para_data);
						$qtd_select_clientes_comp_para_data = mysqli_num_rows($exec_select_clientes_comp_para_data);

						$select_clientes_na_data_boni = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND id_meio_captado = '3' AND date(data_cadastro_agendamento) = '$datapesquisa' AND id_status_auditoria = '2'";
						$exec_select_clientes_na_data_boni = mysqli_query($conn, $select_clientes_na_data_boni);
						$qtd_select_clientes_na_data_boni = mysqli_num_rows($exec_select_clientes_na_data_boni);

						$select_fichas_liberadas_na_data = "SELECT * FROM controle_ligacao WHERE date(created) = '$datapesquisa' AND id_func = '$idfuncionario'";
						$exec_select_fichas_liberadas_na_data = mysqli_query($conn, $select_fichas_liberadas_na_data);
						$qtd_fichas_liberadas_na_data = mysqli_num_rows($exec_select_fichas_liberadas_na_data);



				?>
					<tr>
						<td><?php echo $dataexibida; ?></td>
						<td><?php echo $qtd_fichas_liberadas_na_data; ?></td>
						<td><?php echo $qtd_select_clientes_na_data; ?></td>
						<td><?php echo $qtd_select_clientes_na_data_boni; ?></td>
						<td><?php echo $qtd_select_clientes_para_data; ?></td>
						<td><?php echo $qtd_select_clientes_conf_para_data; ?></td>
						<td><?php echo $qtd_select_clientes_comp_para_data; ?> </td>
						<td>0 </td>
						<td> 
							<?php
									$agendados = $qtd_select_clientes_na_data_boni;
							if($agendados <= 35){
								echo "0 pontos";
								$final = 0;
							}else if($agendados > 35 && $agendados <= 40){
								$pontos = ($agendados-25) * 1.50;
								echo "".$pontos." pontos ";
								$final = $pontos;
							}else if($agendados > 40 && $agendados <= 50){
								$bon_anterior = 7.50;
								$pontos = ($agendados - 30) * 2.50;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}else if($agendados > 50 && $agendados <= 60){
								$bon_anterior = 32.50;
								$pontos = ($agendados - 40) * 3.50;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}else if($agendados > 60){
								$bon_anterior = 67.50;
								$pontos = ($agendados - 50) * 5.00;
								$final = $pontos + $bon_anterior;
								echo "".$final." pontos";
							}
								?>
								<?php
									$agend_prod = $qtd_select_clientes_na_data_boni * 2.50;
									echo " -- ".$agend_prod;
								?>
						</td>
					</tr>					
				<?php					
					$total_pontuacao = $total_pontuacao + $final;
					$total_prod = $total_prod + $agend_prod;
					$timestamp1 += 86400;
					$cont++;
					};	
				?>
				<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?php echo $total_pontuacao." pontos" ?></td>
					</tr>
			</tbody>
		</table>
		<small><font color="red">*</font>: Data a qual está sendo tratado o parâmetro.</small><br>
		<small><font color="red">**</font>: Clientes que foram cadastrados no sistema no dia da data ao lado.</small><br>
		<small><font color="red">***</font>: Clientes que foram agendados no sistema para a data ao lado.</small><br>
		<small><font color="red">****</font>: Clientes confirmados que estavam agendados no sistema para a data ao lado.</small>
		
	</center>

	
</fieldset>
<!-- FIM DO RELATORIO DE LIGAÇÃO -->
<?php
	}else{

	};

};
?>




	

	
</body>
</html>



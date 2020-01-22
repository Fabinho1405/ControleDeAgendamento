<?php
	include_once("../../conection/connection.php");
	$pdo=conectar();

	

	$dataInicial=$_GET['inicial'];
	$dataFinal=$_GET['final'];
	
	$GETfunc=$_GET['func'];
	$formaCaptacao=$_GET['captacao']; // 1- Insta / 2- Whats / 3- Ligação / 4- Facebook
	$unidade=$_GET['unidade']; // 1- Matriz / 4- Concept

	//Pesquisa Scouter's Ativos

	if($formaCaptacao == 1){
		$scoutersAtivos=$pdo->prepare("SELECT * FROM funcionario WHERE status_sistema=1 AND id_unidade=:unidade AND menu_scouter_insta=1");
		$relatorioSolicitado="Instagram";
	}elseif($formaCaptacao == 2){
		$scoutersAtivos=$pdo->prepare("SELECT * FROM funcionario WHERE status_sistema=1 AND id_unidade=:unidade AND menu_scouter_whatsapp=1");
		$relatorioSolicitado="Whatsapp";
	}elseif($formaCaptacao == 3){
		$scoutersAtivos=$pdo->prepare("SELECT * FROM funcionario WHERE status_sistema=1 AND id_unidade=:unidade AND menu_scouter_ligacao_new=1 AND id_func=:idFunc ");
		$scoutersAtivos->bindValue(":idFunc", $GETfunc);
		$relatorioSolicitado="Ligação";
	}elseif($formaCaptacao == 4){
		$scoutersAtivos=$pdo->prepare("SELECT * FROM funcionario WHERE status_sistema=1 AND id_unidade=:unidade AND menu_scouter_face=1");
		$relatorioSolicitado="Facebook";
	};

	$scoutersAtivos->bindValue(":unidade", $unidade, PDO::PARAM_INT);
	$scoutersAtivos->execute();
	$linhaScouter=$scoutersAtivos->fetchall(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Evolução</title>
</head>
<body>
	<center><h2>Relatório de Evolução de Scouters</h2></center>
	<hr>
	<br><br>
	<?php
		//Mostra Scouter's Ativos
		foreach($linhaScouter as $rowScouter){ 
			$idScouter=$rowScouter->id_func;
	?>
	<center>
		<table border="1">
			<tr>
				<td colspan="4"><center><h3>Informações do Colaborador</h3></center></td>
			</tr>
			<tr>
				<td><b>Identificação: </b></td>
				<td><?php echo $rowScouter->id_func; ?></td>
				<td><b>Nome Completo: </b></td>
				<td><?php echo $rowScouter->nome_completo_func; ?></td>
			</tr>
			<tr>
				<td><b>Relatório Solicitado: </b></td>
				<td><?php echo $relatorioSolicitado; ?></td>
				<td><b>Data de Cadastro: </b></td>
				<td><?php echo date("d/m/Y H:i", strtotime($rowScouter->data_cadastro_func)); ?></td>
			</tr>
		</table>
		<br>
		<table border="1">
			<tr>
				<td colspan="20"><center><h3> Resumo Estatístico do Período Solicitado </h3></center></td>
			</tr>
			<tr>
				<td colspan="20"><center><h4>Quesitos</h4></center></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="3"><b><center>Fichas</center></b></td>
				<td colspan="4"><b><center>Agendamentos</center></b></td>
				<td colspan="5"><b><center>Re-Agendamentos</center></b></td>
				<td><b><center>Confirmação</center></b></td>
				<td><b><center>Subidas</center></b></td>
				<td colspan="2"><b><Center>Fechamentos</Center></b></td>
			</tr>
			<tr>
				<td><b><center>Data de Busca</center></b></td>
				<td><b><center>Fichas Liberadas</center></b></td>
				<td><b><center>Agendamentos Por Fichas</center></b></td>
				<td><b><center>ADF¹</center></b></td>
				<td><b><center>Cadastrados no Dia</center></b></td>
				<td><b><center>Agendados Para o Dia</center></b></td>
				<td><b><center>Total do Dia</center></b></td>
				<td><b><center>ADAG²</center></b></td>
				<td><b><center>Re-Agendados</center></b></td>
				<td><b><center>Por Recuperação</center></b></td>
				<td><b><center>Por Confirmação</center></b></td>
				<td><b><center>Por Acompanhamento</center></b></td>
				<td><b><center>Agendamentos Liberados</center></b></td>
				<td><b><center>Qtd. Confirmados</center></b></td>
				<td><b><center>Qtd. Subidas</center></b></td>
				<td><b><center>Valor de Fechamento</center></b></td>
				<td><b><center>Valor CVC</center></b></td>
			</tr>
			<?php
				$timestamp1 = strtotime( $dataInicial );
				$timestamp2 = strtotime( $dataFinal );

				$totalFichasLiberadas=0;
				$totalAgendamentoPorFicha=0;
				$totalCadastradosNoDia=0;
				$totalAgendadosParaODia=0;
				$totalDoDia=0;
				$totalReAgendadoNormal=0;
				$totalReAgendadoRecuperacao=0;
				$totalReAgendadosConfirmacao=0;
				$totalReAgendadosAcompanhamento=0;
				$totalAgendamentosLiberados=0;
				$totalConfirmadosParaODia=0;
				$totalSubidasDia=0;

				while ( $timestamp1 <= $timestamp2 ){ 
					$dataexibida = date('d/m/Y', $timestamp1);
					$datapesquisa = date('Y-m-d', $timestamp1);

					//Dia da Semana
					$diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
					$data = $datapesquisa;
					$diasemana_numero = date('w', strtotime($data));

					//Fichas Liberadas
					$fichasLiberadas=$pdo->prepare("SELECT * FROM controle_ligacao WHERE id_func=:idFuncionario AND date(data_liberada_stand_by)=:dataPesquisa");
					$fichasLiberadas->bindValue(":idFuncionario", $idScouter);
					$fichasLiberadas->bindValue(":dataPesquisa", $datapesquisa);
					$fichasLiberadas->execute();
					$qtdFichasLiberadas=$fichasLiberadas->rowCount();

					//Agendamentos Cadastrados Por Fichas na Data de Busca
					$cadastradosPorFichas=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado='0' AND id_ficha <> 0");
					$cadastradosPorFichas->bindValue(":idFuncionario", $idScouter);
					$cadastradosPorFichas->bindValue(":dataPesquisa", $datapesquisa);
					$cadastradosPorFichas->bindValue(":meioCaptado", $formaCaptacao);
					$cadastradosPorFichas->execute();
					$qtdCadastradosPorFichas=$cadastradosPorFichas->rowCount();

					//Agendamenos Cadastrados no Dia da Data de Busca
					$cadastradosNoDia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado='0'");
					$cadastradosNoDia->bindValue(":idFuncionario", $idScouter);
					$cadastradosNoDia->bindValue(":dataPesquisa", $datapesquisa);
					$cadastradosNoDia->bindValue(":meioCaptado", $formaCaptacao);
					$cadastradosNoDia->execute();
					$qtdCadastradosNoDia=$cadastradosNoDia->rowCount();

					//Agendamentos Agendados Para o Dia da Data de Busca
					$cadastradosParaDia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_agendada_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado");
					$cadastradosParaDia->bindValue(":idFuncionario", $idScouter);
					$cadastradosParaDia->bindValue(":dataPesquisa", $datapesquisa);
					$cadastradosParaDia->bindValue(":meioCaptado", $formaCaptacao);
					$cadastradosParaDia->execute();
					$qtdcadastradosParaDia=$cadastradosParaDia->rowCount();

					//Reagendados que não são de recuperação
					$reagendadosNormal=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado=:reagendado");
					$reagendadosNormal->bindValue(":idFuncionario", $idScouter);
					$reagendadosNormal->bindValue(":dataPesquisa", $datapesquisa);
					$reagendadosNormal->bindValue(":meioCaptado", $formaCaptacao);
					$reagendadosNormal->bindValue(":reagendado", 1);
					$reagendadosNormal->execute();
					$qtdReagendadosNormal=$reagendadosNormal->rowCount();

					//Agendamentos Liberados
					$agendamentosLiberados=$pdo->prepare("SELECT * FROM agendamentos WHERE func_recuperacao=:idFuncionario AND id_meio_captado=:meioCaptado AND date(dataLiberadaRecuperacao)=:dataLiberada ");
					$agendamentosLiberados->bindValue(":idFuncionario", $idScouter);
					//$agendamentosLiberados->bindValue(":dataPesquisa", $datapesquisa);
					$agendamentosLiberados->bindValue(":dataLiberada", $datapesquisa);
					$agendamentosLiberados->bindValue(":meioCaptado", $formaCaptacao);
					$agendamentosLiberados->execute();
					$qtdAgendamentosLiberados=$agendamentosLiberados->rowCount();

					//Reagendados que São de recuperação do dia
					$reagendadosDeRecuperacao=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado='1' AND reagendadoRecuperacao='1' ");
					$reagendadosDeRecuperacao->bindValue(":idFuncionario", $idScouter);
					$reagendadosDeRecuperacao->bindValue(":dataPesquisa", $datapesquisa);
					$reagendadosDeRecuperacao->bindValue(":meioCaptado", $formaCaptacao);
					$reagendadosDeRecuperacao->execute();
					$qtdReagendadosDeRecuperacao=$reagendadosDeRecuperacao->rowCount();

					//Reagendados que São de confirmacao do dia
					$reagendadosDeConfirmacao=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado='1' AND reagendadoConfirmacao='1' ");
					$reagendadosDeConfirmacao->bindValue(":idFuncionario", $idScouter);
					$reagendadosDeConfirmacao->bindValue(":dataPesquisa", $datapesquisa);
					$reagendadosDeConfirmacao->bindValue(":meioCaptado", $formaCaptacao);
					$reagendadosDeConfirmacao->execute();
					$qtdReagendadosDeConfirmacao=$reagendadosDeConfirmacao->rowCount();

					//Reagendados que São de acompanhamento do dia
					$reagendadosDeAcompanhamento=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_cadastro_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND reagendado='1' AND reagendadoAcompanhamento='1' ");
					$reagendadosDeAcompanhamento->bindValue(":idFuncionario", $idScouter);
					$reagendadosDeAcompanhamento->bindValue(":dataPesquisa", $datapesquisa);
					$reagendadosDeAcompanhamento->bindValue(":meioCaptado", $formaCaptacao);
					$reagendadosDeAcompanhamento->execute();
					$qtdReagendadosDeAcompanhamento=$reagendadosDeAcompanhamento->rowCount();

					//Agendamentos Confirmados para o dia da data de busca
					$confirmadosParaODia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_agendada_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND confirmado='1' ");
					$confirmadosParaODia->bindValue(":idFuncionario", $idScouter);
					$confirmadosParaODia->bindValue(":dataPesquisa", $datapesquisa);
					$confirmadosParaODia->bindValue(":meioCaptado", $formaCaptacao);
					$confirmadosParaODia->execute();
					$qtdconfirmadosParaODia=$confirmadosParaODia->rowCount();

					//Qtd Subidas na data de busca
					$subidasDoDia=$pdo->prepare("SELECT * FROM agendamentos WHERE id_func=:idFuncionario AND date(data_agendada_agendamento)=:dataPesquisa AND id_meio_captado=:meioCaptado AND id_comparecimento='1' ");
					$subidasDoDia->bindValue(":idFuncionario", $idScouter);
					$subidasDoDia->bindValue(":dataPesquisa", $datapesquisa);
					$subidasDoDia->bindValue(":meioCaptado", $formaCaptacao);
					$subidasDoDia->execute();
					$qtdSubidasDoDia=$subidasDoDia->rowCount();

					//% de Aproveitamento das Fichas
					if($qtdCadastradosPorFichas <= 0){
					$aproveitamentoFicha = "0 %";
					}else{
						if($qtdFichasLiberadas <= 0){
							$aproveitamentoFicha = "0 %";
						}else{
							$aproveitamentoFicha=($qtdCadastradosPorFichas*100)/$qtdFichasLiberadas;
						}
					}

					//% de Aproveitamento do Agendamento
					if($qtdReagendadosDeRecuperacao <= 0){
						$aproveitamentoAgendamento= "0 %";
					}else{
						if($qtdAgendamentosLiberados <= 0){
							$aproveitamentoAgendamento= "0 %";
						}else{
						$aproveitamentoAgendamento=($qtdReagendadosDeRecuperacao*100)/$qtdAgendamentosLiberados;
						};
					};


					//Total Ficha Liberada
					if($qtdFichasLiberadas > 0){
						$totalFichasLiberadas=$totalFichasLiberadas+$qtdFichasLiberadas;
					}else{

					};

					//Total Agendamento por Ficha
					if($qtdCadastradosPorFichas > 0){
						$totalAgendamentoPorFicha=$totalAgendamentoPorFicha+$qtdCadastradosPorFichas;
					}else{

					};

					//Total Cadastrados no Dia
					if($qtdCadastradosNoDia > 0){
						$totalCadastradosNoDia=$totalCadastradosNoDia+$qtdCadastradosNoDia;
					}else{

					};

					//Total Agendados Para o Dia
					if($qtdcadastradosParaDia > 0){
						$totalAgendadosParaODia=$totalAgendadosParaODia+$qtdcadastradosParaDia;
					}else{

					};

					//Total Agendados do dia
					$qtdTotalDoDia=$qtdCadastradosNoDia + $qtdReagendadosNormal;
					if($qtdTotalDoDia > 0){
						$totalDoDia=$totalDoDia+$qtdTotalDoDia;
					}else{

					}

					//Total reagendados normal
					if($qtdReagendadosNormal > 0){
						$totalReAgendadoNormal=$totalReAgendadoNormal+$qtdReagendadosNormal;
					}else{

					};

					//Total Reagendados Recuperação
					if($qtdReagendadosDeRecuperacao > 0){
						$totalReAgendadoRecuperacao=$totalReAgendadoRecuperacao+$qtdReagendadosDeRecuperacao;
					}else{

					};

					//Total Reagendados Confirmação
					if($qtdReagendadosDeConfirmacao > 0){
						$totalReAgendadosConfirmacao=$totalReAgendadoRecuperacao+$qtdReagendadosDeConfirmacao;
					}else{

					};

					//Total Reagendados Acompanhamento
					if($qtdReagendadosDeAcompanhamento > 0){
						$totalReAgendadosAcompanhamento=$totalReAgendadosAcompanhamento+$qtdReagendadosDeAcompanhamento;
					}else{

					};

					//Total agendamentos liberados
					if($qtdAgendamentosLiberados > 0){
						$totalAgendamentosLiberados=$totalAgendamentosLiberados+$qtdAgendamentosLiberados;
					}else{

					};

					//Aproveitamento dos COnfirmados
					if($qtdconfirmadosParaODia <= 0){
						$aproveitamentoConfirmados="0 %";
					}else{
						$aproveitamentoConfirmados=round(($qtdconfirmadosParaODia*100)/$qtdcadastradosParaDia, 2);
					};

					//Total de Confirmados
					if($qtdconfirmadosParaODia > 0){
						$totalConfirmadosParaODia=$totalConfirmadosParaODia+$qtdconfirmadosParaODia;
					}else{

					};

					//Tota de subidas
					if($qtdSubidasDoDia > 0){
						$totalSubidasDia=$totalSubidasDia+$qtdSubidasDoDia;
					}else{

					};


			?>
			<tr> 
				<td><center><?php echo $dataexibida." - ".$diasemana[$diasemana_numero];; ?></center></td>
				<td><center><?php echo $qtdFichasLiberadas; ?></center></td>
				<td><center><?php echo $qtdCadastradosPorFichas; ?></center></td>
				<td><center><?php if($qtdCadastradosPorFichas <= 0){echo "0 %";}else{ echo round($aproveitamentoFicha, 2)." %"; } ?></center></td>
				<td><center><?php echo $qtdCadastradosNoDia; ?></center></td>
				<td><center><?php echo $qtdcadastradosParaDia; ?></center></td>
				<td><center><?php echo $qtdTotalDoDia; ?></center></td>
				<td><center><?php if($qtdReagendadosDeRecuperacao <= 0){echo "0 %";}else{ echo round($aproveitamentoAgendamento, 2)." %"; }; ?></center></td>
				<td><center><?php echo $qtdReagendadosNormal; ?></center></td>
				<td><center><?php echo $qtdReagendadosDeRecuperacao; ?></center></td> 
				<td><center><?php echo $qtdReagendadosDeConfirmacao; ?></center></td> 
				<td><center><?php echo $qtdReagendadosDeAcompanhamento; ?></center></td>
				<td><center><?php echo $qtdAgendamentosLiberados; ?></center></td>			
				<td><center><?php echo $qtdconfirmadosParaODia." / ".$qtdcadastradosParaDia." - ".$aproveitamentoConfirmados." %"; ?></center></td>
				<td><center><?php echo $qtdSubidasDoDia; ?></center></td>
				<td> </td>
				<td> </td>
			</tr>

			<?php
			$timestamp1 += 86400;
				}
				$porcentagemADF=($totalAgendamentoPorFicha*100)/$totalFichasLiberadas;
				$porcentagemAAL=($totalReAgendadoRecuperacao*100)/$totalAgendamentosLiberados;


			?>
			<tr>
				<td><center>TOTAIS:</center></td>
				<td><center><?php echo $totalFichasLiberadas; ?></center></td>
				<td><center><?php echo $totalAgendamentoPorFicha; ?></center></td>
				<td><center><?php echo round($porcentagemADF,2)." %"; ?></center></td>
				<td><center><?php echo $totalCadastradosNoDia; ?></center></td>
				<td><center><?php echo $totalAgendadosParaODia; ?></center></td>
				<td><center><?php echo $totalDoDia; ?></center></td>
				<td><center><?php echo round($porcentagemAAL,2)." %";; ?></center></td>
				<td><center><?php echo $totalReAgendadoNormal; ?></center></td>
				<td><center><?php echo $totalReAgendadoRecuperacao; ?></center></td>
				<td><center><?php echo $totalReAgendadosConfirmacao; ?></center></td>
				<td><center><?php echo $totalReAgendadosAcompanhamento; ?></center></td>
				<td><center><?php echo $totalAgendamentosLiberados; ?></center></td>
				<td><center><?php echo $totalConfirmadosParaODia." / ".$totalAgendadosParaODia." - "; ?></center></td>
				<td><center><?php echo $totalSubidasDia; ?></center></td>
				<td width="50px"><center><?php  ?></center></td>
				<td width="50px"><center><?php  ?></center></td>

			</tr>
		</table>
		<br>
		ADF¹ » Aproveitamento de Ficha - Ref.(Total de Fichas Liberadas/Total de Agendamentos Por Ficha) <br>
		ADAG² » Aproveitamento de Agendamentos Liberados - Ref.(Total de Agendamentos Liberados / Total de Re-Agendamentos Cadastrados de Recuperação) <br>
		MVCVC³ » Média de Vendas CVC - Ref. (Total de CVC de todos os colaboradores / Número de colaboradores)

		<br><br>

		<table border="1">
			<tr>
				<td>MAF</td>
				<td width="70px"> </td>
			</tr>
			<tr>
				<td>MAAG</td>
				<td width="70px"> </td>
			</tr>
			<tr>
				<td>MVCVC</td>
				<td width="70px"> </td>
			</tr>
		</table>
	</center>
	<?php
		};

	?>



</body>
</html>
<?php	

	
	include_once("../conection/conexao.php");
	$param_data = $_GET['data'];
	
	$html  = '<center>';
	$html .= '<table>';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Nº</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Colaborador</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Qtd. Agendados</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Qtd. Confirmados</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Aproveitamento</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF;">Análise</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	
	$result_transacoes = "SELECT * FROM funcionario WHERE status_sistema = '1' AND menu_scouter_ligacao = '1' OR menu_scouter_insta = '1' OR menu_scouter_wts = '1'";
	$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
	$cont = "1";
	while($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)){

		$idfuncionario = $row_transacoes['id_func'];
		$qtd_agendados = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND data_agendada_agendamento = '$param_data'";
		$exec_qtd_agendados = mysqli_query($conn, $qtd_agendados);
		$cont_qtd_agendados = mysqli_num_rows($exec_qtd_agendados);

		$qtd_confirmados = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND data_agendada_agendamento = '$param_data' AND confirmado = '1'";
		$exec_qtd_confirmados = mysqli_query($conn, $qtd_confirmados);
		$cont_qtd_confirmados = mysqli_num_rows($exec_qtd_confirmados);

		if($cont_qtd_agendados > 0){
		$porcentagem_final = ($cont_qtd_confirmados * 100)/$cont_qtd_agendados;
		}else{
			$porcentagem_final = "0";
		};


		if($porcentagem_final < 30){
			$analise_final = "Retido";
		}else{
			$analise_final = "Mantido";
		}
		if($cont % 2 == 0){
			$cor = "#DCDCDC";
		}else{
			$cor = "#A9A9A9";
		};

		$html .= '<tr><td bgcolor='.$cor.'>'.$cont. '</td>';
		$html .= '<td bgcolor='.$cor.'>'.$row_transacoes['nome_completo_func'] . '</td>';
		$html .= '<td bgcolor='.$cor.'>'.$cont_qtd_agendados . '</td>';
		$html .= '<td bgcolor='.$cor.'>'.$cont_qtd_confirmados . '</td>';
		$html .= '<td bgcolor='.$cor.'>'.round($porcentagem_final,2) . '%</td>';
		$html .= '<td bgcolor='.$cor.'>'.$analise_final. '</td></tr>';	
		$cont++;
	}
	
	$html .= '</tbody>';
	$html .= '</table>';
	$html .= '</center>';
	
	

	
	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Carrega seu HTML
	$dompdf->load_html('
			<center><img src="../images/logonovo.png" width="200px" height="200px"></center>			
			<h3 style="text-align: center;">Relatório de Confirmação Diário</h3>
			<h5>Ref. '.$param_data.' </h5>
			'. $html .'

		');
	

	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio_confirmacao_".$param_data, 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>
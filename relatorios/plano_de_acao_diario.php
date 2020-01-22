<?php	

	
	include_once("../conection/conexao.php");
	$param_data = $_GET['data'];
	$param_unid = $_GET['unid'];

	$result_num_agendados = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid'";
    $resultado_num_agendados = mysqli_query($conn, $result_num_agendados);
    $qtd_agendados = mysqli_num_rows($resultado_num_agendados);

    $result_num_confirmados_conf1 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND id_comparecimento = '3' AND confirmado = '1'"; 
    $resultado_num_conf1 = mysqli_query($conn, $result_num_confirmados_conf1);
    $qtd_confirmados = mysqli_num_rows($resultado_num_conf1);
	
	$html  = '<center>';
	$html .= '<center> <h3> Agendamentos Homologados por Horário </h3> </center>';
	$html .= '<hr>';
	$html .= '<table style="text-align:center">';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<td><b>Total Agendado:</b></td>';
	$html .= '<td>'.$qtd_agendados.'</td>';
	$html .= '<td><b>Total Confirmado:</b></td>';
	$html .= '<td>'.$qtd_confirmados.'</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF; width:100px;">Horário</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF; width:200px;">Agendados</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF; width:200px;">Confirmados</th>';
	$html .= '<th bgcolor="	#000000" style="color:#FFFFFF; width:200px;">Aproveitamento</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';


		//RELATORIO 10 AS 11
		$html .= '<tr><td> 10:00 - 11:00 </td>';
		$qtd_agendados1011 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '10:00:00' AND '10:59:00'";
		$exec_qtd_agendados1011 = mysqli_query($conn, $qtd_agendados1011);
		$cont_qtd_agendados1011 = mysqli_num_rows($exec_qtd_agendados1011);
		$qtd_confirmados1011 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '10:00:00' AND '10:59:00'";
		$exec_qtd_confirmados1011 = mysqli_query($conn, $qtd_confirmados1011);
		$cont_qtd_confirmados1011 = mysqli_num_rows($exec_qtd_confirmados1011);
		$html .= '<td>'.$cont_qtd_agendados1011. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1011. '</td>';
		if($cont_qtd_agendados1011 > 0){
		$porcentagem_final_1011 = ($cont_qtd_confirmados1011 * 100)/$cont_qtd_agendados1011;
		}else{
			$porcentagem_final_1011 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1011,2).'%</td></tr>';

		//RELATORIO 11 AS 12
		$html .= '<tr><td> 11:00 - 12:00 </td>';
		$qtd_agendados1112 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '11:00:00' AND '11:59:00'";
		$exec_qtd_agendados1112 = mysqli_query($conn, $qtd_agendados1112);
		$cont_qtd_agendados1112 = mysqli_num_rows($exec_qtd_agendados1112);
		$qtd_confirmados1112 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '11:00:00' AND '11:59:00'";
		$exec_qtd_confirmados1112 = mysqli_query($conn, $qtd_confirmados1112);
		$cont_qtd_confirmados1112 = mysqli_num_rows($exec_qtd_confirmados1112);
		$html .= '<td>'.$cont_qtd_agendados1112. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1112. '</td>';
		if($cont_qtd_agendados1112 > 0){
		$porcentagem_final_1112 = ($cont_qtd_confirmados1112 * 100)/$cont_qtd_agendados1112;
		}else{
			$porcentagem_final_1112 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1112,2).'%</td></tr>';

		//RELATORIO 12 AS 13
		$html .= '<tr><td> 12:00 - 13:00 </td>';
		$qtd_agendados1213 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '12:00:00' AND '12:59:00'";
		$exec_qtd_agendados1213 = mysqli_query($conn, $qtd_agendados1213);
		$cont_qtd_agendados1213 = mysqli_num_rows($exec_qtd_agendados1213);
		$qtd_confirmados1213 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '12:00:00' AND '12:59:00'";
		$exec_qtd_confirmados1213 = mysqli_query($conn, $qtd_confirmados1213);
		$cont_qtd_confirmados1213 = mysqli_num_rows($exec_qtd_confirmados1213);
		$html .= '<td>'.$cont_qtd_agendados1213. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1213. '</td>';
		if($cont_qtd_agendados1213 > 0){
		$porcentagem_final_1213 = ($cont_qtd_confirmados1213 * 100)/$cont_qtd_agendados1213;
		}else{
			$porcentagem_final_1213 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1213,2).'%</td></tr>';


		//RELATORIO 13 AS 14
		$html .= '<tr><td> 13:00 - 14:00 </td>';
		$qtd_agendados1314 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '13:00:00' AND '13:59:00'";
		$exec_qtd_agendados1314 = mysqli_query($conn, $qtd_agendados1314);
		$cont_qtd_agendados1314 = mysqli_num_rows($exec_qtd_agendados1314);
		$qtd_confirmados1314 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '13:00:00' AND '13:59:00'";
		$exec_qtd_confirmados1314 = mysqli_query($conn, $qtd_confirmados1314);
		$cont_qtd_confirmados1314 = mysqli_num_rows($exec_qtd_confirmados1314);
		$html .= '<td>'.$cont_qtd_agendados1314. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1314. '</td>';
		if($cont_qtd_agendados1314 > 0){
		$porcentagem_final_1314 = ($cont_qtd_confirmados1314 * 100)/$cont_qtd_agendados1314;
		}else{
			$porcentagem_final_1314 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1314,2).'%</td></tr>';

		//RELATORIO 14 AS 15
		$html .= '<tr><td> 14:00 - 15:00 </td>';
		$qtd_agendados1415 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '14:00:00' AND '14:59:00'";
		$exec_qtd_agendados1415 = mysqli_query($conn, $qtd_agendados1415);
		$cont_qtd_agendados1415 = mysqli_num_rows($exec_qtd_agendados1415);
		$qtd_confirmados1415 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '14:00:00' AND '14:59:00'";
		$exec_qtd_confirmados1415 = mysqli_query($conn, $qtd_confirmados1415);
		$cont_qtd_confirmados1415 = mysqli_num_rows($exec_qtd_confirmados1415);
		$html .= '<td>'.$cont_qtd_agendados1415. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1415. '</td>';
		if($cont_qtd_agendados1415 > 0){
		$porcentagem_final_1415 = ($cont_qtd_confirmados1415 * 100)/$cont_qtd_agendados1415;
		}else{
			$porcentagem_final_1415 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1415,2).'%</td></tr>';

		//RELATORIO 15 AS 16
		$html .= '<tr><td> 15:00 - 16:00 </td>';
		$qtd_agendados1516 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '15:00:00' AND '15:59:00'";
		$exec_qtd_agendados1516 = mysqli_query($conn, $qtd_agendados1516);
		$cont_qtd_agendados1516 = mysqli_num_rows($exec_qtd_agendados1516);
		$qtd_confirmados1516 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '15:00:00' AND '15:59:00'";
		$exec_qtd_confirmados1516 = mysqli_query($conn, $qtd_confirmados1516);
		$cont_qtd_confirmados1516 = mysqli_num_rows($exec_qtd_confirmados1516);
		$html .= '<td>'.$cont_qtd_agendados1516. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1516. '</td>';
		if($cont_qtd_agendados1516 > 0){
		$porcentagem_final_1516 = ($cont_qtd_confirmados1516 * 100)/$cont_qtd_agendados1516;
		}else{
			$porcentagem_final_1516 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1516,2).'%</td></tr>';

		//RELATORIO 16 AS 17
		$html .= '<tr><td> 16:00 - 17:00 </td>';
		$qtd_agendados1617 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '16:00:00' AND '16:59:00'";
		$exec_qtd_agendados1617 = mysqli_query($conn, $qtd_agendados1617);
		$cont_qtd_agendados1617 = mysqli_num_rows($exec_qtd_agendados1617);
		$qtd_confirmados1617 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '16:00:00' AND '16:59:00'";
		$exec_qtd_confirmados1617 = mysqli_query($conn, $qtd_confirmados1617);
		$cont_qtd_confirmados1617 = mysqli_num_rows($exec_qtd_confirmados1617);
		$html .= '<td>'.$cont_qtd_agendados1617. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1617. '</td>';
		if($cont_qtd_agendados1617 > 0){
		$porcentagem_final_1617 = ($cont_qtd_confirmados1617 * 100)/$cont_qtd_agendados1617;
		}else{
			$porcentagem_final_1617 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1617,2).'%</td></tr>';

		//RELATORIO 17 AS 18
		$html .= '<tr><td> 17:00 - 18:00 </td>';
		$qtd_agendados1718 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '17:00:00' AND '17:59:00'";
		$exec_qtd_agendados1718 = mysqli_query($conn, $qtd_agendados1718);
		$cont_qtd_agendados1718 = mysqli_num_rows($exec_qtd_agendados1718);
		$qtd_confirmados1718 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '17:00:00' AND '17:59:00'";
		$exec_qtd_confirmados1718 = mysqli_query($conn, $qtd_confirmados1718);
		$cont_qtd_confirmados1718 = mysqli_num_rows($exec_qtd_confirmados1718);
		$html .= '<td>'.$cont_qtd_agendados1718. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1718. '</td>';
		if($cont_qtd_agendados1718 > 0){
		$porcentagem_final_1718 = ($cont_qtd_confirmados1718 * 100)/$cont_qtd_agendados1718;
		}else{
			$porcentagem_final_1718 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1718,2).'%</td></tr>';

		//RELATORIO 18 AS 19
		$html .= '<tr><td> 18:00 - 19:00 </td>';
		$qtd_agendados1819 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '18:00:00' AND '18:59:00'";
		$exec_qtd_agendados1819 = mysqli_query($conn, $qtd_agendados1819);
		$cont_qtd_agendados1819 = mysqli_num_rows($exec_qtd_agendados1819);
		$qtd_confirmados1819 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '18:00:00' AND '18:59:00'";
		$exec_qtd_confirmados1819 = mysqli_query($conn, $qtd_confirmados1819);
		$cont_qtd_confirmados1819 = mysqli_num_rows($exec_qtd_confirmados1819);
		$html .= '<td>'.$cont_qtd_agendados1819. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1819. '</td>';
		if($cont_qtd_agendados1819 > 0){
		$porcentagem_final_1819 = ($cont_qtd_confirmados1819 * 100)/$cont_qtd_agendados1819;
		}else{
			$porcentagem_final_1819 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1819,2).'%</td></tr>';

		//RELATORIO 19 AS 20
		$html .= '<tr><td> 19:00 - 20:00 </td>';
		$qtd_agendados1920 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND hora_agendada_agendamento BETWEEN '19:00:00' AND '20:00:00'";
		$exec_qtd_agendados1920 = mysqli_query($conn, $qtd_agendados1920);
		$cont_qtd_agendados1920 = mysqli_num_rows($exec_qtd_agendados1920);
		$qtd_confirmados1920 = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND confirmado = '1' AND hora_agendada_agendamento BETWEEN '19:00:00' AND '20:00:00'";
		$exec_qtd_confirmados1920 = mysqli_query($conn, $qtd_confirmados1920);
		$cont_qtd_confirmados1920 = mysqli_num_rows($exec_qtd_confirmados1920);
		$html .= '<td>'.$cont_qtd_agendados1920. '</td>';
		$html .= '<td>'.$cont_qtd_confirmados1920. '</td>';
		if($cont_qtd_agendados1920 > 0){
		$porcentagem_final_1920 = ($cont_qtd_confirmados1920 * 100)/$cont_qtd_agendados1920;
		}else{
			$porcentagem_final_1920 = "0";
		};		
		$html .= '<td>'.round($porcentagem_final_1920,2).'%</td></tr>';	
	$html .= '</tbody>';
	$html .= '</table>';
	$html .= '</center>';

	//SEGUNDA TABELA

	$html .='<br><br><br>';
	$html .='<center><h3> Agendamentos Homologados por Modalidade </h3></center>';
	$html .='<hr>';
	$html .='<center><table style="text-align:center;">';
	$html .='<thead>';
	$html .='<th bgcolor="	#000000" style="color:#FFFFFF;width:225px"> Instagram </th>';
	$html .='<th bgcolor="	#000000" style="color:#FFFFFF;width:225px"> Whatsapp</th>';
	$html .='<th bgcolor="	#000000" style="color:#FFFFFF;width:225px"> Ligação </th>';
	$html .='</thead>';
	$html .='<tbody>';
	$html .='<tr>';
	$html .='<td></td>';
	$html .='<td></td>';
	$html .='<td></td>';
	$html .='</tr>';
	$html .='<tr>';
	$result_num_agendados_insta = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND id_meio_captado = '1'";
    $resultado_num_agendados_insta = mysqli_query($conn, $result_num_agendados_insta);
    $qtd_agendados_insta = mysqli_num_rows($resultado_num_agendados_insta);

    $result_num_agendados_wts = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND id_meio_captado = '2'";
    $resultado_num_agendados_wts = mysqli_query($conn, $result_num_agendados_wts);
    $qtd_agendados_wts = mysqli_num_rows($resultado_num_agendados_wts);

    $result_num_agendados_liga = "SELECT * FROM agendamentos WHERE data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid' AND id_meio_captado = '3'";
    $resultado_num_agendados_liga = mysqli_query($conn, $result_num_agendados_liga);
    $qtd_agendados_liga = mysqli_num_rows($resultado_num_agendados_liga);


	$html .='<td><font size="40px">'.$qtd_agendados_insta.' </font></td>';
	$html .='<td><font size="40px">'.$qtd_agendados_wts.'</font></td>';
	$html .='<td><font size="40px">'.$qtd_agendados_liga.'</font></td>';
	$html .='</tr>';
	$html .='</tbody>';
	$html .='</table></center>';




	//FIM SEGUNDA TABELA

	// TERCEIRA TABELA
	$html .= '<br><br><br>';
	$html .= '<center> <h3> Porcentagem de Confirmação (Apenas funcionários direcionados a unidade) </h3> </center>';
	$html .= '<hr>';
	$html .= '<center>';
	$html .= '<table style="text-align:center">';	
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
	
	$result_transacoes = "SELECT * FROM funcionario WHERE id_unidade = '$param_unid' AND status_sistema = '1'";
	$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
	$cont = "1";
	while($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)){

		$idfuncionario = $row_transacoes['id_func'];
		$qtd_agendados = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND data_agendada_agendamento = '$param_data' AND id_unidade = '$param_unid'";
		$exec_qtd_agendados = mysqli_query($conn, $qtd_agendados);
		$cont_qtd_agendados = mysqli_num_rows($exec_qtd_agendados);

		$qtd_confirmados = "SELECT * FROM agendamentos WHERE id_func = '$idfuncionario' AND data_agendada_agendamento = '$param_data' AND confirmado = '1' AND id_unidade = '$param_unid'";
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


	// FIM TERCEIRA TABELA




	if($param_unid == 1){
		$unid_extenso = "Exclusive Matriz";
	}else if($param_unid == 3){
		$unid_extenso = "Impact Agency";
	}else if($param_unid == 4){
		$unid_extenso = "Concept";
	};
	

	
	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Carrega seu HTML
	$dompdf->load_html('
			<center><img src="../logonovo.png" width="200px" height="200px"></center>			
			<h3 style="text-align: center;">Plano de Ação </h3>
			<h5>Ref. '.$param_data.' </h5>
			<h5>Unidade de Análise: '.$unid_extenso.'</h5>
			'. $html .'

		');
	

	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio_diario_".$param_data, 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>
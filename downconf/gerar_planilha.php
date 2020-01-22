<!--**
 * @author Cesar Szpak - Celke -   cesar@celke.com.br
 * @pagina desenvolvida usando framework bootstrap,
 * o código é aberto e o uso é free,
 * porém lembre -se de conceder os créditos ao desenvolvedor.
 *-->
 <?php
	session_start();
	include_once("../conection/conexao.php");


	$data_get = $_GET['dataget'];
	$unidade_get = $_GET['uniget'];
		
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Baixar Planilha</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'Confirmacao-'.$data_get.'.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="10"><center><b><font size="6"> Confirmação Temporária de Agendados Via Sistema </font></b></center> </tr>';
		$html .= '</tr>';	
		
		$html .= '<tr>';
		$html .= '<td><b> # Cliente</b></td>';
		$html .= '<td><b>Modelo</b></td>';
		$html .= '<td><b>Resposável</b></td>';
		$html .= '<td><b>Telefone 1</b></td>';
		$html .= '<td><b>Telefone 2</b></td>';
		$html .= '<td><b>Data Agendado</b></td>';
		$html .= '<td><b>Hora Agendado</b></td>';
		$html .= '<td><b>Scouter</b></td>';
		$html .= '<td><b>Modalidade</b></td>';
		$html .= '<td><b>POS</b></td>';
		$html .= '</tr>';
		
		//Selecionar todos os itens da tabela 
		$result_msg_contatos = "SELECT cli.id_cliente, cli.nome_cliente, cli.nome_responsavel_cliente, cli.telefone_cliente, cli.telefone2_cliente, ag.data_agendada_agendamento , ag.hora_agendada_agendamento, fun.nome_completo_func, mc.descricao_meio_captado  FROM agendamentos ag 
				INNER JOIN cliente cli ON ag.id_cliente = cli.id_cliente
				INNER JOIN funcionario fun ON ag.id_func = fun.id_func
				INNER JOIN meio_captado mc ON cli.id_meio_captado = mc.id_meio_captado
				WHERE ag.data_agendada_agendamento = '$data_get' AND ag.id_unidade = '$unidade_get'";
		$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
		
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["id_cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["nome_cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["nome_responsavel_cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["telefone_cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["telefone2_cliente"].'</td>';
			$html .= '<td>'.$row_msg_contatos["data_agendada_agendamento"].'</td>';
			$html .= '<td>'.$row_msg_contatos["hora_agendada_agendamento"].'</td>';
			$html .= '<td>'.$row_msg_contatos["nome_completo_func"].'</td>';
			$html .= '<td>'.$row_msg_contatos["descricao_meio_captado"].'</td>';
			$html .= '
			<select> 
				<option>Confirmou</option>
				<option>Reagendou</option>
				<option>Caixa Postal</option>
				<option>Não Atende</option>
				<option>Desligou</option>
				<option>Em Aberto</option>
				<option>Sem Interesse</option>
				<option>DDD de Fora</option>
				<option>Irá Retornar</option>
			</select>';
			$html .= '</tr>';
			;
		}
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>
<?php	

	
	include_once("../conection/conexao.php");
	$param_contrato = $_GET['cnt'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	
	

	//PESQUISA CONTRATO
	$select_modelo = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$param_contrato' LIMIT 1";
	$exec_select_modelo = mysqli_query($conn, $select_modelo);
	$row_modelo = mysqli_fetch_assoc($exec_select_modelo);
	$fechamento_banco = $row_modelo['data_cadastro_cc'];
	$diaextenso = date('d/m/Y');
	//$diaextenso = strftime('%A, %d de %B de %Y', strtotime('$dia_fechamento'));

	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc']; 
	if($idade >= 18){ 

		$html = '<div id="container" style="width=200px;"><center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Carta de Cancelamento</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente instrumento particular de contrato as partes abaixo qualificadas, a saber: <br>';
		$html .= '<b>CONTRATANTE:</b>'.mb_strtoupper($row_modelo['nome_modelo_cc'])." inscrito no CPF: ".$row_modelo['cpf_modelo_cc']." e portador da cédula de RG: ".$row_modelo['rg_modelo_cc']." residente no endereço ".$row_modelo['endereco_cc'].", Nº ".$row_modelo['numero_cc'].", ".$row_modelo['complemento_cc']." do bairro ".$row_modelo['bairro_cc']." situado na cidade de São Paulo - SP, CEP: ".$row_modelo['CEP_cc'].", tendo como telefone principal: ".$row_modelo['telefone_residencial_cc']." e telefone secundário: ".$row_modelo['telefone_celular_cc']."<br>";
		$html .= '<b>CONTRATADA:</b> AGENCY EXCLUSIVE, empresa situada a Rua Coronel Luis Americano, Nº 250 - Tatuapé - CEP: 03308-020, São Paulo - SP, incrita no Cadastro Nacional de Pessoa Jurídica do Minitério da Fazenda (CNPJ/MF) sob o Nº 32.473.749/0001 - 42, representada neste ato por quem de direito. <br>';
		$html .= 'As partes acima identificadas tinham, entre si, justo e acertado o presente Contrato de Prestação de Serviços, de número '.$row_modelo['contrato_cc'].'. <br>';
		$html .= 'Informado que por livre e espontânea vontade o responsável pelo contrato citado acima, solicita o cancelamento da prestação de serviço. Por isso, desde a presente data a CONTRATADA citada no começo deste informa que suspende qualquer serviço que foi informado no contrato assinado por ambos na data de '.date("d/m/Y",strtotime($fechamento_banco)).'. <br> ';
		$html .= 'Abaixo infomamos o motivo citado para que houvesse o cancelamento e informações adicionais:  <br><table border=1><tr><td>'.$row_modelo['motivoCancelamento'].'</td></tr></table>';	
		$html .= 'Sendo assim, a CONTRATADA sente por não manter esta parceria porém entende a necessidade de cada cliente. <br> Justo, e de acordo.';		
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		$html .= '</div>';
		//finaliza contrato adulto

	}else if($idade < 18){

		$html = '<div id="container" style="width=200px;"><center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Carta de Cancelamento</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente instrumento particular de contrato as partes abaixo qualificadas, a saber: <br>';
		$html .= '<b>CONTRATANTE:</b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).", portador(a) da cédula de RG:".$row_modelo['rg_responsavel_cc'].", inscrito no CPF: ".$row_modelo['cpf_responsavel_cc'].", perante a meios judiciais legalmente responsável por ". mb_strtoupper($row_modelo['nome_modelo_cc'])." inscrito no CPF: ".$row_modelo['cpf_modelo_cc']." e portador da cédula de RG: ".$row_modelo['rg_modelo_cc']." ambos residentes no endereço ".$row_modelo['endereco_cc'].", Nº ".$row_modelo['numero_cc'].", ".$row_modelo['complemento_cc']." do bairro ".$row_modelo['bairro_cc']." situado na cidade de São Paulo - SP, CEP: ".$row_modelo['CEP_cc'].", tendo como telefone principal: ".$row_modelo['telefone_residencial_cc'] ." e telefone secundário: ".$row_modelo['telefone_celular_cc']."<br>";
		$html .= '<b>CONTRATADA:</b> AGENCY EXCLUSIVE, empresa situada a Rua Coronel Luis Americano, Nº 250 - Tatuapé - CEP: 03308-020, São Paulo - SP, incrita no Cadastro Nacional de Pessoa Jurídica do Minitério da Fazenda (CNPJ/MF) sob o Nº 32.473.749/0001 - 42, representada neste ato por quem de direito. <br>';
		$html .= 'As partes acima identificadas tinham, entre si, justo e acertado o presente Contrato de Prestação de Serviços, de número '.$row_modelo['contrato_cc'].'. <br>';
		$html .= 'Informado que por livre e espontânea vontade o responsável pelo contrato citado acima, solicita o cancelamento da prestação de serviço. Por isso, desde a presente data a CONTRATADA citada no começo deste informa que suspende qualquer serviço que foi informado no contrato assinado por ambos na data de '.date("d/m/Y",strtotime($fechamento_banco)).'. <br> ';
		$html .= 'Abaixo infomamos o motivo citado para que houvesse o cancelamento e informações adicionais:  <br><table border=1><tr><td>'.$row_modelo['motivoCancelamento'].'</td></tr></table>';	
		$html .= 'Sendo assim, a CONTRATADA sente por não manter esta parceria porém entende a necessidade de cada cliente. <br> Justo, e de acordo.';					
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b><br>CPF '.$row_modelo['cpf_responsavel_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_responsavel_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;	
		$html .= '</div>';
		//FINALIZA CONTRATO MENOR DE IDADE
	}
	
	

	
	//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF(); 
	
	// Carrega seu HTML
	$dompdf->load_html('
			<p align="right">Contrato:'.$param_contrato.'</p>
			'. $html .'

		');
	
	//$dompdf->set_paper("A4", "portrail");

	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"Contrato_Concept_".$param_contrato, 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>
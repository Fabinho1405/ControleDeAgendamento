<?php	

	
	include_once("../conection/conexao.php");
	$param_contrato = $_GET['idts'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	
	

	//PESQUISA CONTRATO
	$select_modelo = "SELECT * FROM trab_e_sele_exclusive tse
						INNER JOIN clientes_exclusive ce ON tse.contrato_cc = ce.contrato_cc
						INNER JOIN marcas ma ON tse.id_marcas = ma.id_marcas
						WHERE tse.id_ts = '$param_contrato' LIMIT 1";
	$exec_select_modelo = mysqli_query($conn, $select_modelo);
	$row_modelo = mysqli_fetch_assoc($exec_select_modelo);
	$fechamento_banco = $row_modelo['data_cadastro_cc'];
	$diaextenso = date('d/m/Y', strtotime($fechamento_banco));
	//$diaextenso = strftime('%A, %d de %B de %Y', strtotime('$dia_fechamento'));
	$data_trabalho = date('d/m/Y', strtotime($row_modelo['data_marcada']));
	if($row_modelo['tipo_cache'] == 1){$tipocache =  "pago";}else{$tipocache =  "abatido";};  


	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc']; 
	if($idade >= 18){

		$html = '<center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Termo de Comprometimento</h3></center>';
		$html .= '<br>São Paulo, '.$diaextenso.'<br>';
		$html .= 'Pelo presente <b>TERMO DE COMPROMISSO </b> eu '.mb_strtoupper($row_modelo['nome_modelo_cc']).', modelo agênciado, portador do CPF:'.$row_modelo['cpf_modelo_cc'].', referente à participação no trabalho da marca '.$row_modelo['descricao_marcas'].', promovido pela Agency Exclusive, a ser realizado na data de '.$data_trabalho.' às '.$row_modelo['hora_marcada'].', comprometendo-me à: <br> 1) Chegar no horário citado acima para não divergir o cronograma do representante que estará na agência. <br> 2) Comprometer a tomar o máximo de incumbência com as peças que a marca irá me conceder para a sessão de fotos. <br> 3) Respeitar o tempo que a marca leva para análisar, tratar e iniciar a divulgação da sua imagem com o nome dos mesmos, levando em conta inclusive divulgações de catálogos internos. <br> 4) Permanecer ciente de que o horário de finalização do trabalhado é relativo podendo variar de acordo com o horário de finalização comercial da agência. <br> Estou ciente que o emolumento do presente trabalho estará sendo <b>'. $tipocache .'</b> no valor de R$'.number_format($row_modelo['valor_cache'],2,',','.').'. Levando em conta que em caso de pagamento, a marca terá o tempo de 20 dias úteis, para fazer obrigatoriamente uma transferência para o modelo escolhido. <br> Por fim, estou ciente que em caso de desistência não informada, atrasos previamente não autorizados ou abandono do contrato com a agência, este termo se torna fútil para ambas as partes, sendo dirimido o pagamento de cachê sendo à pagar.';
		
		
		$html .= '<br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		
		//finaliza contrato adulto

	}else if($idade < 18){
		//INICIA CONTRATO DE MENOR DE IDADADE

		$html = '<center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Termo de Comprometimento</h3></center>';
		$html .= '<br>São Paulo, '.$diaextenso.'<br>';
		$html .= 'Pelo presente <b>TERMO DE COMPROMISSO </b> eu '.mb_strtoupper($row_modelo['nome_modelo_cc']).', modelo agênciado, portador do CPF:'.$row_modelo['cpf_modelo_cc'].', referente à participação no trabalho da marca '.$row_modelo['descricao_marcas'].', promovido pela Agency Exclusive, a ser realizado na data de '.$data_trabalho.' às '.$row_modelo['hora_marcada'].', comprometendo-me à: <br> 1) Chegar no horário citado acima para não divergir o cronograma do representante que estará na agência. <br> 2) Comprometer a tomar o máximo de incumbência com as peças que a marca irá me conceder para a sessão de fotos. <br> 3) Respeitar o tempo que a marca leva para análisar, tratar e iniciar a divulgação da sua imagem com o nome dos mesmos, levando em conta inclusive divulgações de catálogos internos. <br> 4) Permanecer ciente de que o horário de finalização do trabalhado é relativo podendo variar de acordo com o horário de finalização comercial da agência. <br> Estou ciente que o emolumento do presente trabalho estará sendo <b>'. $tipocache .'</b> no valor de R$'.number_format($row_modelo['valor_cache'],2,',','.').'. Levando em conta que em caso de pagamento, a marca terá o tempo de 20 dias úteis, para fazer obrigatoriamente uma transferência para o modelo escolhido. <br> Por fim, estou ciente que em caso de desistência não informada, atrasos previamente não autorizados ou abandono do contrato com a agência, este termo se torna fútil para ambas as partes, sendo dirimido o pagamento de cachê sendo à pagar.';
		
		
		$html .= '<br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b><br>CPF '.$row_modelo['cpf_responsavel_cc'].'</center><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;

		

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
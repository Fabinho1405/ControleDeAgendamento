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
	if($row_modelo['tipo_cache'] == 1){$tipocache =  1;}else{$tipocache =  2;}; 

	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc']; 
	if($idade >= 18){
		if($tipocache == 1){
			//MAIOR 18 CACHE PAGO
		$html = '<center><img src="../images/logo_blackout.png" width="210px" height="60px"></center>';
		$html .= '<center><h3>Termo de Trabalho</h3></center>';
		$html .= '<br>São Paulo, '.$diaextenso.'<br>';
		$html .= 'Dados do modelo: <br> Eu '.$row_modelo['nome_modelo_cc'].', portador do RG:'.$row_modelo['rg_modelo_cc'].', inscrito no CPF/MF sob:'.$row_modelo['cpf_modelo_cc'].', residente à '.$row_modelo['endereco_cc'].', nº '.$row_modelo['numero_cc'].', complemento: '.$row_modelo['complemento_cc'].', Telefone principal: '.$row_modelo['telefone_residencial_cc'].', Telefone secundário:'.$row_modelo['telefone_celular_cc'].'. <br><br> AUTORIZO o uso de imagem deste pela empresa BLACKOUT MAGAZINE, CNPJ: 34.368.203/0001-90. Em todo e qualquer material, sejam essas destinadas à divulgação ao público em geral. A presente autorização abrange o uso da imagem acima mencionada em todo território nacional, das seguintes formas: (I) out-door, (II) busdoor, (III) folhetos em geral (encartes, mala direta, catálogo, etc ..), (IV) folder de apresentação, (V) anúncios em revistas, (VI) home page, (VII) cartazes, (VIII) black-light, (IX) mídia eletrônica, facebook e instagram (painéis, vídeo-tapes, televisão, cinema, programa para rádio, entre outros).<br><br><center>Informações Bancárias</center><br>Banco/Instituição: ________________________ Tipo de Conta: __________________________ <br> Nome do Responsável da Conta: ___________________________________________________________ <br> CPF do Responsável: ___________________________________ <br> Agência: __________-_______ Conta: ________________________________________________<br>Valor: R$_____________,___________. <br> Nos casos que nas seções de fotos ou vídeos forem usados roupas ou acessorios da loja BLACKOUT MAGAZINE, WWW.BLACKOUTMAGAZINE.COM.BR, é de inteira responsabilidade do usuário qualquer dano, por menor que seja, a peça. A verificação do dano fica a critério da loja, havendo este, a peça deve ser adquirida pelo valor de venda.<br> Declaro que autorizo o uso acima descrito sem que nada haja a ser reclamado a título de direitos conexos às imagens ou a qualquer outro, e assino a presente autorização.';
		
		
		$html .= '<br><br><center>_______________________________________<br><b>BLACKOUT MAGAZINE</b> <br> CNPJ 34.368.206/0001-90<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: BLACKOUT2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		
		}else if($tipocache == 2){
			//MAIOR 18 CACHE ABATIDO
			$html = '<center><img src="../images/logo_blackout.png" width="210" height="60"></center>';
		$html .= '<center><h3>Termo de Trabalho</h3></center>';
		$html .= '<br>São Paulo, '.$diaextenso.'<br>';
		$html .= 'Dados do modelo: <br> Eu '.$row_modelo['nome_modelo_cc'].', portador do RG: '.$row_modelo['rg_modelo_cc'].', inscrito no CPF/MF sob: '.$row_modelo['cpf_modelo_cc'].', residente à '.$row_modelo['endereco_cc'].', nº '.$row_modelo['numero_cc'].', complemento: '.$row_modelo['complemento_cc'].', Telefone principal: '.$row_modelo['telefone_residencial_cc'].', Telefone secundário: '.$row_modelo['telefone_celular_cc'].'. <br><br> AUTORIZO o uso de imagem deste pela empresa BLACKOUT MAGAZINE, CNPJ: 34.368.203/0001-90. Em todo e qualquer material, sejam essas destinadas à divulgação ao público em geral. A presente autorização abrange o uso da imagem acima mencionada em todo território nacional, das seguintes formas: (I) out-door, (II) busdoor, (III) folhetos em geral (encartes, mala direta, catálogo, etc ..), (IV) folder de apresentação, (V) anúncios em revistas, (VI) home page, (VII) cartazes, (VIII) black-light, (IX) mídia eletrônica, facebook e instagram (painéis, vídeo-tapes, televisão, cinema, programa para rádio, entre outros).<br><br><center>Informações de Pagamento</center><br>Cachê abatido no valor do material prestado pela Agency Exclusive. <br> Nos casos que nas seções de fotos ou vídeos forem usados roupas ou acessorios da loja BLACKOUT MAGAZINE, WWW.BLACKOUTMAGAZINE.COM.BR, é de inteira responsabilidade do usuário qualquer dano, por menor que seja, a peça. A verificação do dano fica a critério da loja, havendo este, a peça deve ser adquirida pelo valor de venda.<br> Declaro que autorizo o uso acima descrito sem que nada haja a ser reclamado a título de direitos conexos às imagens ou a qualquer outro, e assino a presente autorização.';
		
		
		$html .= '<br><br><center>_______________________________________<br><b>BLACKOUT MAGAZINE</b> <br> CNPJ 34.368.206/0001-90<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		}
	}else if($idade < 18){
		if($tipocache = "pago"){
			


		}else if($tipocache = "abatido"){


			
		}
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
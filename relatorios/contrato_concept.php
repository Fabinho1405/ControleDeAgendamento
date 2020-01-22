<?php	

	
	include_once("../conection/conexao.php");
	$param_contrato = $_GET['cnt'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	
	

	//PESQUISA CONTRATO
	$select_modelo = "SELECT * FROM clientes_concept WHERE contrato_cc = '$param_contrato' LIMIT 1";
	$exec_select_modelo = mysqli_query($conn, $select_modelo);
	$row_modelo = mysqli_fetch_assoc($exec_select_modelo);
	$fechamento_banco = $row_modelo['data_cadastro_cc'];
	$diaextenso = date('d/m/Y', strtotime($fechamento_banco));
	//$diaextenso = strftime('%A, %d de %B de %Y', strtotime('$dia_fechamento'));

	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc'];
	if($idade >= 18){

		if($row_modelo['material_cc'] == "B1"){
			$book_final = "Material Fotográfico Modelo 1:composto por 8 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B2"){
			$book_final = "Material Fotográfico Modelo 2:composto por 12 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B3"){
			$book_final = "Material Fotográfico Modelo 3:composto por 16 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B4"){
			$book_final = "Material Fotográfico Modelo 4:composto por 24 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Agenciamento"){
			$book_final = "Material de Agênciamento: 1 mídia digital contendo todas as fotos do ensaio sendo 5 editadas e o restante sem editar.";
		}else{
			$book_final = $row_modelo['material_cc'];
		};

		$html = '<center><img src="../images/logo_concept.png" width="400" height="133"></center>';
		$html .= '<center><h3>Contrato de Prestação de Serviço</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente, instrumento particular de contrato de prestação de serviço de um lado AGENCY CONCEPT, empresa situada a Rua Ituverava, 137 - Vila Prudente - CEP: 03151-020, São Paulo, inscrita no Cadastro Nacional de Pessoa Jurídica do Ministério da Fazenda (CNPJ/MF) sob o Nº 34.369.138/0001-84. <br>';
		$html .= 'E do outro lado:<br>';
		$html .= 'Sr.(a) <b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b>, portador do RG:'.$row_modelo['rg_modelo_cc'].' e CPF:'.$row_modelo['cpf_modelo_cc'].', nascido(a) aos '.$row_modelo['nascimento_cc'].' com o estado civil:'.$row_modelo['estado_civil_cc'].'.<br>';
		$html .= 'Residente e domiciliado(a) a '.$row_modelo['endereco_cc'].', '.$row_modelo['numero_cc'].', '.$row_modelo['complemento_cc'].', no bairro: '.$row_modelo['bairro_cc'].', CEP: '.$row_modelo['CEP_cc'].', sendo o número de telefone principal: '.$row_modelo['telefone_celular_cc']. ', e telefone secundário: '.$row_modelo['telefone_residencial_cc'].'.<br>';
		$html .= 'Ficou justo e contratado o seguinte: <br>';
		$html .= '1. Prestação de Serviço: <br>';
		$html .= '1.a O primeiro dos acima qualificados, de ora em diante denominado <b> CONTRATADO </b>, se obriga a prestar seus serviços profissionais de elaboração de material fotográfico ao segundo, devidamente qualificado acima, que devorante se denomina <b> CONTRATANTE </b>.<br>';
		$html .= '1.b O serviço aqui especificado refere-se somente as fotografias reveladas: cujos arquivos ficarão em poder da contratada durante o período de 3 mêses após retirada do produto.<br>';
		$html .= '2. Produto:<br>';
		$html .= '2.a O(s) produto(s) escolhido pela CONTRATANTE:<br>';
		$html .= $row_modelo['material_cc'].'(Quantidade = 1)<br>';
		$html .= ''.$book_final.'<br>';
		$html .= '2.b O preço certo e ajustado para prestação de serviço ora contratado segue o valor total de R$'.$row_modelo['valor_material_cc'].',00 sendo pago corretamente da seguinte forma:<br>';
		$html .= '<table border=0>';
		$html .= '<tr>';
		$html .= '<td><b>Parcela</b></td>';
		$html .= '<td><b>Forma de Pagamento<b/></td>';
		$html .= '<td><b>Data de Laçamento</b></td>';
		$html .= '<td><b>Data de Vencimento</b></td>';
		$html .= '<td><b>Valor</b></td>';
		$html .= '<td><b>Data de Baixa</b></td>';
		$html .= '<td><b>Status na Data Vigente</b></td>';
		$html .= '</tr>';
		//PESQUISA FATURAS DO CONTRATO
		$select_faturas = "SELECT * FROM lancamento_concept lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento  WHERE lc.n_contrato_lancamento = '$param_contrato' AND lc.status = '1' ORDER BY lc.tipo_pagamento_lancamento ASC";
		$exec_faturas = mysqli_query($conn, $select_faturas);
		$contagem = 1;
		while($row_fatura = mysqli_fetch_assoc($exec_faturas)){
			if(!empty($row_fatura['created_lancamento'])){
				$novo_lancamento = date('d/m/Y', strtotime($row_fatura['created_lancamento']));
			}else{
				$novo_lancamento = "";
			};
			if(!empty($row_fatura['data_baixa_lancamento'])){
				$nova_baixa = date('d/m/Y', strtotime($row_fatura['data_baixa_lancamento']));
			}else{
				$nova_baixa = "";
			};
			if(!empty($row_fatura['data_agrado_lancamento'])){
				$novo_agrado = date('d/m/Y', strtotime($row_fatura['data_agrado_lancamento']));
			}else{
				$novo_agrado = "";
			}

		$html .= '<tr>';
		$html .= '<td>'.$contagem.'</td>';
		$html .= '<td>'.$row_fatura['descricao_tp'].' </td>';
		$html .= '<td>'.$novo_lancamento.' </td>';
		$html .= '<td>'.$novo_agrado.' </td>';
		$html .= '<td>R$'.$row_fatura['valor_lancamento'].' </td>';		
		$html .= '<td>'.$nova_baixa.' </td>';
		$html .= '<td>'.$row_fatura['descricao_status_lancamento'].' </td>';
		$html .= '</tr>';
		$contagem = $contagem + 1;
		};
		$html .= '</table><br>';
		$html .= '2.c Fica de inteira responsabilidade do CONTRATANTE a retirada do produto em nosso estabelecimento, respeitando o pagamento de 40% do valor total e agendamento prévio. <br>';
		$html .= '2.d O produto será entregue em perfeito estado, e sendo assim, o CONTRATADO, não se responsabiliza por danos causados após a retirada do produto pelo CONTRATANTE. <br>';
		$html .= '3. Contrato: <br>';
		$html .= '3.a O presente contrato não se vincula a nenhuma proposta de trabalho publicitário ou emprego. <br>';
		$html .= '3.b Estando pronto o produto e não retirado, o valor do contrato poderá ser cobrado através do Cartório de Protestos.<br>';
		$html .= '3.c O não pagamento de quaisquer das parcelas sem justificativa legal, implicará de imediato na cobrança dos valores devidos, inicialmente via extra-judicial, e posteriormente se necessário, através de ação judicial.<br>';
		$html .= '3.d Em caso de cancelamento do presente contrato, pelo CONTRATANTE, o mesmo arcará com a multa de 40% do valor contratado, em virtude de gastos já efetivados, uma vez que o CONTRATANTE já foi fotografado, e após o produto estar pronto, não poderá haver cancelamento, exceto como determina no artigo 49 da Lei Federal nº 8.078/CDC. <br>';
		$html .= '3.e Da sessão fotográfica. A sessão fotográfica terá início e será concluida logo após a assinatura do presente contrato, e caso haja necessidade e por motivo de força maior, agendar uma nova data para o término das fotos, o CONTRATANTE deverá comparecer na data designada, sob pena de serem utilizadas as fotografias já realizadas para a confecção das fotos editadas e se houver incluso o material fotográfico.<br>';
		$html .= '4.f Fica eleito o fórum da Comarca de São Paulo para dirimir qualquer dúvida referente a este contrato. E por ambas partes acima estarem de acordo com todas as clausulas do mesmo, firmo o presente contrato em 02 (duas) vias de mesmo teor e forma na presença de 02 (duas) testemunhas para devidos fins legais. <br>';
		$html .= 'Ambos lidos e de comum acordo,';

		
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY CONCEPT</b> <br> CNPJ 34.369.138/0001-84<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: CPT2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		
		//finaliza contrato adulto

	}else if($idade < 18){
		//INICIA CONTRATO DE MENOR DE IDADADE

		if($row_modelo['material_cc'] == "B1"){
			$book_final = "Material Fotográfico Modelo 1:composto por 8 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B2"){
			$book_final = "Material Fotográfico Modelo 2:composto por 12 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B3"){
			$book_final = "Material Fotográfico Modelo 3:composto por 16 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "B4"){
			$book_final = "Material Fotográfico Modelo 4:composto por 24 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Agenciamento"){
			$book_final = "Material de Agênciamento: 1 mídia digital contendo todas as fotos do ensaio sendo 5 editadas e o restante sem editar.";
		}else{
			$book_final = $row_modelo['material_cc'];
		};

		$html = '<center><img src="../images/logo_concept.png" width="400" height="133"></center>';
		$html .= '<center><h3>Contrato de Prestação de Serviço</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente, instrumento particular de contrato de prestação de serviço de um lado AGENCY CONCEPT, empresa situada a Rua Ituverava, 137 - Vila Prudente - CEP: 03151-020, São Paulo, inscrita no Cadastro Nacional de Pessoa Jurídica do Ministério da Fazenda (CNPJ/MF) sob o Nº 34.369.138/0001-84. <br>';
		$html .= 'E do outro lado:<br>';
		$html .= 'Sr.(a) <b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b>, portador do RG:'.$row_modelo['rg_responsavel_cc'].' e CPF:'.$row_modelo['cpf_responsavel_cc'].', responsável legalmente pelo(a) <b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b> portador(a) do RG: '.$row_modelo['rg_modelo_cc'].' e CPF: '.$row_modelo['cpf_modelo_cc'].' nascido(a) aos '.$row_modelo['nascimento_cc'].' com o estado civil:'.$row_modelo['estado_civil_cc'].'.<br>';
		$html .= 'Residente e domiciliado(a) a '.$row_modelo['endereco_cc'].', '.$row_modelo['numero_cc'].', '.$row_modelo['complemento_cc'].', no bairro: '.$row_modelo['bairro_cc'].', CEP: '.$row_modelo['CEP_cc'].', sendo o número de telefone principal: '.$row_modelo['telefone_celular_cc']. ', e telefone secundário: '.$row_modelo['telefone_residencial_cc'].'.<br>';
		$html .= 'Ficou justo e contratado o seguinte: <br>';
		$html .= '1. Prestação de Serviço: <br>';
		$html .= '1.a O primeiro dos acima qualificados, de ora em diante denominado <b> CONTRATADO </b>, se obriga a prestar seus serviços profissionais de elaboração de material fotográfico ao segundo, devidamente qualificado acima, que devorante se denomina <b> CONTRATANTE </b>.<br>';
		$html .= '1.b O serviço aqui especificado refere-se somente as fotografias reveladas: cujos arquivos ficarão em poder da contratada durante o período de 3 mêses após retirada do produto.<br>';
		$html .= '2. Produto:<br>';
		$html .= '2.a O(s) produto(s) escolhido pela CONTRATANTE:<br>';
		$html .= $row_modelo['material_cc'].'(Quantidade = 1)<br>';
		$html .= ''.$book_final.'<br>';
		$html .= '2.b O preço certo e ajustado para prestação de serviço ora contratado segue o valor total de R$'.$row_modelo['valor_material_cc'].',00 sendo pago corretamente da seguinte forma:<br>';
		$html .= '<table border=0>';
		$html .= '<tr>';
		$html .= '<td><b>Parcela</b></td>';
		$html .= '<td><b>Forma de Pagamento<b/></td>';
		$html .= '<td><b>Data de Laçamento</b></td>';
		$html .= '<td><b>Data de Vencimento</b></td>';
		$html .= '<td><b>Valor</b></td>';
		$html .= '<td><b>Data de Baixa</b></td>';
		$html .= '<td><b>Status na Data Vigente</b></td>';
		$html .= '</tr>';
		//PESQUISA FATURAS DO CONTRATO
		$select_faturas = "SELECT * FROM lancamento_concept lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento  WHERE lc.n_contrato_lancamento = '$param_contrato' AND lc.status = '1' ORDER BY lc.tipo_pagamento_lancamento ASC";
		$exec_faturas = mysqli_query($conn, $select_faturas);
		$contagem = 1;
		while($row_fatura = mysqli_fetch_assoc($exec_faturas)){
			if(!empty($row_fatura['created_lancamento'])){
				$novo_lancamento = date('d/m/Y', strtotime($row_fatura['created_lancamento']));
			}else{
				$novo_lancamento = "";
			};
			if(!empty($row_fatura['data_baixa_lancamento'])){
				$nova_baixa = date('d/m/Y', strtotime($row_fatura['data_baixa_lancamento']));
			}else{
				$nova_baixa = "";
			};
			if(!empty($row_fatura['data_agrado_lancamento'])){
				$novo_agrado = date('d/m/Y', strtotime($row_fatura['data_agrado_lancamento']));
			}else{
				$novo_agrado = "";
			}

		$html .= '<tr>';
		$html .= '<td>'.$contagem.'</td>';
		$html .= '<td>'.$row_fatura['descricao_tp'].' </td>';
		$html .= '<td>'.$novo_lancamento.' </td>';
		$html .= '<td>'.$novo_agrado.' </td>';
		$html .= '<td>R$'.$row_fatura['valor_lancamento'].' </td>';		
		$html .= '<td>'.$nova_baixa.' </td>';
		$html .= '<td>'.$row_fatura['descricao_status_lancamento'].' </td>';
		$html .= '</tr>';
		$contagem = $contagem + 1;
		};
		$html .= '</table><br>';
		$html .= '2.c Fica de inteira responsabilidade do CONTRATANTE a retirada do produto em nosso estabelecimento, respeitando o pagamento de 40% do valor total e agendamento prévio. <br>';
		$html .= '2.d O produto será entregue em perfeito estado, e sendo assim, o CONTRATADO, não se responsabiliza por danos causados após a retirada do produto pelo CONTRATANTE. <br>';
		$html .= '3. Contrato: <br>';
		$html .= '3.a O presente contrato não se vincula a nenhuma proposta de trabalho publicitário ou emprego. <br>';
		$html .= '3.b Estando pronto o produto e não retirado, o valor do contrato poderá ser cobrado através do Cartório de Protestos.<br>';
		$html .= '3.c O não pagamento de quaisquer das parcelas sem justificativa legal, implicará de imediato na cobrança dos valores devidos, inicialmente via extra-judicial, e posteriormente se necessário, através de ação judicial.<br>';
		$html .= '3.d Em caso de cancelamento do presente contrato, pelo CONTRATANTE, o mesmo arcará com a multa de 40% do valor contratado, em virtude de gastos já efetivados, uma vez que o CONTRATANTE já foi fotografado, e após o produto estar pronto, não poderá haver cancelamento, exceto como determina no artigo 49 da Lei Federal nº 8.078/CDC. <br>';
		$html .= '3.e Da sessão fotográfica. A sessão fotográfica terá início e será concluida logo após a assinatura do presente contrato, e caso haja necessidade e por motivo de força maior, agendar uma nova data para o término das fotos, o CONTRATANTE deverá comparecer na data designada, sob pena de serem utilizadas as fotografias já realizadas para a confecção das fotos editadas e se houver incluso o material fotográfico.<br>';
		$html .= '4.f Fica eleito o fórum da Comarca de São Paulo para dirimir qualquer dúvida referente a este contrato. E por ambas partes acima estarem de acordo com todas as clausulas do mesmo, firmo o presente contrato em 02 (duas) vias de mesmo teor e forma na presença de 02 (duas) testemunhas para devidos fins legais. <br>';
		$html .= 'Ambos lidos e de comum acordo,';

		
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY CONCEPT</b> <br> CNPJ 34.369.138/0001-84 <br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b><br>CPF '.$row_modelo['cpf_responsavel_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: CPT2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;

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
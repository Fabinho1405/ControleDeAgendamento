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
	$diaextenso = date('d/m/Y', strtotime($fechamento_banco));
	//$diaextenso = strftime('%A, %d de %B de %Y', strtotime('$dia_fechamento'));

	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc']; 
	if($idade >= 18){

		if($row_modelo['material_cc'] == "Basic"){
			$book_final = "Material Fotográfico Modelo Basic:composto por 6 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Classic"){
			$book_final = "Material Fotográfico Modelo Classic:composto por 10 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Elegance"){
			$book_final = "Material Fotográfico Modelo Elegance:composto por 20 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Exclusive"){
			$book_final = "Material Fotográfico Modelo Exclusive:composto por 30 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Agenciamento"){
			$book_final = "Material de Agênciamento: 1 mídia digital contendo todas as fotos do ensaio sendo 5 editadas e o restante sem editar.";
		}else{
			$book_final = $row_modelo['material_cc'];
		};

		if($row_modelo['poster_cc'] == 1){
			$book_final .=" + 1 (um) Pôster Adesivo no tamanho 130cm x 80cm onde será entregue após o modelo escolher dentre as fotos editadas a que será impressa no mesmo.";
		}else{

		};

		$html = '<div id="container" style="width=200px;"><center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Contrato de Prestação de Serviço</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente instrumento particular de contrato as partes abaixo qualificadas, a saber: <br>';
		$html .= '<b>CONTRATANTE:</b>'.mb_strtoupper($row_modelo['nome_modelo_cc'])." inscrito no CPF: ".$row_modelo['cpf_modelo_cc']." e portador da cédula de RG: ".$row_modelo['rg_modelo_cc']." residente no endereço ".$row_modelo['endereco_cc'].", Nº ".$row_modelo['numero_cc'].", ".$row_modelo['complemento_cc']." do bairro ".$row_modelo['bairro_cc']." situado na cidade de São Paulo - SP, CEP: ".$row_modelo['CEP_cc'].", tendo como telefone principal: ".$row_modelo['telefone_residencial_cc']." e telefone secundário: ".$row_modelo['telefone_celular_cc']."<br>";
		$html .= '<b>CONTRATADA:</b> AGENCY EXCLUSIVE, empresa situada a Rua Coronel Luis Americano, Nº 250 - Tatuapé - CEP: 03308-020, São Paulo - SP, incrita no Cadastro Nacional de Pessoa Jurídica do Minitério da Fazenda (CNPJ/MF) sob o Nº 32.473.749/0001 - 42, representada neste ato por quem de direito. <br>';
		$html .= 'As partes acima identificadas têm, entre si, justo e acertado o presente Contrato de Prestação de Serviços, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente. <br>';
		$html .= '<b>CLÁUSULA 1º. </b> A CONTRATADA se obriga a prestar seus serviços profissionais de elaboração de material fotográfico a CONTRATANTE, devidamente qualificada acima.<br>';
		$html .= '<b>CLÁUSULA 2º. </b> O(s) produto(s) escolhido(os) pela CONTRATANTE: <br>';
		$html .= $row_modelo['material_cc'].'(Quantidade = 1)<br>';
		$html .= ''.$book_final.'<br>';
		$html .= '<b>CLÁUSULA 3º. </b> Pela prestação de serviços e aquisição do produto ora contratado, a CONTRATANTE pagará o valor de R$'.$row_modelo['valor_material_cc'].',00 sendo pago corretamente da seguinte forma: <br>';
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
		$select_faturas = "SELECT * FROM lancamento_exclusive lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento  WHERE lc.n_contrato_lancamento = '$param_contrato' AND lc.status = '1' ORDER BY lc.data_agrado_lancamento ASC";
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
		$html .= '<b>PARÁGRAFO SEGUNDO. </b> O atraso no pagamento de quaisquer das parcelas acima acordadas, sujeitará a CONTRATANTE ao pagamento da multa de 2% (dois por cento) sobre o valor do débito, bem como juros moratórios de 1% (um por cento) ao mês e correção monetária do período em favor da CONTRATADA. <br>';
		$html .= '<b>PARÁGRAFO TERCEIRO. </b> Sem prejuizo ao parágrafo anterior, o atraso no pagamento de qualquer parcela a 30 (trinta) dias, ensejará a inclusão do CPF do CONTRATANTE junto aos órgãos de proteção ao crédito, sem aviso prévio. <br>';
		$html .= '<b>CLÁUSULA 4º. </b> A entrega do produto será liberada após o pagamento de 40% (quarenta por cento) do valor total e agendamento prévio. <br>';
		$html .= '<b>PARÁGRAFO PRIMEIRO. </b> É de inteira responsabilidade da CONTRATANTE a retirada do produto, que será entregue em perfeito estado, e sendo assim, a CONTRATADA, não se responsabiliza por danos causados após a retirada do produto pelo CONTRATANTE. <br>';
		$html .= '<b>PARÁGRAFO SEGUNDO. </b> A mídia digital, quando adquirida, só irá conter as fotos referentes ao material revelado. No caso de conter fotos além da quantidade do produto contratado, as mesmas serão entregues no estado original da Sessão Fotográfica, sem edição, tratamento ou qualquer tipo de manipulação.<br>';
		$html .= '<b> PARÁGRAFO TERCEIRO. </b> Estando pronto o produto e não retirado dentro do prazo de 90 (noventa) dias por culpa exclusiva da CONTRATANTE, o valor acordado acima será cobrado integralmente, por via extrajudicial ou judicial, e ainda, o material poderá ser descartado pela CONTRATADA. <br>';
		$html .= '<b>CLÁUSULA 5º.  </b> Salvo motivo de força maior, em caso de recisão do presente contrato por culpa exclusiva da CONTRATANTE, o mesmo arcará com a multa de 30% (trinta por cento) do valor contratado. O cancelamento só será aceito mediante o comparecimento do CONTRATANTE no estabelecimento da CONTRATADA. <br>';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> Após o produto estar pronto não poderá haver a rescisão do presente contrato, exceto no determinado no artigo 49 da Lei Federal nº 8.078/CDC. <br>';
		$html .= '<b>CLÁUSULA 6º. </b> A sessão fotográfica terá inicio e será concluida logo após a assinatura do presente contrato.';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> Por motivo de força maior, sendo necessário o agendamento de nova data para o término das fotos, o CONTRATANTE deverá comparecer na data designada, sob pena de serem utilizadas as fotografias já realizadas para a confecção do Book (caso tenha sido contratado). <br>';
		$html .= '<b>CLÁUSULA 7º. </b> O direito autoral e uso de imagem da foto referente à sessão fotográfica é cedido ao CONTRATANTE, sendo o uso, divulgação e distribuição das imagens de direito do mesmo.<br>';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> A CONTRATADA poderá utilizar em qualquer momento as imagens realizadas na sessão fotográfica em suas redes sociais, páginas de internet, bancos de dados internos e bancos de dados de divulgação a terceiros, pelo período vigente de 1(um) ano, caso não haja desistência de ambas as partes. <br>';
		$html .= '<b>CLÁUSULA 8º. </b>Fica compactuada entre as partes a total inexistência de vinculo trabalhista, excluindo as obrigações previdenciárias e os encargos sociais, não havendo entre CONTRATANTE e CONTRATADA qualquer tipo de relação de subordinação. <br>';
		$html .= '<b>CLÁUSULA 9º. </b> Não se estabelece por força do presente instrumento nenhum tipo de sociedade, associação, agência, consórcio ou responsabilidade solidária entre a CONTRATANTE e a CONTRATADA, seja comerical, civil, criminal, trabalista ou previdenciário. <br>';
		$html .= '<b>CLÁUSULA 10º. </b> Para dirimir quaisquer controvérsias oriundas do presente contrato as partes elegem o Foro Central da Comarca de São Paulo - SP Capital.<br>';
		$html .= 'Por estarem assim juntos e contratados, firmam o presente instrumento, em duas vias de igual teor, juntamente com 2 (duas) testemunhas.';		
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
		$html .= '</div>';
		//finaliza contrato adulto

	}else if($idade < 18){
		//INICIA CONTRATO DE MENOR DE IDADADE
		if($row_modelo['material_cc'] == "Basic"){
			$book_final = "Material Fotográfico Modelo Basic:composto por 6 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Classic"){
			$book_final = "Material Fotográfico Modelo Classic:composto por 10 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Elegance"){
			$book_final = "Material Fotográfico Modelo Elegance:composto por 20 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Exclusive"){
			$book_final = "Material Fotográfico Modelo Exclusive:composto por 30 fotos impressas no tamanho (24x30) em uma pasta personalizada, 1 foto contato no tamanho (24x30) e uma mídia digital contendo todo o ensaio fotográfico incluindo as fotos editadas e não editadas.";
		}else if($row_modelo['material_cc'] == "Agenciamento"){
			$book_final = "Material de Agênciamento: 1 mídia digital contendo todas as fotos do ensaio sendo 5 editadas e o restante sem editar.";
		}else{
			$book_final = $row_modelo['material_cc'];
		};
		
		if($row_modelo['poster_cc'] == 1){
			$book_final .=" + 1 (um) Pôster Adesivo no tamanho 130cm x 80cm onde será entregue após o modelo escolher dentre as fotos editadas a que será impressa no mesmo.";
		}else{

		};

		$html = '<center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Contrato de Prestação de Serviço</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Pelo presente instrumento particular de contrato as partes abaixo qualificadas, a saber: <br>';
		$html .= '<b>CONTRATANTE:</b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).", portador(a) da cédula de RG:".$row_modelo['rg_responsavel_cc'].", inscrito no CPF: ".$row_modelo['cpf_responsavel_cc'].", perante a meios judiciais legalmente responsável por ". mb_strtoupper($row_modelo['nome_modelo_cc'])." inscrito no CPF: ".$row_modelo['cpf_modelo_cc']." e portador da cédula de RG: ".$row_modelo['rg_modelo_cc']." ambos residentes no endereço ".$row_modelo['endereco_cc'].", Nº ".$row_modelo['numero_cc'].", ".$row_modelo['complemento_cc']." do bairro ".$row_modelo['bairro_cc']." situado na cidade de São Paulo - SP, CEP: ".$row_modelo['CEP_cc'].", tendo como telefone principal: ".$row_modelo['telefone_residencial_cc'] ." e telefone secundário: ".$row_modelo['telefone_celular_cc']."<br>";
		$html .= '<b>CONTRATADA:</b> AGENCY EXCLUSIVE, empresa situada a Rua Coronel Luis Americano, Nº 250 - Tatuapé - CEP: 03308-020, São Paulo - SP, incrita no Cadastro Nacional de Pessoa Jurídica do Minitério da Fazenda (CNPJ/MF) sob o Nº 32.473.749/0001 - 42, representada neste ato por quem de direito. <br>';
		$html .= 'As partes acima identificadas têm, entre si, justo e acertado o presente Contrato de Prestação de Serviços, que se regerá pelas cláusulas seguintes e pelas condições descritas no presente. <br>';
		$html .= '<b>CLÁUSULA 1º. </b> A CONTRATADA se obriga a prestar seus serviços profissionais de elaboração de material fotográfico a CONTRATANTE, devidamente qualificada acima.<br>';
		$html .= '<b>CLÁUSULA 2º. </b> O(s) produto(s) escolhido(os) pela CONTRATANTE: <br>';
		$html .= $row_modelo['material_cc'].'(Quantidade = 1)<br>';
		$html .= ''.$book_final.'<br>';
		$html .= '<b>CLÁUSULA 3º. </b> Pela prestação de serviços e aquisição do produto ora contratado, a CONTRATANTE pagará o valor de R$'.$row_modelo['valor_material_cc'].',00 sendo pago corretamente da seguinte forma: <br>';
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
		$select_faturas = "SELECT * FROM lancamento_exclusive lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento  WHERE lc.n_contrato_lancamento = '$param_contrato' AND lc.status = '1' ORDER BY lc.tipo_pagamento_lancamento ASC";
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
		$html .= '<b>PARÁGRAFO SEGUNDO. </b> O atraso no pagamento de quaisquer das parcelas acima acordadas, sujeitará a CONTRATANTE ao pagamento da multa de 2% (dois por cento) sobre o valor do débito, bem como juros moratórios de 1% (um por cento) ao mês e correção monetária do período em favor da CONTRATADA. <br>';
		$html .= '<b>PARÁGRAFO TERCEIRO. </b> Sem prejuizo ao parágrafo anterior, o atraso no pagamento de qualquer parcela a 30 (trinta) dias, ensejará a inclusão do CPF do CONTRATANTE junto aos órgãos de proteção ao crédito, sem aviso prévio. <br>';
		$html .= '<b>CLÁUSULA 4º. </b> A entrega do produto será liberada após o pagamento de 40% (quarenta por cento) do valor total e agendamento prévio. <br>';
		$html .= '<b>PARÁGRAFO PRIMEIRO. </b> É de inteira responsabilidade da CONTRATANTE a retirada do produto, que será entregue em perfeito estado, e sendo assim, a CONTRATADA, não se responsabiliza por danos causados após a retirada do produto pelo CONTRATANTE. <br>';
		$html .= '<b>PARÁGRAFO SEGUNDO. </b> A mídia digital, quando adquirida, só irá conter as fotos referentes ao material revelado. No caso de conter fotos além da quantidade do produto contratado, as mesmas serão entregues no estado original da Sessão Fotográfica, sem edição, tratamento ou qualquer tipo de manipulação.<br>';
		$html .= '<b> PARÁGRAFO TERCEIRO. </b> Estando pronto o produto e não retirado dentro do prazo de 90 (noventa) dias por culpa exclusiva da CONTRATANTE, o valor acordado acima será cobrado integralmente, por via extrajudicial ou judicial, e ainda, o material poderá ser descartado pela CONTRATADA. <br>';
		$html .= '<b>CLÁUSULA 5º.  </b> Salvo motivo de força maior, em caso de recisão do presente contrato por culpa exclusiva da CONTRATANTE, o mesmo arcará com a multa de 30% (trinta por cento) do valor contratado. O cancelamento só será aceito mediante o comparecimento do CONTRATANTE no estabelecimento da CONTRATADA. <br>';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> Após o produto estar pronto não poderá haver a rescisão do presente contrato, exceto no determinado no artigo 49 da Lei Federal nº 8.078/CDC. <br>';
		$html .= '<b>CLÁUSULA 6º. </b> A sessão fotográfica terá inicio e será concluida logo após a assinatura do presente contrato.';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> Por motivo de força maior, sendo necessário o agendamento de nova data para o término das fotos, o CONTRATANTE deverá comparecer na data designada, sob pena de serem utilizadas as fotografias já realizadas para a confecção do Book (caso tenha sido contratado). <br>';
		$html .= '<b>CLÁUSULA 7º. </b> O direito autoral e uso de imagem da foto referente à sessão fotográfica é cedido ao CONTRATANTE, sendo o uso, divulgação e distribuição das imagens de direito do mesmo.<br>';
		$html .= '<b>PARÁGRAFO ÚNICO. </b> A CONTRATADA poderá utilizar em qualquer momento as imagens realizadas na sessão fotográfica em suas redes sociais, páginas de internet, bancos de dados internos e bancos de dados de divulgação a terceiros, pelo período vigente de 1(um) ano, caso não haja desistência de ambas as partes. <br>';
		$html .= '<b>CLÁUSULA 8º. </b>Fica compactuada entre as partes a total inexistência de vinculo trabalhista, excluindo as obrigações previdenciárias e os encargos sociais, não havendo entre CONTRATANTE e CONTRATADA qualquer tipo de relação de subordinação. <br>';
		$html .= '<b>CLÁUSULA 9º. </b> Não se estabelece por força do presente instrumento nenhum tipo de sociedade, associação, agência, consórcio ou responsabilidade solidária entre a CONTRATANTE e a CONTRATADA, seja comerical, civil, criminal, trabalista ou previdenciário. <br>';
		$html .= '<b>CLÁUSULA 10º. </b> Para dirimir quaisquer controvérsias oriundas do presente contrato as partes elegem o Foro Central da Comarca de São Paulo - SP Capital.<br>';
		$html .= 'Por estarem assim juntos e contratados, firmam o presente instrumento, em duas vias de igual teor, juntamente com 2 (duas) testemunhas.';		
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b><br>CPF '.$row_modelo['cpf_responsavel_cc'].'</center><br><br><br><br><br>';

		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_responsavel_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;	 

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
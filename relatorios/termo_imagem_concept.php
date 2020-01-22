<?php	

	
	include_once("../conection/conexao.php");
	$param_contrato = $_GET['cnt'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	$diaextenso = strftime('%A, %d de %B de %Y', strtotime('today'));

	//PESQUISA CONTRATO
	$select_modelo = "SELECT * FROM clientes_concept WHERE contrato_cc = '$param_contrato' LIMIT 1";
	$exec_select_modelo = mysqli_query($conn, $select_modelo);
	$row_modelo = mysqli_fetch_assoc($exec_select_modelo);

	//VERIFICA A IDADE DO MODELO
	$idade = $row_modelo['idade_cc'];
	if($idade >= 18){
		$html = '<center><img src="../images/logo_concept.png" width="350" height="133"></center>';
		$html .= '<center><h3>Termo de Autorização de Divulgação de Imagem</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Autorizo a Agência de Modelos AGENCY CONCEPT, situada a Rua Ituverava, 137- Vila Prudente - CEP: 03151-020, São Paulo, SP, CNPJ: 32.369.138/0001-84, a divulgação de imagem do(a)'.mb_strtoupper($row_modelo['nome_modelo_cc']).', com nascimento aos '.$row_modelo['nascimento_cc'].', pelo período de 1(um) ano a contar da data de retirada do Material Fotográfico conforme a 1º cláusula do contrato, na seção de Modelos no Site, consultar como nome artístico no endereço eletrônico, http://www.agencyconcept.com.br onde os clientes terão livre acesso para consultar as fotos. <br> Estou ciente que a agência NÃO prometeu qualquer tipo de trabalho, e sim a minha divulgação em nosso site na página de Modelos. A escolha é única e exclusiva do cliente que acessa e escolhe o modelo que agrada a composição do seu casting. <br> Cachê <br> Todo trabalho que o modelo realizar por intermédio da agência 29% do valor total ficará com a mesma e 71% com o modelo, livre de impostos. <br> Booker <br> Compromete-se o modelo ainda informar com antecedência o departamento booker da agência, quaisquer alterações de medidas e visuais que vierem acontecer. Sendo que isto não implicará ônus para nenhuma das partes. <br> Estou ciente que neste 1(um) ano que estarei agenciado(a), posso ser chamado(a) para vários trabalhos, como também posso não ser chamado para nenhum. Pois como já citado a decisão é única e exclusiva do cliente que contrata a agência. <br> Comprometimento <r> Quando o modelo é selecionado para um trabalho, é importante o comprometimento no local indicado para a realização do mesmo, pois o cliente reserva uma equipe/estrutura com equipamentos para a realização do eventual trabalho. Caso o modelo não consiga comparecer, deverá informar o booker ou produtor que entrou em contato com ele pelo menos com 72 horas de antecedência.';			
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY CONCEPT</b> <br> CNPJ 34.369.138/0001-84<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_modelo_cc']).'</b><br>CPF '.$row_modelo['cpf_modelo_cc'].'</center><br><br><br><br><br>';
		$html .= 'AUTENTICAÇÃO DE SISTEMA: CPT2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
	}else if($idade < 18){
		$html = '<center><img src="../images/logo_concept.png" width="350" height="133"></center>';
		$html .= '<center><h3>Termo de Autorização de Divulgação de Imagem</h3></center>';
		$html .= '<br><br>São Paulo, '.$diaextenso.'<br><br>';
		$html .= 'Autorizo a Agência de Modelos AGENCY CONCEPT, situada a Rua Ituverava, 137- Vila Prudente - CEP: 03151-020, São Paulo, SP, CNPJ: 32.369.138/0001-84, a divulgação de imagem do(a)'.mb_strtoupper($row_modelo['nome_modelo_cc']).', com nascimento aos '.$row_modelo['nascimento_cc'].', pelo período de 1(um) ano a contar da data de retirada do Material Fotográfico conforme a 1º cláusula do contrato, na seção de Modelos no Site, consultar como nome artístico no endereço eletrônico, http://www.agencyconcept.com.br onde os clientes terão livre acesso para consultar as fotos. <br> Estou ciente que a agência NÃO prometeu qualquer tipo de trabalho, e sim a minha divulgação em nosso site na página de Modelos. A escolha é única e exclusiva do cliente que acessa e escolhe o modelo que agrada a composição do seu casting. <br> Cachê <br> Todo trabalho que o modelo realizar por intermédio da agência 29% do valor total ficará com a mesma e 71% com o modelo, livre de impostos. <br> Booker <br> Compromete-se o modelo ainda informar com antecedência o departamento booker da agência, quaisquer alterações de medidas e visuais que vierem acontecer. Sendo que isto não implicará ônus para nenhuma das partes. <br> Estou ciente que neste 1(um) ano que estarei agenciado(a), posso ser chamado(a) para vários trabalhos, como também posso não ser chamado para nenhum. Pois como já citado a decisão é única e exclusiva do cliente que contrata a agência. <br> Comprometimento <r> Quando o modelo é selecionado para um trabalho, é importante o comprometimento no local indicado para a realização do mesmo, pois o cliente reserva uma equipe/estrutura com equipamentos para a realização do eventual trabalho. Caso o modelo não consiga comparecer, deverá informar o booker ou produtor que entrou em contato com ele pelo menos com 72 horas de antecedência.';			
		$html .= '<br><br><br><br><center>_______________________________________<br><b>AGENCY CONCEPT</b> <br> CNPJ 34.369.138/0001-84<br><br><br>_______________________________________ <br><b>'.mb_strtoupper($row_modelo['nome_responsavel_cc']).'</b><br>CPF '.$row_modelo['cpf_responsavel_cc'].'</center><br><br><br><br><br>';
		$html .= 'AUTENTICAÇÃO DE SISTEMA: CPT2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato;
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
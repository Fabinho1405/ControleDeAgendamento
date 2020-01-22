<?php	

	
	include_once("../conection/conexao.php");
	$param_contrato = $_GET['cnt'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	$diaextenso = strftime('%A, %d de %B de %Y', strtotime('today')); 

	//PESQUISA CONTRATO
	$select_modelo = "SELECT * FROM clientes_exclusive WHERE contrato_cc = '$param_contrato' LIMIT 1";
	$exec_select_modelo = mysqli_query($conn, $select_modelo);
	$row_modelo = mysqli_fetch_assoc($exec_select_modelo);

	//VERIFICA A IDADE DO MODELO



		$html = '<center><img src="../images/logo_exclusive.png" width="250" height="250"></center>';
		$html .= '<center><h3>Termo de Retirada de Material</h3></center>';
		$html .= '<br>São Paulo, '.$diaextenso.'<br>';
		$html .= 'Pelo presente termo de retirada de material, de um lado a CONTRATADA citada no contrato '.$param_contrato.' e do outro lado o(a) CONTRATANTE também citado no mesmo. Ambos assinados e filiados a uma prestação de serviço desde '.date("d/m/Y", strtotime($row_modelo['data_cadastro_cc'])).', e permanecem até a presente data, dada como concluida a etapa de criação do material fotográfico '.$row_modelo['material_cc'].' e sendo retirado hoje pela parte CONTRATANTE seguindo a vigência de contrato e o que o mesmo descreve. <br> A parte CONTRATANTE confirma com a assinatura deste que o material mantém o padrão descrito e encontra-se em perfeito estado para o uso publicitário podendo usufruir da forma que bem entender. Após a retirada a CONTRATADA se exime de qualquer claudicação progênito de mau uso ou descuido por parte da CONTRATANTE. Sem observações mais, solicita-se para formalizar o termo que o responsável autorizado pelo(a) CONTRATANTE ou o mesmo presente na retirada preencha a punho abaixo. <br><br> Eu ____________________________________________ portador(a) da cédula de CPF: ____________________________________ informo para quaisquer fins a retirada do produto oferecido pela Agency Exclusive na data de ________ de _________________________ de '.date("Y", strtotime('today')).' o mesmo encontra-se em perfeito estado e concluo com total concordância o descritivo acima.';

		$html .= '<br><br><br><center>_______________________________________<br><b>AGENCY EXCLUSIVE</b> <br> CNPJ 32.473.749/0001-42<br><br><br>_______________________________________ <br><b>Responsável:</b><br>CPF _____________________________ </center><br><br><br>';
		$html .= 'AUTENTICAÇÃO DE SISTEMA: EXCL2019'.strftime('%d%m%Y', strtotime('today')).$row_modelo['cpf_modelo_cc'].$row_modelo['valor_material_cc'].'-'.$param_contrato; 
	
	
	

	
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
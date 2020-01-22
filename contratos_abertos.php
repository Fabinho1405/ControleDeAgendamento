<?php
	include_once("conection/conexao.php");

	$select_contratos = "SELECT * FROM clientes_concept";
	$exec_contratos = mysqli_query($conn, $select_contratos);

	while($contrato = mysqli_fetch_assoc($exec_contratos)){
		$ncontrato = $contrato['contrato_cc'];

		$select_cobrancas = "SELECT * FROM lancamento_concept WHERE n_contrato_lancamento = '$ncontrato'";
		$exec_cobrancas = mysqli_query($conn, $select_cobrancas);		
		$valorfaltante = 0;
		while($cobranca = mysqli_fetch_assoc($exec_cobrancas)){
			$valorfaltante = $valorfaltante + $cobranca['valor_lancamento'];
		};
		$finalfaltante = $contrato['valor_material_cc'] - $valorfaltante;
		if($finalfaltante <> 0){
			echo "<br>(Nª) ".$ncontrato." - (ValT)".$contrato['valor_material_cc']." - ";
			echo "(ValL)".$valorfaltante." - (ValF)".$finalfaltante;
		}else{

		};
	};


?>
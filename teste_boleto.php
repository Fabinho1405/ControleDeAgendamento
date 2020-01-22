<?php
	include_once("conection/conexao.php");
	$idfuncionario = 1;
	$ncontrato = 1;
	$valortotalB = 259;
	$nparcela = 4;
	$data_att = '2019-12-20';
	
	$array_parcelas =  array($nparcela);
	$array_datas = array($nparcela);

	echo "TOTAL: ".$valortotalB."<br>PARCELAS:".$nparcela."<br>";
	
	$i = 1;	
	$valor_parcela = round($valortotalB / $nparcela, 2);
	while($i <= $nparcela){
		$array_parcelas[$i] = $valor_parcela;
		$data_att = date('Y-m-d', strtotime("+1 month", strtotime($data_att)));
		$array_datas[$i] = $data_att;
		$i++;
	};

	$total_conf = 0;
	$j = 1;
	while($j <= $nparcela){
		$total_conf = $total_conf + $array_parcelas[$j];
		$j++;
	};

	$faltante = $valortotalB - $total_conf;
	$array_parcelas[1] = $array_parcelas[1] + $faltante;

	echo "<br><br><br>VALOR REAL DAS PARCELAS: ";
	$k = 2;

	echo "<br>1º -".$array_parcelas[1]." - ".$array_datas[1];

	$parcela1valor = $array_parcelas[1];
	$parcela1data = $array_datas[1];
	$insert_parcela = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcela1valor', 1, $idfuncionario, '$ncontrato','$parcela1data',NOW())";
	$exec_insert_parcela = mysqli_query($conn, $insert_parcela);

	while($k <= $nparcela){
		$parcelavalor = $array_parcelas[$k];
		$parceladata = $array_datas[$k];

		$insert_parcela_resto = "INSERT INTO lancamento_concept (tipo_pagamento_lancamento, valor_lancamento, status_lancamento, func_lancamento, n_contrato_lancamento, data_agrado_lancamento, created_lancamento) VALUES (3, '$parcelavalor', 1, $idfuncionario, '$ncontrato','$parceladata',NOW())";
		$exec_parcela_resto = mysqli_query($conn, $insert_parcela_resto);


		echo "<br>".$k."ª -".$array_parcelas[$k]." - ".$array_datas[$k];
		$k++;
	};





	
?>
<?php 
	echo 
	"
		<style>
			fieldset { display: inline; top: 20px;};
		</style>
	";
	$dia = $_GET['data'];

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	$diaextenso = strftime('%A, %d de %B de %Y', strtotime($dia));
	include_once("../conection/conexao.php");
	echo "<center><img src='../images/logo_concept.png' width='400' height='133'></center>";
	echo "<center><h3> Extrato Diario Vigente </h3></center>";
	echo "<center>Sao Paulo, ".$diaextenso."</center><br>";
	

	$tipopg = 1;
	
	$array_total = array(1,2,3,4,5,6,7);
	//LANCAMENTOS DO DIA (CONTRATOS FECHADOS)
	echo "<center>";
	echo "<fieldset style='width:400px;'><legend>Lancamentos</legend>";
	while($tipopg <= 7){
		$select_entradas = "SELECT * FROM lancamento_concept lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.created_lancamento) = '$dia' AND lc.tipo_pagamento_lancamento = '$tipopg' AND lc.status='1'";
		$exec_entradas = mysqli_query($conn, $select_entradas);
		$qtd_entradas = mysqli_num_rows($exec_entradas);

		$select_pagamentos = "SELECT * FROM tipo_pagamento WHERE id_tp = '$tipopg'";
		$exec_pagamentos = mysqli_query($conn, $select_pagamentos);
		$row_nomes = mysqli_fetch_assoc($exec_pagamentos);
		echo "<br><b>".$row_nomes['descricao_tp']."</b>";
		$total = 0;
		if($qtd_entradas <> 0){
			
			while($row_detalhes = mysqli_fetch_assoc($exec_entradas)){
				echo "<br>".$row_detalhes['n_contrato_lancamento']." - R$".$row_detalhes['valor_lancamento'];
				
				$total = $total + $row_detalhes['valor_lancamento'];
			}
			$array_total[$tipopg] = $total;
			echo "<br>Total: R$".$total;

		}else{
			$array_total[$tipopg] = 0;
			echo "<br>Nenhuma entrada para pagamento.";
		}
		echo "<br>-----------------------------------------";
		
	$tipopg++;

	 
	};
	$total_lancamento = $array_total[1] + $array_total[2] + $array_total[3] + $array_total[4] + $array_total[5] + $array_total[6] + $array_total[7];
		echo "<br> Total: R$".$total_lancamento;
	echo "</fieldset>";

	//PAGAMENTOS FEITOS (DE OUTRAS DATAS)
	$tipopg_pag = 1;
	$array_total_pag = array(1,2,3,4,5,6,7);
	echo "<fieldset style='width:400px;'><legend>Pagamentos</legend>";
	while($tipopg_pag <= 7){
		$select_entradas_pag = "SELECT * FROM lancamento_concept lc INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE lc.tipo_pagamento_lancamento = '$tipopg_pag' AND lc.status_lancamento = 2 AND date(lc.data_baixa_lancamento) = '$dia' AND date(lc.created_lancamento) <> date(lc.data_baixa_lancamento) AND lc.status='1'";
		$exec_entradas_pag = mysqli_query($conn, $select_entradas_pag);
		$qtd_entradas_pag = mysqli_num_rows($exec_entradas_pag);

		$select_pagamentos_pag = "SELECT * FROM tipo_pagamento WHERE id_tp = '$tipopg_pag'";
		$exec_pagamentos_pag = mysqli_query($conn, $select_pagamentos_pag);
		$row_nomes = mysqli_fetch_assoc($exec_pagamentos_pag);
		echo "<br><b>".$row_nomes['descricao_tp']."</b>";
		$total_pag = 0;
		if($qtd_entradas_pag <> 0){
			
			while($row_detalhes = mysqli_fetch_assoc($exec_entradas_pag)){
				echo "<br>".$row_detalhes['n_contrato_lancamento']." - R$".$row_detalhes['valor_lancamento'];
				
				$total_pag = $total_pag + $row_detalhes['valor_lancamento'];
			}
			$array_total_pag[$tipopg_pag] = $total_pag;
			echo "<br>Total: R$".$total_pag;

		}else{
			$array_total_pag[$tipopg_pag] = 0;
			echo "<br>Nenhuma entrada para pagamento.";
		}
		echo "<br>-----------------------------------------";
	$tipopg_pag++;

	 
	};
	$total_pagamento = $array_total_pag[1] + $array_total_pag[2] + $array_total_pag[3] + $array_total_pag[4] + $array_total_pag[5] + $array_total_pag[6] + $array_total_pag[7];
		echo "<br> Total: R$".$total_pagamento;
	echo "</fieldset>";
	$select_despesas = "SELECT * FROM despesas_concept WHERE date(created_despesa) = '$dia'";
	$exec_despesas = mysqli_query($conn, $select_despesas);
	$total_despesas = 0;

	echo "<fieldset style='width:800px;'> <legend> Despesas </legend>";
		while($row_despesas = mysqli_fetch_assoc($exec_despesas)){

			echo "<br>#".$row_despesas['id_despesas']." - ".$row_despesas['descricao_despesa']." - R$".$row_despesas['valor_despesa'];
			$total_despesas = $total_despesas + $row_despesas['valor_despesa'];

		};
	echo "<br>Total de Despesas: R$".$total_despesas;
	echo "</fieldset>";


	//FINALIZACAO
	echo "<fieldset style='width:800px;'> <legend>Valores Reais</legend>";
	$final_dinheiro = $array_total[1] + $array_total_pag[1];
	echo "<br>Dinheiro: ".$final_dinheiro;
	$final_cheque = $array_total[2]+$array_total_pag[2];
	echo "<br>Cheque: ".$final_cheque;
	$final_boleto = $array_total[3]+$array_total_pag[3];
	echo "<br>Boleto Bancario: ".$final_boleto;
	$final_cartao_debito = $array_total[4]+$array_total_pag[4];
	echo "<br>Cartao de Debito: ".$final_cartao_debito;
	$final_cartao_credito = $array_total[5]+$array_total_pag[5];
	echo "<br>Cartao de Credito: ".$final_cartao_credito;
	$final_transferencia = $array_total[6]+$array_total_pag[6];
	echo "<br>Transferencia Bancaria: ".$final_transferencia;
	$final_vu = $array_total[7]+$array_total_pag[7];
	echo "<br>Via Unica: ".$final_vu;

	echo "</center>";
	$totalCVC=$final_dinheiro+$final_cartao_credito+$final_cartao_debito+$final_transferencia;
	echo "<center><h2>TOTAL CVC:".$totalCVC." </h2></center>";
	echo "</fieldset>";





?>
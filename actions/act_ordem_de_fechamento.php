<?php
	ob_start();
	echo "<center><h3> Resumo de Inserção ao Banco de Dados </h3></center>";

	$idcliente = $_POST['idcliente'];
	$idprodutor = $_POST['idprodutor'];
	$valorfechamento = $_POST['valorfechamento'];
	$boleto = $_POST['boleto'];
	$valorboleto = $_POST['valor_boleto'];
	$datavencimento = $_POST['data_vencimento_boleto'];
	$qtdvezesboleto = $_POST['quantidade_vezes_boleto'];

	$bandeiracartao = $_POST['bandeira'];
	$qtdvezescartao = $_POST['quantidade_vezes_cartao'];
	$valorcartao = $_POST['valor_cartao'];

	echo "Id do Cliente:".$idcliente."<br>";
	echo "Id do Produtor:".$idprodutor."<br>";
	echo "Valor de Fechamento:".$valorfechamento."<br>";
	echo "Boleto Bancário?:".$boleto."<br>";
	echo "<hr>";
	echo "Valor Total de Boleto: ".$valorboleto * $qtdvezesboleto."<br>";
	$i = 0;

	function somar_datas( $numero, $tipo ){
		  switch ($tipo) {
		    case 'd':
		    	$tipo = ' day';
		    	break;
		    case 'm':
		    	$tipo = ' month';
		    	break;
		    case 'y':
		    	$tipo = ' year';
		    	break;
		    }	
		    return "+".$numero.$tipo;
		};

		$ultimadata = $datavencimento;
	while($i < $qtdvezesboleto){		
		$parcela = $i + 1;
		echo "<b>Nº Parcela: " .$parcela."</b><br>";
		echo "Valor da Parcela: ".$valorboleto."<br>";
		$date_sum_month= date('d/m/Y', strtotime('+1 month', strtotime($ultimadata)));	
		echo $date_sum_month."<br>";
		$ultimadata = $date_sum_month;

		$i++;
	};

	echo "<hr>";
	echo "Pagamento em Cartão: "."<br>";
	echo "Bandeira do Cartão: ".$bandeiracartao."<br>";
	echo "Valor Total em Cartão: ".$valorcartao."<br>";
	echo "Quantidade de Vezes: ".$qtdvezescartao;
	echo "<hr>";

	






?>
<!DOCTYPE html>
<html>
<head>
	<title>Teste TM</title>
</head>
<body>
	<h2> Ticket Médio </h2>
	<form action="" method="POST">
		<label>Data Inicial:</label>
		<input type="date" name="dtinicial">
		<label>Data Final:</label>
		<input type="date" name="dtfinal">
		<label>Scouter:</label>
		<select>
			<option></option>
		</select>
		<input type="submit" name="relatorio" value="Puxar Relatório">
	</form>
	<?php

		if(!empty($_POST['relatorio'])){
			$datainicial = $_POST['dtinicial'];
			$datafinal = $_POST['dtfinal'];

			

			$data1 = new DateTime($datainicial);
			$data2 = new DateTime($datafinal);

			$intervalo = $data1->diff( $data2 );

			//echo "Intervalo é de {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
			echo "<br> {$intervalo->d} dias de intervalo";

			$quantidade_agendados = "";

		}else{

		}
	?>
</body>
</html>
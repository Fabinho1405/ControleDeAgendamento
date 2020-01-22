<!DOCTYPE html>
<html>
<head>
	<title>Nova Bonificação</title>

</head>
<body>
	<form method="post" action="">
		<label>Quantidade de Agendados: </label>
		<input type="text" name="qtd_agendados">
		<input type="submit" name="enviar">		
	</form>
</body>
</html>
<?php
	if(!empty($_POST['enviar'])){

	$agendados = $_POST['qtd_agendados'];

	echo $agendados."<br>";

	if($agendados <= 25){
		echo "Pontos: 0";
	}else if($agendados > 25 && $agendados <= 30){
		$pontos = ($agendados-25) * 1.50;
		echo "Pontos: ".$pontos;
	}else if($agendados > 30 && $agendados <= 40){
		$bon_anterior = 7.50;
		$pontos = ($agendados - 30) * 2.50;
		$final = $pontos + $bon_anterior;
		echo "Pontos:".$final;
	}else if($agendados > 40 && $agendados <= 50){
		$bon_anterior = 32.50;
		$pontos = ($agendados - 40) * 3.50;
		$final = $pontos + $bon_anterior;
		echo "Pontos: ".$final;
	}else if($agendados > 50){
		$bon_anterior = 67.50;
		$pontos = ($agendados - 50) * 5.00;
		$final = $pontos + $bon_anterior;
		echo "Pontos: ".$final;
	}
}
?>
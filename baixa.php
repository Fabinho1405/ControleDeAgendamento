<!DOCTYPE html>
<html>
<head>
	<title>Baixa</title>
</head>
<body>
	<?php 
		$baixa = $_POST['id_baixa'];
		include_once("conection/conexao.php");
		$update_lancamento = "UPDATE lancamento_concept SET status_lancamento = '2', data_baixa_lancamento = NOW() WHERE id_lancamento = '$baixa'";
		$exec_update_lancamento = mysqli_query($conn, $update_lancamento);
	?>
	<form name="baixa" action="" method="POST">
		<input type="text" name="id_baixa">
		<input type="submit" name="enviar" value="Baixa">		
	</form>

</body>
</html>
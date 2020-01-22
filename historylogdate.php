<!DOCTYPE html>
<html>
<head>
	<title>History LOG</title>
</head>
<body>
	<?php
		$data = $_GET['data'];
		include_once("conection/conexao.php");

		$select_log = "SELECT * FROM logs log
		INNER JOIN funcionario fun ON log.id_func = fun.id_func
		WHERE date(datetime_log) = '$data' ORDER BY id_log DESC";
		$exec_log = mysqli_query($conn, $select_log);

		while ($row_log = mysqli_fetch_assoc($exec_log)){			
			echo "<br />>".$row_log['id_log']."[".$row_log['ip_user']."][".$row_log['datetime_log']."][USER:".$row_log['id_func'].".".current(str_word_count($row_log['nome_completo_func'], 2))."][TYP:".$row_log['tipo_log']."][LOG:".$row_log['mensagem_log']."]";
			
		};
	?>

</body>
</html>


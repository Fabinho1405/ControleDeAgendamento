
<html>
	<head>
		<title>Legal</title>
	</head>
	<body>
		<center>
		<h3>Extração de Planilha para Confirmação </h3>
		<form action="gerar_planilha.php" method="GET">
			<label>Data</label>
			<input type="date" name="dataget">
			<br><br>
			<label>Unidade:</label>
			<select name="uniget">
				<option value="1">Matriz</option>
				<option value="2">Lapa</option>
				<option value="3">Impact</option>
			</select>
			<br><br>
			<input type="submit" name="" value="Baixar">
		</form>
	</center>
	</body>

</html>
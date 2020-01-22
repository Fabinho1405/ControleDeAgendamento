
<!DOCTYPE html>
<html>
<head>
	<title>Marcar Presença</title>
</head>
<body>
	<center>
		<h2> Selecione a Data e Unidade </h2>
	<form method="GET" action="MarcarAquiPresenca.php"> 
		Data: 
		<input type="date" name="dataConfirmacao">
		<br><br>
		Unidade:
		<select name="unidade">
			<option value="1">Matriz</option>
			<option value="4">Concept</option>
		</select>
		<br><br>
		<input type="submit" name="" value="Pesquisar Dia">
	</form>
</center>
</body>
</html>
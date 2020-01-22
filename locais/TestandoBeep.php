<?php
	include_once("../conection/connection.php");
	$pdo=conectar();

	$verificaMateriais=$pdo->prepare("SELECT * FROM clientes_exclusive");


?>
<!DOCTYPE html>
<html>
<head>
	<title>Gravação Teste</title>
	<?php
        //echo "<meta HTTP-EQUIV='refresh' CONTENT='4;URL=TestandoBeep.php'>";
    ?>
</head>
<body>
	<?php

		if($verificaMateriais->execute()){
	?>
		<embed src='beep.mp3' width='1' height='1'>
	<?php
		};
	?>
		
</body>
</html>
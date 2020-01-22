
<form action="" method="POST">
<input type="text" name="senha">
<input type="submit" value="gerar" name="envio">

</form>
<?php
echo "<b> GERAÇÃO DE SENHA CRIPTOGRAFADA </b><br />";

$senha = $_POST['senha'];

if(isset($_POST['envio'])){	
	echo $senha."<br />";
	echo password_hash("$senha", PASSWORD_DEFAULT);
}


?>

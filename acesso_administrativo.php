<?php
	session_start();
	include_once("conection/conexao.php");

	echo "<h3> Senha Administrativa </h3>";
	echo 
	"
		<form method='post' name='admin' action='' autocomplete='off'>
			<input type='password' name='senha_modificar'>
			<br>
			<input type='submit' value='Prosseguir' name='submit'>
		</form>
	";


	if(isset($_POST['submit'])){
		$senha = $_POST['senha_modificar'];
		$contrato = $_GET['ncontrato'];
		$select_administrativo = "SELECT * FROM funcionario WHERE senha_administrativa = '$senha' LIMIT 1";
		$exec_senha_admin = mysqli_query($conn, $select_administrativo);
		$qtd_senha_admin = mysqli_num_rows($exec_senha_admin);
		$row_autorizado = mysqli_fetch_assoc($exec_senha_admin);

		if($qtd_senha_admin == 1){
			 $_SESSION['gerencial'] = 1;
			 $_SESSION['nome_gerencial'] = $row_autorizado['nome_completo_func'];
			  header("Location: modificar_contrato.php?ncontrato=$contrato");
		}else{
			echo "Senha administrativa não encontrada.";
		}
	}else{

	}

?>
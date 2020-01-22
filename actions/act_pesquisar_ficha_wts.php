<?php
	include_once("../conection/conexao.php");

	$tipo = $_POST['filtro'];
	$parametro = $_POST['parametro'];
	if(empty($tipo)){
		header("Location: ../pesquisar_ficha.php");
		echo "<script> alert('Tipo Vazio'); </script>";
	}else if(empty($parametro)){
		header("Location: ../pesquisar_ficha.php");
		echo "<script> alert('Parâmetro Vazio'); </script>";
	}else if(!empty($tipo) && !empty($parametro)){
		if($tipo == 1){
			$pesquisa_ficha = "SELECT * FROM controle_fichas WHERE nome_responsavel_controle LIKE '%$parametro%'";
			$result_parametro = mysqli_query($conn, $pesquisa_ficha);
			while($row_parametro = mysqli_fetch_assoc($result_parametro)){
				echo $row_parametro['nome_responsavel_controle']."<br />";
			};
		}else if($tipo == 2){
			$pesquisa_ficha = "SELECT * FROM controle_fichas WHERE telefone_principal_controle LIKE '%$parametro%'";
			$result_parametro = mysqli_query($conn, $pesquisa_ficha);
			while ($row_parametro = mysqli_fetch_assoc($result_parametro)){
				echo $row_parametro['nome_responsavel_controle']."/".$row_parametro['telefone_principal_controle']."<br />";
				$idficha = $row_parametro['id_controle'];
				echo "<a href='teste.php?idficha=$idficha'> Agendar </a>";				
			}
		}
	}



?>
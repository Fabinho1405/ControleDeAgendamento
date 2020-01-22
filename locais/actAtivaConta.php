<?php
	
	include_once("../conection/connection.php");
	$pdo=conectar();

	$id=$_GET['id'];
	$proc=$_GET['proc'];
	try{
		if($proc == 1){
			$updateConta=$pdo->prepare("UPDATE funcionario SET acesso_direto='1' WHERE id_func=:funcionario");
			$updateConta->bindValue(":funcionario", $id);
			$updateConta->execute();
			
		}elseif($proc == 2){
			$updateConta=$pdo->prepare("UPDATE funcionario SET acesso_direto='0' WHERE id_func=:funcionario");
			$updateConta->bindValue(":funcionario", $id);
			$updateConta->execute();
		}

		header("Location:colaboradoresACT.php");
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>
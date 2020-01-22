
<?php
        session_start();

        $globalclienteid = $_SESSION['id_global_cliente'];
        $idfuncionario = $_SESSION[''];

		$conn = new mysqli("localhost", "root", "","dbmodels");
		mysqli_set_charset($conn,"utf8");

		$arquivo 	= $_FILES["file"]["tmp_name"];
        $nome 		= $_FILES["file"]["name"];
        $tamanho 	= $_FILES["file"]["size"];


        $fp = fopen($arquivo,"rb");//Abro o arquivo que está no $temp   
    	$documento = fread($fp, $tamanho);//Leio o binario do arquivo
    	fclose($fp);//fecho o arquivo

		$dados = bin2hex($documento);

		$caminho = "ARQUIVOS/".$nome;

        move_uploaded_file($arquivo, $caminho);


		$sql = "INSERT INTO arquivos (nome, tamanho, conteudo, id_func, id_cliente, id_status_sistema, data_cadastro) VALUES ('$nome','$tamanho','$dados', 7 , $globalclienteid , 1 ,now())";

     	$result = $conn->query($sql)or die(mysqli_errno());

?>
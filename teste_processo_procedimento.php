<?php
	include_once("conection/conexao.php");

	//TELA APARECERÁ PARA O PRODUTOR ENQUANTO ESTIVER EM ATENDIMENTO
	$idprocedimento = $_GET['id_pd'];
	echo "<h2> ATENDENDO AGORA </h2>";
	$info_atendimento = "SELECT * FROM procedimento_diario pd INNER JOIN cliente cli ON pd.id_cliente = cli.id_cliente WHERE pd.id_pd = '$idprocedimento'";
	$exec_info_atendimento = mysqli_query($conn, $info_atendimento);
	while($row_atendimento = mysqli_fetch_assoc($exec_info_atendimento)){
		echo $row_atendimento['nome_cliente']." - ";
		echo $row_atendimento['inicio_procedimento']." - ";
		echo "<a href='actions/act_procedimento_diario.php?pcdm=2&idpcdm=$idprocedimento'>Finalizar Procedimento</a>";
	}







?>
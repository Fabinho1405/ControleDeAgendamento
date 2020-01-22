<?php
 include_once("conection/conexao.php");


echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=teste_pegar_procedimento.php'>";

 echo "<center><h2> PEGAR PROCEDIMENTOS </h2></center>";

 $libera_procedimento = "SELECT * FROM procedimento_diario pd INNER JOIN cliente cli ON pd.id_cliente = cli.id_cliente WHERE pd.procedimento = '1' AND pd.processo_procedimento = '0'";
$exec_libera_procedimento = mysqli_query($conn, $libera_procedimento);
while($row_procedimento = mysqli_fetch_assoc($exec_libera_procedimento)){
	echo $row_procedimento['id_cliente']." - ";
	echo $row_procedimento['nome_cliente']." - ";
	$idprocedimento = $row_procedimento['id_pd'];
	echo "<a href='actions/act_procedimento_diario.php?pcdm=1&idpcdm=$idprocedimento'>Pegar Procedimento </a><br><br><br>";
};
?>
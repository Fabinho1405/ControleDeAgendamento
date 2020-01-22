<?php


/*function salvaLog($mensagem) {

//$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante

// Usamos o mysql_escape_string() para poder inserir a mensagem no banco
//   sem ter problemas com aspas e outros caracteres
//$mensagem = mysqli_real_escape_string($conn, $mensagem);
// Monta a query para inserir o log no sistema
$insert_log = "INSERT INTO logs VALUES (NULL, NOW(), $ip, $mensagem)";
$exec_sql = mysqli_query($conn, $insert_log);

};

$mensagem = "TESTE";
salvaLog($mensagem);
echo "OK";
*/

	function cadLog($mensagem){
		include_once('conection/conexao.php');
		header('Content-Type: text/html; charset=utf-8');
		$ip = $_SERVER['REMOTE_ADDR'];
		$insert_log = "INSERT INTO logs (id, hora, ip, mensagem) VALUES (NULL, NOW(), '$ip', 'INSERT-> $mensagem');";
		$exec_insert_log = mysqli_query($conn, $insert_log);
	};

?>
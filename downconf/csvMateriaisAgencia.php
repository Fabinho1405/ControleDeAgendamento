  <?php
	session_start();
	include_once("../conection/connection.php");
	
	$pdo=conectar();

	$dataHoje=date("d/m/Y");

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Baixar Planilha</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'MateriaisProntos-'.$dataHoje.'.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		
		
		$selectMateriais=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE status_cc=:statusContrato");
		$selectMateriais->bindValue(":statusContrato", 13);
		$selectMateriais->execute();
		$linhaMateriais=$selectMateriais->fetchAll(PDO::FETCH_OBJ);

		
		foreach($linhaMateriais as $rowMateriais){
			$html .= '<tr>';
			$html .= '<td>'.$rowMateriais->contrato_cc.'</td>';
			$html .= '<td>'.$rowMateriais->telefone_residencial_cc.'</td>';
			$html .= '</tr>';
			;
		}

		$html .="</table>";
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; 

		?>
	</body>
</html>
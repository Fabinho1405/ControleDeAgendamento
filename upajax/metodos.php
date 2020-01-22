<?php
	$conn = new mysqli("localhost", "root", "","documentos");
	mysqli_set_charset($conn,"utf8");

	$metodo = $_POST["metodo"];


	switch ($metodo) {
		case 'LISTAR_ARQUIVOS':
			
			$result = $conn->query("SELECT id_arquivo, nome, tamanho, data FROM arquivos");

			while ($arquivo = mysqli_fetch_object($result)) {
				echo "<tr>
						<td>".$arquivo->id_arquivo."</td>
						<td>".$arquivo->nome."</td>
						<td>".$arquivo->tamanho."</td>
						<td>".$arquivo->data."</td>
						<td><a href='visualizar_arquivo.php?id_arquivo=".$arquivo->id_arquivo."' target='_blank'><img src='IMG/pdf.png' style='width:30px; height:30px;cursor:pointer;'></a></td>

					</tr>";
			}

		break;
	
	}


?>
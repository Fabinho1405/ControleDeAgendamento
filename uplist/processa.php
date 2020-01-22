<?php

	include_once("../conection/conexao.php");
	
	//$dados = $_FILES['arquivo'];
	//var_dump($dados);
	
	if(!empty($_FILES['arquivo']['tmp_name'])){
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);
		
		$primeira_linha = true;
		$total=0;
		$totalMatriz=0;
		$totalConcept=0;

		foreach($linhas as $linha){
			if($primeira_linha == false){
				$nome_responsavel = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
				//echo "Responsável: $nome_responsavel -";
				
				$nome_modelo = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
				//echo "Modelo: $nome_modelo - ";
				
				$telefone_principal = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				//echo "Telefone Principal: $telefone_principal - ";

				$telefone_secundario = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
				//echo "Telefone Secundario: $telefone_secundario - ";

				$url_imagem = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
				//echo "Url Imagem: $url_imagem - ";

				$stand_by = $linha->getElementsByTagName("Data")->item(5)->nodeValue;
				//echo "Stand By: $stand_by - ";

				$unid_stand_by = $linha->getElementsByTagName("Data")->item(6)->nodeValue;
				//echo "Unid_Stand_By: $unid_stand_by - ";

				$procedimento = $linha->getElementsByTagName("Data")->item(7)->nodeValue;
				//echo "Procedimento: $procedimento - ";	

				$tipoficha = $linha->getElementsByTagName("Data")->item(8)->nodeValue;
				//echo "Tipo_Ficha: $tipoficha - ";		
				
				$func = $linha->getElementsByTagName("Data")->item(9)->nodeValue;
				//echo "Tipo_Ficha: $tipoficha - ";	
				
								
				//echo "<hr>";
				$total += 1;

				if($unid_stand_by == 1){
					$totalMatriz += 1;
				}else if($unid_stand_by == 4){
					$totalConcept += 1;
				};

				//Inserir o usuário no BD FICHA DIRECIONADA
				$result_usuario = "INSERT INTO controle_ligacao (nome_responsavel_controle, nome_modelo_controle, telefone_principal_controle, telefone_secundario_controle, url_picture, stand_by, unid_stand_by,id_procedimento, id_extracao, created, id_status_sistema, tipo_ficha, id_func) VALUES ('$nome_responsavel', '$nome_modelo', '$telefone_principal', '$telefone_secundario','$url_imagem' ,'$stand_by', '$unid_stand_by','$procedimento','0', NOW(), 1, '$tipoficha', '$func')";

				//$result_usuario = "INSERT INTO controle_fichas (nome_responsavel_controle, nome_modelo_controle, telefone_principal_controle, telefone_secundario_controle, id_func, id_extracao, created, fb_1, fb_2, fb_3, fb_4, fb_5, fb_6, fb_7, id_status_sistema, fb_1_hour, fb_2_hour, fb_3_hour, fb_4_hour, fb_5_hour, fb_6_hour, fb_7_hour) VALUES ('$nome_responsavel', '$nome_modelo', '$telefone_principal', '$telefone_secundario', '999','0', NOW(), '1','0','0','0','0','0','0','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
				$resultado_usuario = mysqli_query($conn, $result_usuario);
			}
			$primeira_linha = false;
		}
		echo "Fichas Enviadas Com Sucesso!<br>";
		echo "Total de Fichas: ".$total;
		echo "<br>Total Matriz: ".$totalMatriz." - ".round(($totalMatriz*100)/$total, 2)."%";
		echo "<br> Total Concept: ".$totalConcept." - ".round(($totalConcept*100)/$total, 2)."%";
	}
?>
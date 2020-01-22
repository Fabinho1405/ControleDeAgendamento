<?php
	session_start();
	ob_start();
	include_once("../conection/conexao.php");
	include_once("../conection/connection.php");
	$pdo=conectar();

	$unidade_recep = $_SESSION['unidade'];
	$idagendamento = $_GET['idagd'];
	$idfuncionario = $_SESSION['id_usuario'];

	if($unidade_recep == 4){
	$update_presenca = "UPDATE agendamentos SET id_comparecimento = '1' WHERE id_agendamentos = '$idagendamento'";
	$exec_update_presenca = mysqli_query($conn, $update_presenca);

	$selecionar_agendamento = "SELECT * FROM agendamentos WHERE id_agendamentos = '$idagendamento'";
	$exec_selecionar_agendamento = mysqli_query($conn, $selecionar_agendamento);
	$row_agendamento = mysqli_fetch_assoc($exec_selecionar_agendamento);
	
	$id_cliente =  $row_agendamento['id_cliente'];
	$id_agendamento = $row_agendamento['id_agendamentos'];
	
	$insert_chegada = "INSERT INTO acompanhamento_concept(`id_cliente`, `id_agendamento`, `recepcao`, `hora_chegada`) VALUES ('$id_cliente', '$id_agendamento', '1', NOW())";
	$exec_insert_chegada = mysqli_query($conn, $insert_chegada);

	//LOG                                   
		$ip_log = $_SERVER['REMOTE_ADDR'];
		$idfuncionario = $_SESSION['id_usuario'];
		$insert_log = "INSERT INTO logs_exclusive (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'cliente comparecido -> AGC:$unidade_recep | AGD: $idagendamento', 'ALERTA', '$idfuncionario');";
		$exec_insert_log = mysqli_query($conn, $insert_log);
    //FIM LOG


	$_SESSION['msgpres'] = "<div class='alert alert-success' role='alert'>
                                  Presença Registrada com Sucesso!
                             </div>";

	header("Location:../marcar_presenca.php");
	}else if($unidade_recep == 1){
		$upgradeAgendamento=$pdo->prepare("UPDATE agendamentos SET id_comparecimento=:comparecimento, recep_comparecimento=:idFuncionario WHERE id_agendamentos=:idAgendamento");
		$upgradeAgendamento->bindValue(":comparecimento", 1, PDO::PARAM_INT);
		$upgradeAgendamento->bindValue(":idFuncionario", $idfuncionario, PDO::PARAM_INT);
		$upgradeAgendamento->bindValue(":idAgendamento", $idagendamento, PDO::PARAM_INT);
		$upgradeAgendamento->execute();

		$selectAgendamento=$pdo->prepare("SELECT * FROM agendamentos WHERE id_agendamentos=:idAgendamento");
		$selectAgendamento->bindValue(":idAgendamento", $idagendamento, PDO::PARAM_INT);
		$selectAgendamento->execute();
		$listaAgendamento=$selectAgendamento->fetch(PDO::FETCH_OBJ);
		$idCliente=$listaAgendamento->id_cliente;
		$idAgendamento=$listaAgendamento->id_agendamentos;
		echo "ID DO AGENDAMENTO: ".$listaAgendamento->id_agendamentos;
		echo " <br> ID DO CLIENTE: ".$listaAgendamento->id_cliente;


		//SELECIONA PRODUTOR
		$unidade=$unidade_recep;
		$verificarProdutores=$pdo->prepare("SELECT * FROM funcionario WHERE date(primeiro_acesso_dia) = date(NOW()) AND menu_produtor=:menuProdutor AND id_unidade=:idUnidade ORDER BY primeiro_acesso_dia ASC");
		$verificarProdutores->bindValue(":menuProdutor", 1, PDO::PARAM_INT);
		$verificarProdutores->bindValue(":idUnidade", $unidade, PDO::PARAM_INT);
		$verificarProdutores->execute();

		$listarProdutor=$verificarProdutores->fetchAll(PDO::FETCH_OBJ);
		$i=0;
		$vetProd[]=array();
		echo "<br>ORDEM REAL";
		foreach($listarProdutor as $rowProdutor){
			$primeiroAcesso=date("H", strtotime($rowProdutor->primeiro_acesso_dia));
			if($primeiroAcesso < 10){
				//CASO TENTE ACESSAR ANTES DAS 10H
			}else{
				echo "<br>".$rowProdutor->id_func;
				echo " - ".$rowProdutor->nome_completo_func;

				$vetProd[$i]=$rowProdutor->id_func;
				$i++;
			}
		}
		$totalProd = count($vetProd);
		echo "<br>Total Atendendo: ".$totalProd;
		$verificarUltimoAtendimento=$pdo->prepare("SELECT * FROM acompanhamento_exclusive WHERE date(hora_chegada) = date(NOW()) ORDER BY id_acompanhamento DESC LIMIT 1");
		$verificarUltimoAtendimento->execute();
		$qtdUltimoAtendimento=$verificarUltimoAtendimento->rowCount();
		echo "<br>QUANTIDADE ULTIMO ATENDIMENTO:".$qtdUltimoAtendimento;

		if($qtdUltimoAtendimento >= 1){
		$rowUltimoAtendimento=$verificarUltimoAtendimento->fetch(PDO::FETCH_OBJ);
		$ultimoAtendeu=$rowUltimoAtendimento->sugest_atendimento;
		echo "<br><br> ORDEM UM DEPOIS DO ULTIMO QUE ATENDEU";
		$chaveUltimo=array_search($ultimoAtendeu, $vetProd);
		echo "<br>Ultimo que atendeu: ".$ultimoAtendeu." / CHAVE: ".$chaveUltimo;

		$chaveProximo=$chaveUltimo+1;

		if($chaveProximo >= $totalProd){
			$proximoAtender=$vetProd[0];
		}else{
			$proximoAtender=$vetProd[$chaveProximo];
		}
		}else{
			$proximoAtender=$vetProd[0];
		}
		echo "<BR>PROXIMO A ATENDER: ".$proximoAtender;

		$insertChegada=$pdo->prepare("INSERT INTO acompanhamento_exclusive(id_cliente, sugest_atendimento, id_agendamento, recepcao, hora_chegada)VALUES(:idCli,:sugestAtendimento, :idAg, :recepcao, NOW())");
		$insertChegada->bindValue(":idCli", $idCliente, PDO::PARAM_INT);
		$insertChegada->bindValue(":sugestAtendimento", $proximoAtender, PDO::PARAM_INT);
		$insertChegada->bindValue(":idAg", $idAgendamento, PDO::PARAM_INT);
		$insertChegada->bindValue(":recepcao", 1, PDO::PARAM_INT);
		$insertChegada->execute();

		//FIM DE SELEÇÃO DE PRODUTOR    

		$_SESSION['msgcad'] = "<div class='alert alert-success' role='alert'>
                                            Presença Marcada com Sucesso!
        </div>";

        //LOG                                   
             $ip_log = $_SERVER['REMOTE_ADDR'];
             $idfuncionario = $_SESSION['id_usuario'];
             $insert_log = "INSERT INTO logs (datetime_log, ip_user, mensagem_log, tipo_log, id_func) VALUES (NOW(), '$ip_log', 'marcou presenca do cliente | CLI: $idcliente | AG: $idagendamento | UNID: $unidade_recep', 'ALERTA', '$idfuncionario');";
             $exec_insert_log = mysqli_query($conn, $insert_log);
         //FIM LOG
        header("Location:../marcar_presenca.php");

	}else{
		echo "recepção sem programação";
	};
?>
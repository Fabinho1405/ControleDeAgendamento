<?php
    ob_start();
	session_start();
	include_once("../conection/conexao.php");
    include_once("../conection/connection.php");
    $pdo=conectar();

	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];
    $contrato = $_GET['cnt'];
    $processo = $_GET['pcs'];

    if($unidadefunc == 1){	
        $motivoLog="";
        $descricaoLog="";

        // header("Location: ".$_SERVER['HTTP_REFERER']."");


    	if($processo == 1){ 
    		//Encaminha Material para Fila da Gráfica e Marca no LOG de contratos
            $materialEditado=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 8, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute(); 
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para aguardar envio para gráfica.";
    		header("Location: ../fila_edicao.php");
    	}else if($processo == 2){
    		//Encaminha Material para Fila de Produção e Marca no LOG de contratos
            $materialEnviadoGrafica=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, em_grafica_cc = NOW() WHERE contrato_cc=:contrato");
            $materialEnviadoGrafica->bindValue(":status", 9, PDO::PARAM_INT);
            $materialEnviadoGrafica->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEnviadoGrafica->execute();
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para produção na gráfica.";
    		header("Location: ../fila_aguardando_envio.php");
    	}else if($processo == 3){
    		//Encaminha Material para Fila de Retirada e Marca LOG de contratos
            $encaminhaRetirada=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, na_agencia_cc = NOW() WHERE contrato_cc=:contrato");
            $encaminhaRetirada->bindValue(":status", 10, PDO::PARAM_INT);
            $encaminhaRetirada->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $encaminhaRetirada->execute();
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para ligação de retirada.";

    		header("Location: ../fila_em_grafica.php");
    	}else if($processo == 4){
            //Volta o material para a fila de edição
            $materialEditado=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 1, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute();
            $motivoLog="Retrocesso";
            $descricaoLog="Material foi retornado para a fila de edição.";
            header("Location: ../fila_aguardando_envio.php");
        }else if($processo == 5){
            //Volta o material para editar novamente.
            $materialEditado=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 1, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute();
            $motivoLog="Retrocesso";
            $descricaoLog="Material mal avaliado foi retornado para fila de edição.";
            header("Location: ../fila_em_grafica.php");
        }else{

        }

        $insereLOG=$pdo->prepare("INSERT INTO log_producao_exclusive(contrato_cc, motivo_pd, descricao_pd, created_pd) VALUES(:contrato, :motivoPd, :descricaoPd, NOW())");
        $insereLOG->bindValue(":contrato", $contrato, PDO::PARAM_INT);
        $insereLOG->bindValue(":motivoPd", $motivoLog, PDO::PARAM_STR);
        $insereLOG->bindValue(":descricaoPd", $descricaoLog, PDO::PARAM_STR);
        $insereLOG->execute();




    }else if($unidadefunc == 4){

         $motivoLog="";
        $descricaoLog="";

        // header("Location: ".$_SERVER['HTTP_REFERER']."");


        if($processo == 1){ 
            //Encaminha Material para Fila da Gráfica e Marca no LOG de contratos
            $materialEditado=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 8, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute();
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para aguardar envio para gráfica.";
            header("Location: ../fila_edicao.php");
        }else if($processo == 2){
            //Encaminha Material para Fila de Produção e Marca no LOG de contratos
            $materialEnviadoGrafica=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, em_grafica_cc = NOW() WHERE contrato_cc=:contrato");
            $materialEnviadoGrafica->bindValue(":status", 9, PDO::PARAM_INT);
            $materialEnviadoGrafica->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEnviadoGrafica->execute();
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para produção na gráfica.";
            header("Location: ../fila_aguardando_envio.php");
        }else if($processo == 3){
            //Encaminha Material para Fila de Retirada e Marca LOG de contratos
            $encaminhaRetirada=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, na_agencia_cc = NOW() WHERE contrato_cc=:contrato");
            $encaminhaRetirada->bindValue(":status", 10, PDO::PARAM_INT);
            $encaminhaRetirada->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $encaminhaRetirada->execute();
            $motivoLog="Avanço";
            $descricaoLog="Material foi avançado para ligação de retirada.";

            header("Location: ../fila_em_grafica.php");
        }else if($processo == 4){
            //Volta o material para a fila de edição
            $materialEditado=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 1, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute();
            $motivoLog="Retrocesso";
            $descricaoLog="Material foi retornado para a fila de edição.";
            header("Location: ../fila_aguardando_envio.php");
        }else if($processo == 5){
            //Volta o material para editar novamente.
            $materialEditado=$pdo->prepare("UPDATE clientes_concept SET status_cc=:status, editado_cc=NOW() WHERE contrato_cc=:contrato");
            $materialEditado->bindValue(":status", 1, PDO::PARAM_INT);
            $materialEditado->bindValue(":contrato", $contrato, PDO::PARAM_INT);
            $materialEditado->execute();
            $motivoLog="Retrocesso";
            $descricaoLog="Material mal avaliado foi retornado para fila de edição.";
            header("Location: ../fila_em_grafica.php");
        }else{

        }

        $insereLOG=$pdo->prepare("INSERT INTO log_producao_concept(contrato_cc, motivo_pd, descricao_pd, created_pd) VALUES(:contrato, :motivoPd, :descricaoPd, NOW())");
        $insereLOG->bindValue(":contrato", $contrato, PDO::PARAM_INT);
        $insereLOG->bindValue(":motivoPd", $motivoLog, PDO::PARAM_STR);
        $insereLOG->bindValue(":descricaoPd", $descricaoLog, PDO::PARAM_STR);
        $insereLOG->execute();


    }






?>
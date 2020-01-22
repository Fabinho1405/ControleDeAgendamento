<?php

    session_start();
    ob_start();
	include_once("../conection/connection.php");
	$pdo=conectar();

	//Variáveis GET
	$idRetorno=$_GET['idret']; //Id do retorno
	$nContrato=$_GET['cnt']; //Número do contrato

	//Variáveis GLOBAIS
	$idFuncionario = $_SESSION['id_usuario']; //Id do Funcionario
    $unidade = $_SESSION['unidade']; //Id da Unidade

    //Verifica a Unidade
    if($unidade == 1){ 
    	try{
    	//Marca presença no Retorno
    	$presencaRetorno=$pdo->prepare("UPDATE retorno_exclusive SET compareceu_rt=:comparecimento WHERE id_rt=:idRet");
    	$presencaRetorno->bindValue(":comparecimento", 1, PDO::PARAM_INT);
    	$presencaRetorno->bindValue(":idRet", $idRetorno, PDO::PARAM_INT);


    	//Verifica a execução da Query
    	if($presencaRetorno->execute()){
    		//Busca objetos da Query
    		$selectRetorno=$pdo->prepare("SELECT * FROM retorno_exclusive WHERE id_rt=:idRet");
    		$selectRetorno->bindValue(":idRet", $idRetorno, PDO::PARAM_INT);

    		//Verifica a execução da Query
    		if($selectRetorno->execute()){
    			//Busca Objeto
    			$rowRetorno=$selectRetorno->fetch(PDO::FETCH_OBJ);

    			//Insere o Agendamento na tabela do estúdio 
    			


    		}else{
    			echo "Não foi possível Executar a Query";
    		}
    	}else{
    		echo "Não foi Possível Executar a Query";
    	}
    }catch(PDOException $e){
    	echo $e->getMessage(); 
    }



    }else if($unidade == 4){
       
        //Marca presença no Retorno 
        $presencaRetorno=$pdo->prepare("UPDATE retorno_concept SET compareceu_rt=:comparecimento WHERE id_rt=:idRet");
        $presencaRetorno->bindValue(":comparecimento", 1, PDO::PARAM_INT);
        $presencaRetorno->bindValue(":idRet", $idRetorno, PDO::PARAM_INT);
        $presencaRetorno->execute();

            //Busca objetos da Query
            $selectRetorno=$pdo->prepare("SELECT * FROM retorno_concept WHERE id_rt=:idRet");
            $selectRetorno->bindValue(":idRet", $idRetorno, PDO::PARAM_INT);
            $selectRetorno->execute();
                //Busca Objeto
                $rowRetorno=$selectRetorno->fetch(PDO::FETCH_OBJ);

                //Insere o Agendamento na tabela do estúdio 
                $insereEstudio=$pdo->prepare("INSERT INTO estudio_concept (contrato_cc, func_encaminhou_ec, obs_func_encaminhou, id_motivo_estudio, liberado_espera_ec, created) VALUES (:nContrato, :funcEncaminhou, :obsRetorno, :motivoEstudio, 1, NOW())");
                $insereEstudio->bindValue(":nContrato", $nContrato);
                $insereEstudio->bindValue(":funcEncaminhou", $idFuncionario);
                $insereEstudio->bindValue(":obsRetorno", $rowRetorno->observacao_retorno);
                $insereEstudio->bindValue("motivoEstudio", 6);
                $insereEstudio->execute();

                 $_SESSION['msgpres'] = "<div class='alert alert-success' role='alert'>
                                            Retorno Enviado para o Estúdio com Sucesso!
                             </div>";

                header("Location: ../marcar_presenca.php");               


            
       
        }
  
    





?>
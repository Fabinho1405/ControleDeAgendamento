<?php
     session_start();
     ob_start();
     include_once("../conection/connection.php");
     $pdo=conectar();
     $unidade=$_SESSION['unidade'];


     if($unidade == 1){ 

        try{
            $nContrato=$_GET['cnt'];
            $motivoCancelamento=$_POST['motivoCancelamento'];

            $mudarStatusContrato=$pdo->prepare("UPDATE clientes_exclusive SET status_cc='6', dataCancelamento=NOW(), motivoCancelamento=:motivoCancel WHERE contrato_cc=:nContrato");
            $mudarStatusContrato->bindValue(":motivoCancel", $motivoCancelamento);
            $mudarStatusContrato->bindValue(":nContrato", $nContrato);
            
            if($mudarStatusContrato->execute()){
                $baixaLancamentos=$pdo->prepare("UPDATE lancamento_exclusive SET status_lancamento=3 WHERE n_contrato_lancamento=:nContrato ");
                $baixaLancamentos->bindValue(":nContrato", $nContrato);
                if($baixaLancamentos->execute()){
                    header("Location:../pesquisar_cliente_ag.php");
                }else{
                      echo "ERRO AO DAR BAIXA NOS LANÇAMENTOS";
                }
            }else{
                echo "ERRO NO UPDATE DE CONTRATO";
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }else{
        echo "SEM PROGRAMAÇÃO PARA ESSA UNIDADE";
    }



?>
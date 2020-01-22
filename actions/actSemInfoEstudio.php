<?php
    session_start();
    ob_start();
    include_once("../conection/connection.php");
    $pdo=conectar();
    $unidade=$_SESSION['unidade'];


     $idProcedimento=$_GET['pcdm'];
     $nContrato=$_GET['cnt'];

     try{
        if($unidade == 1){

            $finalizarProcedimento=$pdo->prepare("UPDATE estudio_exclusive SET atendimento_finalizado=1, sem_info_ec=1, final_atendimento_ec=NOW(), atendimento_andamento_ec=0 WHERE id_ec=:idProced");
            $finalizarProcedimento->bindValue(":idProced", $idProcedimento);
            $finalizarProcedimento->execute();

            $motivoLog="Alerta";
            $descricaoLog="Estúdio informou não ter nenhum dado do Cliente.";
            $insereLOG=$pdo->prepare("INSERT INTO log_producao_exclusive(contrato_cc, motivo_pd, descricao_pd, created_pd) VALUES(:contrato, :motivoPd, :descricaoPd, NOW())");
            $insereLOG->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
            $insereLOG->bindValue(":motivoPd", $motivoLog, PDO::PARAM_STR);
            $insereLOG->bindValue(":descricaoPd", $descricaoLog, PDO::PARAM_STR);
            if($insereLOG->execute()){
        	    header("Location:../processo_estudio.php"); 
            }else{
                echo "<h1>ERRO NO LOG </h1>";
            };
        }else{
            echo "Sem programação para este tipo de unidade";
        }


     }catch(Exception $e){
         echo $e->getMessage();
     }




?>
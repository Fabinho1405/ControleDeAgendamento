<?php
    include_once("../conection/connection.php");
    $pdo=conectar();

    $contratosRestringidos=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE status_cc = 5");
    $contratosRestringidos->execute();
    $linhaContratos=$contratosRestringidos->fetchall(PDO::FETCH_OBJ);

    foreach($linhaContratos as $rowContratos){

        $valorPago=$pdo->prepare("SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento=:contrato AND status_lancamento=:statusLancamento AND status=:status");
        $valorPago->bindValue(":contrato", $rowContratos->contrato_cc, PDO::PARAM_INT);
        $valorPago->bindValue(":statusLancamento", 2, PDO::PARAM_INT);
        $valorPago->bindValue(":status", 1, PDO::PARAM_INT);
        $valorPago->execute();
        $linhaValorPago=$valorPago->fetchall(PDO::FETCH_OBJ);
        $totalPago=0;
        foreach($linhaValorPago as $rowPago){
            $totalPago+=$rowPago->valor_lancamento;
        };

        if($totalPago == 0){
            $porcentagem=0; 
        }else{
        $porcentagem = ($totalPago * 100) / $rowContratos->valor_material_cc;
        }

        if($porcentagem < 40){
            //echo "Contrato: ".$rowContratos->contrato_cc." - RESTRINGIDO - ".round($porcentagem,2)." - Apenas foi pago. <br>";
        }else{
            echo "<br>";
            echo "Contrato: ".$rowContratos->contrato_cc."<br>";
            echo "Porcentagem: ". round($porcentagem, 2)."%"; 
            echo "<br>"; 
            
            $nContrato=$rowContratos->contrato_cc;

            $liberarMaterial=$pdo->prepare("UPDATE clientes_exclusive SET status_cc=:status WHERE contrato_cc=:contrato");
            $liberarMaterial->bindValue(":status", 1, PDO::PARAM_INT);
            $liberarMaterial->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
            if($liberarMaterial->execute()){
                $motivoLog="Liberação";
                $descricaoLog="Material Liberado Automaticamente Pelo Sistema para Fila de Edição.";

                $insereLOG=$pdo->prepare("INSERT INTO log_producao_exclusive(contrato_cc, motivo_pd, descricao_pd, created_pd) VALUES(:contrato, :motivoPd, :descricaoPd, NOW())");
                $insereLOG->bindValue(":contrato", $nContrato, PDO::PARAM_INT);
                $insereLOG->bindValue(":motivoPd", $motivoLog, PDO::PARAM_STR);
                $insereLOG->bindValue(":descricaoPd", $descricaoLog, PDO::PARAM_STR);
                if($insereLOG->execute()){
                    
                }else{
                    echo "<h1>ERRO NO LOG </h1>";
                }
            }else{
                echo "<h1>ERRO</h1>";
            }



        }
    
    };
    





?>
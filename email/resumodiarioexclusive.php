<?php
    

   
    include_once("../conection/connection.php");
	$pdo=conectar();
	 
	require 'PHPMailer/src/Exception.php'; 
	require 'PHPMailer/src/PHPMailer.php'; 
	require 'PHPMailer/src/SMTP.php';

	use  PHPMailer\PHPMailer\PHPMailer ; 
	use  PHPMailer\PHPMailer\Exception ;
	use  PHPMailer\PHPMailer\SMTP;

	$mailer = new PHPMailer();
	

	try{
		$mailer->setLanguage('br');
		$mailer->CharSet="utf-8";
		$mailer->IsSMTP();
		$mailer->SMTPAuth=true;
		$mailer->SMTPSecure='';
		$mailer->Host='mail.controledeagendamento.com.br';
		$mailer->Port=587;
		$mailer->Username='sistema@controledeagendamento.com.br';
		$mailer->Password='fabinho140598';
		$mailer->Priority=1;
		$mailer->setFrom('sistema@controledeagendamento.com.br', 'Sistema');
		$mailer->addReplyTo('sistema@controledeagendamento.com.br', 'Sistema');
		$mailer->AddAddress('fabinho1405@gmail.com');
		$mailer->IsHtml(true);
		$mailer->Subject='Relatório Diário - Geral'; 
		$dataPrm=date("d/m/Y"); // DATA DE PARÂMETRO
		$dataPesquisa=date("Y-m-d");
		//Funções
			//VERIFICA PRODUTORES DA MATRIZ 
		$produtoresMatriz=$pdo->prepare("SELECT * FROM funcionario WHERE menu_produtor=:menuProdutor AND id_unidade=:idUnidade");
		$produtoresMatriz->bindValue(":menuProdutor", 1, PDO::PARAM_INT);
		$produtoresMatriz->bindValue(":idUnidade", 1, PDO::PARAM_INT);
		$produtoresMatriz->execute();
		$linhaProdutoresMatriz=$produtoresMatriz->fetchall(PDO::FETCH_OBJ);

		$produtoresCpt=$pdo->prepare("SELECT * FROM funcionario WHERE menu_produtor=:menuProdutor AND id_unidade=:idUnidade");
		$produtoresCpt->bindValue(":menuProdutor", 1, PDO::PARAM_INT);
		$produtoresCpt->bindValue(":idUnidade", 4, PDO::PARAM_INT);
		$produtoresCpt->execute();
		$linhaProdutoresCpt=$produtoresCpt->fetchall(PDO::FETCH_OBJ);


		$mailer->Body ="<center> <img src='cid:logo'> </center> <br />";
		$mailer->AddEmbeddedImage('img/logonovo.png','logo');
		$mailer->Body.="<div style='position: relative; display:inline; float:left;'>
							<table border=1>
								<tr>
									<td colspan=20><h2><center>Agency Exclusive </center></h2></td>
								</tr>
								<tr> 
									<td colspan=4><center><h4>Contratos Fechado no Dia</h4></center></td>
								</tr>
								<tr>
									<td><b>Produtor</b></td>
									<td><b>Contratos Fechados</b></td>
									<td><b>R$ Total</b></td>
									<td><b>R$ CVC</td></b>
								</tr>";
		foreach($linhaProdutoresMatriz as $rowProdutorM){
			$mailer->Body .="<tr>";
			$mailer->Body .="<td>";
			$mailer->Body .= $rowProdutorM->nome_completo_func;
			$mailer->Body .="</td>";
			//Contratos Fechados por Produtor 
			$idProdutor=$rowProdutorM->id_func;
			$fechadosProdutor=$pdo->prepare("SELECT * FROM clientes_exclusive WHERE id_produtor=:produtor AND date(data_cadastro_cc)=:dataPesquisa");
			$fechadosProdutor->bindValue(":produtor", $idProdutor, PDO::PARAM_INT);
			$fechadosProdutor->bindValue(":dataPesquisa", $dataPesquisa);
			$fechadosProdutor->execute();
			$linhaFechadosProdutor=$fechadosProdutor->fetchall(PDO::FETCH_OBJ);
			$qtdFechadosProdutor=$fechadosProdutor->rowCount();
			$mailer->Body .="<td><center>";
			$mailer->Body .=$qtdFechadosProdutor;
			$mailer->Body .="</center></td>";
			$mailer->Body .="<td><center>";
			$valorLancamento=0;
			$valorCVC=0;
			foreach($linhaFechadosProdutor as $rowFechadosProdutor){
			$nContrato=$rowFechadosProdutor->contrato_cc;
			$lancamentosContratos=$pdo->prepare("SELECT * FROM lancamento_exclusive WHERE n_contrato_lancamento=:nContrato AND status=:status");
			$lancamentosContratos->bindValue(":nContrato", $nContrato, PDO::PARAM_INT);
			$lancamentosContratos->bindValue(":status", 1, PDO::PARAM_INT);
			$lancamentosContratos->execute();
			$linhaLancamento=$lancamentosContratos->fetch(PDO::FETCH_OBJ);
			$valorLancado=$linhaLancamento->valor_lancamento;
			$statusPagamento=$linhaLancamento->status_lancamento;
			if($statusPagamento == 2){
				$valorCVC=$valorCVC+$valorLancado;
			}
			$valorLancamento=$valorLancamento+$valorLancado;
			};
			$mailer->Body .=$valorLancamento;
			$mailer->Body .="</center></td>";
			$mailer->Body .="<td>";
			$mailer->Body .=$valorCVC;
			$mailer->Body .="</td>";
			$mailer->Body .="</tr>";
		};
			$mailer->Body .="<tr>";
			$mailer->Body .="<td colspan=4><center><h4>Lançamentos do Dia</h4></center></td>";
			$mailer->Body .="</tr>";
			$mailer->Body .="
						<tr>
						<td> Contrato </td>
						<td> Forma de Pgto. </td>
						<td> Valor </td>
						<td> Status </td>
						</tr>
			";	
			$lancamentosDia=$pdo->prepare("SELECT * FROM lancamento_exclusive lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.created_lancamento) = :dataAtual AND lc.status = :status");
			$lancamentosDia->bindValue(":dataAtual", $dataPesquisa);
            $lancamentosDia->bindValue(":status", 1);
            $lancamentosDia->execute();
            $linhaLanc=$lancamentosDia->fetchAll(PDO::FETCH_OBJ);
            $totalLanc=0;
            $totalLancCVC=0;
            $contratoAnterior=0;
            foreach($linhaLanc as $listarLanc){
                                $totalLanc = $totalLanc + $listarLanc->valor_lancamento;
                                if($listarLanc->status_lancamento == 2 && $listarLanc->status == 1){
                                  $totalLancCVC = $totalLancCVC + $listarLanc->valor_lancamento;
                                }
			$mailer->Body .="<tr>";
				if($contratoAnterior == $listarLanc->n_contrato_lancamento){
			$mailer->Body .="<td> </td>";
				}else{
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLanc->n_contrato_lancamento;
			$mailer->Body .="</td>";
				}
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLanc->descricao_tp;
			$mailer->Body .="</td>";
			$mailer->Body .="<td>R$";
			$mailer->Body .=number_format($listarLanc->valor_lancamento,2,',','.');
			$mailer->Body .="</td>";
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLanc->descricao_status_lancamento;
			$mailer->Body .="</td>";
			$mailer->Body .="</tr>";
			$contratoAnterior=$listarLanc->n_contrato_lancamento;
			};

			$mailer->Body .="<tr>";
			$mailer->Body .="<td colspan=4><center><h4>Baixas do Dia</h4></center></td>";
			$mailer->Body .="</tr>";
			$mailer->Body .="
						<tr>
						<td> Contrato </td>
						<td> Forma de Pgto. </td>
						<td> Valor </td>
						<td> Status </td>
						</tr> 
			";	
			$pagamentosDia=$pdo->prepare("SELECT * FROM lancamento_exclusive lc INNER JOIN status_lancamento sl ON lc.status_lancamento = sl.id_status_lancamento INNER JOIN tipo_pagamento tp ON lc.tipo_pagamento_lancamento = tp.id_tp WHERE date(lc.data_baixa_lancamento) = :dataAtual AND lc.status = :status AND date(lc.data_baixa_lancamento) <> date(lc.created_lancamento)");
			$pagamentosDia->bindValue(":dataAtual", $dataPesquisa);
            $pagamentosDia->bindValue(":status", 1);
            $pagamentosDia->execute();
            $linhaLancPag=$pagamentosDia->fetchAll(PDO::FETCH_OBJ);
            $totalLancPag=0;
            $totalLancCVCPag=0;
            $contratoAnteriorPag=0;
            foreach($linhaLancPag as $listarLancPag){
                                $totalLancPag = $totalLancPag + $listarLancPag->valor_lancamento;
                                if($listarLancPag->status_lancamento == 2 && $listarLancPag->status == 1){
                                  $totalLancCVCPag = $totalLancCVCPag + $listarLancPag->valor_lancamento;
                                }
			$mailer->Body .="<tr>";
				if($contratoAnteriorPag == $listarLancPag->n_contrato_lancamento){
			$mailer->Body .="<td> </td>";
				}else{
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLancPag->n_contrato_lancamento;
			$mailer->Body .="</td>";
				}
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLancPag->descricao_tp;
			$mailer->Body .="</td>";
			$mailer->Body .="<td>R$";
			$mailer->Body .=number_format($listarLancPag->valor_lancamento,2,',','.');
			$mailer->Body .="</td>";
			$mailer->Body .="<td>";
			$mailer->Body .=$listarLancPag->descricao_status_lancamento;
			$mailer->Body .="</td>";
			$mailer->Body .="</tr>";
			$contratoAnterior=$listarLancPag->n_contrato_lancamento;
			};

			$mailer->Body .="<tr>";
			$mailer->Body .="<td colspan=4><center><h4>Despesas do Dia</h4></center></td>";
			$despesasDia=$pdo->prepare("SELECT * FROM despesas_exclusive dc INNER JOIN funcionario func ON dc.func_despesa = func.id_func WHERE date(created_despesa) = :dataAtual");
			$despesasDia->bindValue(":dataAtual", $dataPesquisa);
            $despesasDia->execute();
            $linhaDes=$despesasDia->fetchAll(PDO::FETCH_OBJ);                         
			$mailer->Body .="</tr>";
			$mailer->Body .="
						<tr>
						<td colspan=2> Descrição </td>
						<td> Valor </td>
						<td> Colaborador</td>
						</tr>
			";
			if($despesasDia->rowCount() == 0){ 
				$mailer->Body .="<td colspan=4>Nenhuma Despesa foi Encontrada :) </td>";
			}else{
			foreach($linhaDes as $listarDes){
			$mailer->Body .="<td>";
			$mailer->Body .=$listarDes->descricao_despesa;
			$mailer->Body .="</td>";
			$mailer->Body .="<td>R$";
			$mailer->Body .=number_format($listarDes->valor_despesa,2,',','.');
			$mailer->Body .="</td>";
			$mailer->Body .="<td>";
			$mailer->Body .=$listarDes->nome_completo_func;
			$mailer->Body .="</td>";
			};
			};
			$mailer->Body .="</table></div>";

            $mailer->Send();
        }catch(Exception $e){
		    var_dump($e); 
        }
        
   




?>
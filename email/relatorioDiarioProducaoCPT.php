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
		$mailer->setFrom('sistema@controledeagendamento.com.br', 'Controle de Agendamento - CDA');
		$mailer->addReplyTo('sistema@controledeagendamento.com.br', 'Controle de Agendamento - CDA');
		$mailer->AddAddress('henrique@agencyexclusive.com.br', 'Henrique');
		$mailer->AddAddress('fabio@agencyexclusive.com.br', 'Fabio Vieira');
		$mailer->AddAddress('john@agencyexclusive.com.br', 'John');
		$mailer->IsHtml(true); 	
		$dataPrm=date("d/m/Y", strtotime('-1 days')); // DATA DE EXIBIÇÃO		
		$dataPesquisa=date("Y-m-d", strtotime('-1 days')); // DATA DE PESQUISA
		$mailer->Subject='Fechamento Diário « HOME OFFICE - CONCEPT - '.$dataPrm.' »';

		//Pega Scouter's de 
		
		
		$scouterProducao=$pdo->prepare("SELECT * FROM funcionario WHERE status_sistema=1 AND acesso_direto=1 AND linha_producao=1 AND id_unidade=4");
		$scouterProducao->execute();
		$linhaScouters=$scouterProducao->fetchall(PDO::FETCH_OBJ);

		$mailer->Body ="<center> <img src='cid:logo'> </center> <br />";
		$mailer->AddEmbeddedImage('img/logonovo.png','logo');
		$mailer->Body.="Olá, este é um e-mail automático do Controle de Agendamento para informar o fechamento dos Scouter's que trabalham por produção. Este email é referente
		a data de ".$dataPrm.", qualquer dúvida entre em contato com um administrator do sistema.";
		$mailer->Body .="
		<table border=1>
			<thead>
				<th> Scouter </th>
				<th> Qtd. Instagram </th> 
				<th> Qtd. Facebook </th>
				<th> Qtd. Whatsapp </th>
				<th> Qtd. Ligação </th>
				<th> Total </th>
				<th> Recebimento (R$) </th>
			</thead>
			<tbody>
		";
		
				
			
		
		

			foreach($linhaScouters as $rowScouter){
				//Pesquisa agendamento insta
				$selectInsta=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_cadastro_agendamento)=:dataPesquisa AND id_func=:idFunc AND  id_meio_captado=:meioCaptado AND id_status_auditoria=:statusAuditoria");
				$selectInsta->bindValue(":dataPesquisa", $dataPesquisa);
				$selectInsta->bindValue(":idFunc", $rowScouter->id_func);
				$selectInsta->bindValue(":statusAuditoria", 2);
				$selectInsta->bindValue(":meioCaptado", 1);
				$selectInsta->execute();
				$qtdInsta=$selectInsta->rowCount();

				$selectFace=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_cadastro_agendamento)=:dataPesquisa AND id_func=:idFunc AND  id_meio_captado=:meioCaptado AND id_status_auditoria=:statusAuditoria");
				$selectFace->bindValue(":dataPesquisa", $dataPesquisa);
				$selectFace->bindValue(":idFunc",  $rowScouter->id_func);
				$selectFace->bindValue(":statusAuditoria", 2);
				$selectFace->bindValue(":meioCaptado", 4);
				$selectFace->execute();
				$qtdFace=$selectFace->rowCount();

				$selectWts=$pdo->prepare("SELECT * FROM agendamentos WHERE date(data_cadastro_agendamento)=:dataPesquisa AND id_func=:idFunc AND  id_meio_captado=:meioCaptado AND id_status_auditoria=:statusAuditoria");
				$selectWts->bindValue(":dataPesquisa", $dataPesquisa);
				$selectWts->bindValue(":idFunc",  $rowScouter->id_func);
				$selectWts->bindValue(":statusAuditoria", 2);
				$selectWts->bindValue(":meioCaptado", 4);
				$selectWts->execute();
				$qtdWts=$selectWts->rowCount();

				

		$mailer->Body .="<tr>";
		$mailer->Body .="<td>";
		$mailer->Body .= $rowScouter->nome_completo_func;
		$mailer->Body .="</td>";
		$mailer->Body .="<td>";
		$mailer->Body .= $qtdInsta;
		$mailer->Body .="</td>";
		$mailer->Body .="<td>";
		$mailer->Body .= $qtdFace;
		$mailer->Body .="</td>";
		$mailer->Body .="<td>";
		$mailer->Body .= $qtdWts;
		$mailer->Body .="</td>";
		$mailer->Body .="<td>";
		$mailer->Body .= "0";
		$mailer->Body .="</td>";
		$totalDia = $qtdInsta + $qtdFace + $qtdWts;
		$mailer->Body .="<td>";
		$mailer->Body .= $totalDia;
		$mailer->Body .="</td>";
		$totalReceber=0;
		if($totalDia <= 14){
			$totalReceber=$totalDia*2.50;
		}elseif($totalDia >= 15 || $totalDia <= 19){
			$totalReceber=$totalDia*3.00;
		}elseif($totalDia >= 20){
			$totalReceber=$totalDia*3.50;
		};
		$mailer->Body .="<td> R$";
		$mailer->Body .= number_format($totalReceber,2,",",".");;
		$mailer->Body .="</td>";
		$mailer->Body .="</tr>";
			};
		$mailer->Body .="</tbody>
		</table>";

			

            $mailer->Send();
        }catch(Exception $e){
		    var_dump($e); 
        }
        
   




?>
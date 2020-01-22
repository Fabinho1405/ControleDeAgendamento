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
		$mailer->setFrom('sistema@controledeagendamento.com.br', 'Admin CDA');
		$mailer->addReplyTo('sistema@controledeagendamento.com.br', 'Admin CDA');
		$mailer->AddAddress('fabinho1405@gmail.com');
		$mailer->IsHtml(true);
		$mailer->Subject='Relatório Diário - Geral'; 
		$dataPrm=date("d/m/Y"); // DATA DE PARÂMETRO
		$dataPesquisa=date("Y-m-d");
		//Funções
			//VERIFICA PRODUTORES DA MATRIZ
		


		$mailer->Body ="<center> <img src='cid:logo'> </center> <br />";
		$mailer->AddEmbeddedImage('img/logonovo.png','logo');
		$mailer->Body.="Incrivel Teste de Email";
			

            $mailer->Send();
        }catch(Exception $e){
		    var_dump($e); 
        }
        
   




?>
<?php
	include_once("conection/connection.php");
	$pdo=conectar();

	//Resgata Globais
	$idfuncionario = $_SESSION['id_usuario'];
    $unidadefunc = $_SESSION['unidade'];

    //Resgata Form
    $nomeCliente=$_POST['nomeCliente'];
    $telefoneCliente=$_POST['telefoneCliente'];
    $responsavelCliente=$_POST['responsavelCliente'];
    $selectScouter=$_POST['selectScouter'];

    //Insere Cliente










?>
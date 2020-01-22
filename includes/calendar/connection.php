<?php
		function conectar(){
			try{
			$pdo = new PDO("mysql:host=dbmodels.mysql.uhserver.com;dbname=dbmodels", "admindm","Agency@9947");
			}catch(PDOException $e){
				echo $e->getMessage(); 
			}
			return $pdo;
		}		
?>
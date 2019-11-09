<?php
	$hostname = "localhost";
	$database = "jeu_capitals";
	$login = "root";
	$password = "";
	try{
		$dsn = "mysql:host=$hostname;dbname=$database";

		//$connexion = new PDO("mysql:host=$server;dbname=Users",$login,$pass);
		$connexion = new PDO($dsn,$login,$password);
		
		// On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}catch(PDOException $e){
		echo utf8_encode("Echec de connexion ".$e->getMessage(). "\n");
		die();
	}
?>

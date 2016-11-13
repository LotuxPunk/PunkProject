<?php

function connexionDB(){
	$serveur="localhost";
	$login = "imperacu_vote";
	$pass = "ilfautvoter15";
	
	try{
		$bdd = new PDO("mysql:host=$serveur;dbname=imperacu_vote;charset=utf8",$login,$pass);
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
}

?>
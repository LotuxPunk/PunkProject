<?php
if (!isset($_POST['id']) OR !isset($_POST['next'])) {
  exit();
}
?>

<?php
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
?>

<?php
	$reponse = $bdd->query("SELECT * FROM gallery WHERE id ".$_GET['next']." ".$_GET['id']." LIMIT 1");
	$data = $reponse->fetchAll();
  
  
  return json_encode($data[0]);
?>

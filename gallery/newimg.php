<?php
	if (!isset($_POST['id']) OR !isset($_POST['sens'])) {
	  exit();
	}
?>
<?php
	require "functions.php";
	$bdd = connexionDB();
?>
<?php
	if ($_POST['sens']=="<")
		$ordre="DESC";
	else
		$ordre="ASC";

	$req="SELECT * FROM gallery WHERE id ".$_POST['sens']." ".$_POST['id']." ORDER BY id ".$ordre." LIMIT 1";

//echo $req;

	$reponse = $bdd->query($req);
	$data = $reponse->fetchAll();

	if (!isset($data[0]))	{
		$req="SELECT * FROM gallery WHERE id = ".$_POST['id']." ORDER BY id LIMIT 1";
		$reponse = $bdd->query($req);
		$data = $reponse->fetchAll();
	}


	$maReponse[0]=$data[0]['id'];
	$maReponse[1] = $data[0]['chemin'];

	echo json_encode($maReponse);
?>

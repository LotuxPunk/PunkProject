<?php
if (!isset($_POST['source']) OR !isset($_POST['sens'])) {
  exit();
}
?>


<?php
	require "functions.php"
	connexionDB();
?>

<?php
	$reponse = $bdd->query("SELECT * FROM gallery WHERE id ".$_GET['sens']." (select id from gallery where chemin= ".$_GET['id'].") LIMIT 1");
	$data = $reponse->fetchAll();
  
  
  return $data[0]['chemin'];
?>

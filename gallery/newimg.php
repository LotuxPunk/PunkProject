<?php
if (!isset($_POST['id']) OR !isset($_POST['next'])) {
  exit();
}
?>


<?php
	require "functions.php"
	connexionDB();
?>

<?php
	$reponse = $bdd->query("SELECT * FROM gallery WHERE id ".$_GET['next']." ".$_GET['id']." LIMIT 1");
	$data = $reponse->fetchAll();
  
  
  return json_encode($data[0]);
?>

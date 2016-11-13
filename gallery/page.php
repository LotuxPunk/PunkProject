<?php
	require "functions.php";
	$bdd = connexionDB();
?>
<?php
	if(isset($_GET['p']))
	{
		$num = $_GET["p"];
	}
	else
	{
		$num = 1
	}
	
?>	
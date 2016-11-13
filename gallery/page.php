<?php
	require "functions.php"
	connexionDB();
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
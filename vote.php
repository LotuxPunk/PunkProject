<?php

	$serveur="localhost";
	$login = "imperacu_vote";
	$pass = "ilfautvoter15";
	
	//--------------------------------------------------------------------------
	//			CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
	//--------------------------------------------------------------------------
	require_once('Rcon.class.php'); 
	
	$r = new rcon("91.121.80.219",23375,"(Ne revez pas, je l'ai retiré)"); // ("IP",port,"mdp")
	
	try{
		$bdd = new PDO("mysql:host=$serveur;dbname=imperacu_vote;charset=utf8",$login,$pass);
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
		
	if(isset($_GET['pseudo']))
	{
		
		/* On récupère le pseudo */
		$pseudo = htmlspecialchars($_GET["pseudo"]);
		if ($pseudo <> "" and $pseudo <> "Roger") 
		{
			//$sql = 'SELECT * FROM `votage` WHERE `pseudo` = "'.$pseudo.'" LIMIT 0,1';
			//$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			$req = $bdd->query('SELECT * FROM `votage` WHERE `pseudo` = "'.$pseudo.'" ORDER BY id DESC LIMIT 0,1'); //ORDER BY ID DESC
			$data = $req->fetch();
			$diff = time() - $data["date"];
			//echo "<script type='text/javascript'>alert('le dernier vote de ".$data['pseudo']." à été fait le ".$data['date']." et ".$diff."');</script>";
			if($diff > 86400)
			{
					$command = 'give '. $pseudo .' minecraft:diamond';
					$message = 'say '.$pseudo.' viens de voter pour ImperReborn et gagne 1 diamant ! Merci !';
					$date = time();
				
				try{

					$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$insertion = "INSERT INTO votage(`pseudo`, `date`) VALUES ('".$pseudo."', '".$date."')";
					$connexion->exec($insertion);
					if($r->Auth()){
						//$r->rconCommand($command);
						$r->rconCommand($message);
					}
					echo "<script type='text/javascript'>document.location.replace('http://www.serveurs-minecraft.org/vote.php?id=48119');</script>";
				}
				catch(PDOException $e){
					echo 'Echec : '.$e->getMessage();
				}
			}
			else
			{
				echo "<script type='text/javascript'>alert('Désolé, vous avez dejà voté il y a moins de 24h');</script>";
			}
		}
		else
		{
			if ($pseudo = "Roger")
			{
				$message = 'say '.$pseudo.' viens de voter pour ImperReborn et pond 1 diamant ! Merci Roger !';
				if($r->Auth())
				{
					$r->rconCommand($message);
				}
				echo "<script type='text/javascript'>document.location.replace('http://www.serveurs-minecraft.org/vote.php?id=48119');</script>";
			}
			else
			{
				echo "<script type='text/javascript'>alert('Veuillez entrer un pseudo');</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>PunkVote - Votez pour ImperAttack</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	
	<!-- UN PEU DE CSS POUR ADAPTER BOOTSTRAP A NOS BESOINS -->
	<style type="text/css">
		body{
			background-image: url("img/use_your_illusion.png");
			padding:10px;
			
		}
		
		#global {
			background-color:#F4FAFC;
			max-width:900px;
			margin:auto;
			text-align:center;
			padding:20px;
			margin-top:10px;
			border-radius:25px;
		}
		
		#listing{
			text-align:left;
		}
	
		.jumbotron {
			margin-top: 30px;
			border-radius: 0;
		}
		
		.table thead th {
			background-color: #428BCA;
			border-color: #428BCA !important;
			color: #FFF;
		}
		textarea:focus, input[type="text"]:focus,textarea[type="text"]:focus,   input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus,  input[type="color"]:focus, .uneditable-input:focus, .form-control:focus {  
		border-color: none;
		box-shadow:none;
		outline: none;
		}
	</style>

</head>

	<body>
	<div id="global">
		<div class="container-fluid">
			<center><img src="img/logo.png" width="200px"/></center>
			<h1>PunkVote <small class="text-muted">L'application de vote d'ImperaCube !</small></h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="http://www.imperacube.fr/">Site</a></li>
				<li class="breadcrumb-item"><a href="http://www.imperacube.fr//forum">Forum</a></li>
				<li class="breadcrumb-item active">PunkVote</li>
			</ol>
		</div>
		<div class="container-fluid">
			<h2>Vote en cours</h2>
		</div>
		<div id="global">
			<a href="https://github.com/LotuxPunk/PunkVote" class="btn btn-info" target="_blank">Envie de contribuer au PunkVote ?</a><br/><br/>
			<img src="img/tardis.jpg" class="img-thumbnail" style="width:300px;" />
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
	</body>
</html>

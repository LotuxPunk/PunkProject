<?php

	$serveur="localhost";
	$login = "imperacu_vote";
	$pass = "ilfautvoter15";
	
	//--------------------------------------------------------------------------
	//			CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
	//--------------------------------------------------------------------------
	require_once('Rcon.class.php'); 
	
	$r = new rcon("91.121.80.219",23375,"(Ne revez pas, je l'ai retiré)"); // ("IP",port,"mdp")
	
	if(isset($_GET['pseudo']))
	{
		
		/* On récupère le pseudo */
		$pseudo = htmlspecialchars($_GET["pseudo"]);
		if ($pseudo <> "" and $pseudo <> "Roger") 
		{
			try{
				$bdd = new PDO("mysql:host=$serveur;dbname=imperacu_vote;charset=utf8",$login,$pass);
			}
			catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
			//$sql = 'SELECT * FROM `votage` WHERE `pseudo` = "'.$pseudo.'" LIMIT 0,1';
			//$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			$req = $bdd->query('SELECT * FROM `votage` WHERE `pseudo` = "'.$pseudo.'" ORDER BY id DESC LIMIT 0,1'); //ORDER BY ID DESC
			$data = $req->fetch();
			$diff = time() - $data["date"];
			//echo "<script type='text/javascript'>alert('le dernier vote de ".$data['pseudo']." à été fait le ".$data['date']." et ".$diff."');</script>";
			if((time() - $data["date"]) > 86400)
			{
				$command = 'give '. $pseudo .' minecraft:diamond';
				$message = 'say '.$pseudo.' viens de voter pour ImperReborn et gagne 1 diamant ! Merci !';
				$date = time();
				if($r->Auth()){
					//$r->rconCommand($command);
					$r->rconCommand($message);
				}
				try{

					$connexion = new PDO("mysql:host=$serveur;dbname=imperacu_vote",$login,$pass);
					$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$insertion = "INSERT INTO votage(`pseudo`, `date`) VALUES ('".$pseudo."', '".$date."')";
					$connexion->exec($insertion);
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
	
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
			<p class="lead" id="listing">Si vous êtes connecté sur le serveur, cliquez sur le bouton avec votre avatar, sinon cliquez sur Roger ! (Roger le poulet)</p>
			<?php
				$json = file_get_contents('https://mcapi.ca/query/play.imperacube.fr:23365/list');
				$obj = json_decode($json,true);
				$liste = $obj['Players']['list'];
				$nbj = count($liste);
				//echo "<script type='text/javascript'>alert('".$nbj."');</script>";
				if ($nbj > 0)
				{
					foreach ($liste as $joueur){
					?>
					<a class="btn btn-secondary" onClick="vote()" href="http://www.imperacube.fr/vote/index.php?pseudo=<?php echo $joueur; ?>" type="submit"><img src="https://minotar.net/avatar/<?php echo $joueur; ?>/25"> <?php echo $joueur; ?></a>
					<?php
					}
				}
				else
				{
					echo '<div class="bg-info">Aucun joueur n\'est connecté.</div>';
				}
				?>
				
			<p style="margin-top:10px;"><a type="button" onClick="vote()" href="http://www.imperacube.fr/vote/index.php?pseudo=Roger" class="btn btn-primary btn-lg" ><img width="25px" src="img/poulet.jpg"> Roger, va voter !</a></p>
			<p class="text-warning">Des failles existent, si nous constatons des abus, il y aura des sanctions.</p>
		</div>
		<div class="container-fluid">
			<h2>Les 10 dernières personnes ayant votées ...</h2>
				<table class="table table-bordered table-hover" id="listing" >
					<thead class="thead-inverse">
						<tr>
							<th>Avatar</th>
							<th>Pseudo</th>
							<th>Date</th>
						</tr>
					</thead>
					<?php
						try{
							$bdd = new PDO("mysql:host=$serveur;dbname=imperacu_vote;charset=utf8",$login,$pass);
						}
						catch (Exception $e){
							die('Erreur : ' . $e->getMessage());
						}
						$reponse = $bdd->query("SELECT * FROM votage ORDER BY date DESC LIMIT 10");
						while ($data = $reponse->fetch()){
					?>
					<tbody>
					<tr>
						<th><?php $img = '<center><img src="https://minotar.net/avatar/'.$data['pseudo'].'/25"></center>'; echo $img; ?></th>
						<td><?php echo $data['pseudo']; ?></td>
						<td><?php echo date("d-m-Y h:i:sa",$data['date']+7200);?></td>
					</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
	</div>
	<div id="global">
		<a href="https://github.com/LotuxPunk/PunkVote" class="btn btn-info" target="_blank">Envie de contribuer au PunkVote ?</a><br/><br/>
		<img src="img/tardis.jpg" class="img-thumbnail" style="width:300px;" />
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
	<script>
	var clic = 0;
	
	function vote() {
		
	}
	</script>
</body>
</html>

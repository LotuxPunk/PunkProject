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
					$r->rconCommand($command);
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
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

	<!-- UN PEU DE CSS POUR ADAPTER BOOTSTRAP A NOS BESOINS -->
	<style type="text/css">
		body{
			background-image: url("img/use_your_illusion.png");
			padding:10px;
		}
		
		#global {
			max-width:900px;
			margin:auto;
			text-align:center;
			padding:20px;
			background-color:rgba(255,255,255,0.9);
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
	<center><img src="img/logo.png" width="200px"/></center>
	<div class="page-header">
		<h1>PunkVote <small>L'application de vote d'ImperaCube !</small></h1>
	</div>
	<div class="container">
		<?php
			$json = file_get_contents('https://mcapi.ca/query/play.imperacube.fr:23365/list');
			$obj = json_decode($json,true);
			$liste = $obj['Players']['list'];
			/* print_r($obj['Players']['list']); */
			foreach ($liste as $joueur){
				?>
				<a class="btn btn-default" href="http://www.imperacube.fr/vote/index.php?pseudo=<?php echo $joueur; ?>" type="submit"><img src="https://minotar.net/avatar/<?php echo $joueur; ?>/25"> <?php echo $joueur; ?></a>
				<?php
			}
		?>
		<p style="margin-top:10px;"><a type="button" href="http://www.imperacube.fr/vote/index.php?pseudo=Roger" class="btn btn-primary btn-lg"><img width="25px" src="img/poulet.jpg"> Vous n'êtes pas connecté sur le serveur ?</a></p>
	</div>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">Les 10 dernières personnes ayant votées ...</div>
			<div class="container" id="listing">
				<table class="table" class="table table-striped">
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
					<tr>
					<td>
					<?php
						$img = '<img src="https://minotar.net/avatar/'.$data['pseudo'].'/25">';
						echo $img;
					?>
					</td>
					<td>
					<p><?php echo $data['pseudo']; ?> a voté le <?php echo date("d-m-Y h:i:sa",$data['date']);?></p>
					</td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="global">
		<p>Envie de contribuer au PunkVote ?<p>
		<a href="https://github.com/LotuxPunk/PunkVote" target="_blank">Github</a>
	</div>
	<div id="global">
		<p>Cette application est toujours en développement, soyez patient ! :)</p>
		<img src="img/tardis.jpg" width="300px"/>
	</div>
</body>
</html>

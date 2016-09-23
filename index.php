<?php

	$serveur="localhost";
	$login = "imperacu_vote";
	$pass = "ilfautvoter15";
	
	//--------------------------------------------------------------------------
	//			CONNEXION AU RCON POUR ENVOYER DES COMMANDES AU SERVEUR
	//--------------------------------------------------------------------------
	require_once('Rcon.class.php'); 
	
	$r = new rcon("91.121.80.219",23375,"(Ne revez pas, je l'ai retiré)"); // Remplacer l'ip, le port et le mot de passe par les votres

	if(isset($_POST['submit']))
	{
		
		/* On récupère le pseudo */
		$pseudo = $_POST['pseudo'];
		
		if ($pseudo <> "") 
		{
			try{
			$bdd = new PDO("mysql:host=$serveur;dbname=imperacu_vote;charset=utf8",$login,$pass);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		/* $reponse = $bdd->query('SELECT * FROM `votage` WHERE `pseudo` = "'.$pseudo.'" LIMIT 0,1');
		echo $reponse['date'];
		if(($reponse['date'] - time()) > 86400)
		{ */
			$command = 'give '. $pseudo .' minecraft:diamond';
			$message = 'say '.$pseudo.' viens de voter pour ImperAttack ! Merci !';
			$date = time();

			if($r->Auth())
			{
				// $r->rconCommand($command);
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
		/* }
		else{
			echo "<h1>Désolé, vous avez dejà voté il y a moins de 24h</h1>";
			} */
		}
		else{
			echo "<script type='text/javascript'>alert('Veuillez entrer un pseudo');</script>";

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
			background-color:rgba(255,255,255,0.7);
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
	<h1>PunkVote - L'application de vote d'ImperAttack !</h1>
    <div class="container">
		<!-- Envoie de commande -->
		<table class="table">
			<thead>
				<tr>
					<th>Pour voter, entrez votre pseudo et cliquez sur "Envoyer"</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<form method="post" role="form">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-chevron-right">
								</span>
								</span>
								<input type="text" name="pseudo" class="form-control" placeholder="Entrez votre pseudo">
								<span class="input-group-btn">
									<input type="submit" name="submit" class="btn btn-default" value="Envoyer" />
								</span>
							</div>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="container" id="listing">
		<h2>Les 10 dernières personnes ayant votées ...</h2>
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
					</td><td>
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
	<div id="global">
		<p>Cette application est toujours en développement, soyez patient ! :)</p>
		<img src="img/tardis.jpg" width="300px"/>
	</div>
</body>
</html>

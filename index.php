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
					<a class="btn btn-secondary" onClick="vote()" href="http://www.imperacube.fr/vote/vote.php?pseudo=<?php echo $joueur; ?>" type="submit"><img src="https://minotar.net/avatar/<?php echo $joueur; ?>/25"> <?php echo $joueur; ?></a>
					<?php
					}
				}
				else
				{
					echo '<div class="bg-info">Aucun joueur n\'est connecté.</div>';
				}
				?>
				
			<p style="margin-top:10px;"><a type="button" onClick="vote()" href="http://www.imperacube.fr/vote/vote.php?pseudo=Roger" class="btn btn-primary btn-lg" ><img width="25px" src="img/poulet.jpg"> Roger, va voter !</a></p>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
</body>
</html>

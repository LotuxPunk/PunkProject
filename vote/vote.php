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
					$bdd->exec($insertion);
					if($r->Auth()){
						$r->rconCommand($command);
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
				echo "<script type='text/javascript'>document.location.replace('http://www.imperacube.fr/vote/');</script>";
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
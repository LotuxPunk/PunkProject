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
<?php
	/* $last = $bdd->query('SELECT LAST_INSERT_ID(id) FROM gallery;')->fetch(PDO::FETCH_ROW)[0];
	echo "<script type='text/javascript'>alert('".$last."');</script>"; */
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>PunkGallery - Partagez vos photos avec la communauté !</title>
		<!-- DÉBUT CSS Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
		<!-- FIN CSS Bootstrap -->
		<style>
			#global {
				max-width:80%;
				margin:auto;
				background-color:#F4FAFC;
				border-radius:25px;
				padding:20px;
				margin-top:10px;
			}
			
			body {
				background-image: url("img/broken_noise.png");
				background-attachment: fixed;
			}
			
		</style>
	</head>
	<body>
		<div id="global">
			<div class="container-fluid">
				<center><img src="img/logo.png" width="200px"/></center>
				<h1 class="text-xs-center">PunkGallery <small class="text-muted">Partagez vos photos avec la communauté !</small></h1>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="http://www.imperacube.fr/">Site</a></li>
					<li class="breadcrumb-item"><a href="http://www.imperacube.fr/forum">Forum</a></li>
					<li class="breadcrumb-item"><a href="http://www.imperacube.fr/punk/vote">PunkVote</a></li>
					<li class="breadcrumb-item active">PunkGallery</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h2>Image à la une !</h2>
					<?php
						$reponse = $bdd->query("SELECT * FROM gallery ORDER BY RAND() LIMIT 7");
						$data = $reponse->fetchAll();
					?>
					<img src="<?php echo $data[0]['chemin'];?>" class="img-fluid" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
				<div class="col-md-4">
					<h2>Mettre en ligne</h2>
					<p>La taille maximale d'une image ne doit pas dépasser 4Mo (4.194.304 octets)</p>
					<form enctype="multipart/form-data" action="fileupload.php" method="post">
						<input type="hidden" name="MAX_FILE_SIZE" value="4194304" /><input type="file" name="monfichier" />
						<input type="submit" />
					</form>
				</div>
			</div>
			<br/>
			<h2>Plus d'images aléatoire !</h2>
			<div class="row">
				<div class="col-md-4">
					<img src="<?php echo $data[1]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
				<div class="col-md-4">
					<img src="<?php echo $data[2]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
				<div class="col-md-4">
					<img src="<?php echo $data[3]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-md-4">
					<img src="<?php echo $data[4]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
				<div class="col-md-4">
					<img src="<?php echo $data[5]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
				<div class="col-md-4">
					<img src="<?php echo $data[6]['chemin'];?>" id="imgGallery" class="img-thumbnail" alt="Responsive image" data-toggle="modal" data-target="#myModal" onclick="chgtimgmodal(this.src);">
				</div>
			</div>
		</div>

		
<script type="text/javascript">	//modif de l'image du modal
	function chgtimgmodal(source)	{
		document.getElementById('imgmodal').src=source;
	}
</script>
	
<script type="text/javascript"> //appel ajax		
	$(document).ready(function(){
	    $("#imgmodal").click(function(){
		$.post(
		    'newimg.php', // Le fichier cible côté serveur.
		    {
			source : document.getElementById('imgmodal').src;
			sens : ">";	//en attendant de recup le sens
		    },
		    'nom_fonction_retour', // Nous renseignons uniquement le nom de la fonction de retour.
		    'text' // Format des données reçues.
		);

	    });
	});
	
	function nom_fonction_retour(texte_recu){
  		document.getElementById('imgmodal').src=texte_recu;
	}
</script>		
		
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">DorinnZoom</h4>
        </div>
        <div class="modal-body">
		  <img src="" id="imgmodal" class="img-fluid" alt="Responsive image">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>	
		
		
		
		
		
		
	<!-- DÉBUT Script Bootstrap -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
	<!-- FIN Script Bootstrap -->
	</body>
</html>

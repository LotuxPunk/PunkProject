<?php
	require "functions.php";
	$bdd = connexionDB();
?>
<?php
	/* Détection de la page */
	if(isset($_GET['p']))
	{
		$num = $_GET["p"];
	}
	else
	{
		$num = 1;
	}
	
	/* Catch des photos dans la DB */
	$reponse = $bdd->query("SELECT * FROM gallery ORDER BY 'id' ASC LIMIT 20");
?>
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
		<!--Entête-->
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
			<?php
				$cpt = 0;
				$data = $reponse->fetchAll();
				for ($i = 0; $i == 4; $i++) {
			?>
				<div class="row">
				<?php
						?>
						<?php
						$cpt++;
					}
				?>
				</div>
			<?php
				}
			?>		
<script type="text/javascript">	//modif de l'image du modal
	function chgtimgmodal(source)	{
		document.getElementById('imgmodal').src=source;
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

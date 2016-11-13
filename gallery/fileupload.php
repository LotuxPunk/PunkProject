<html>
<head>
  <meta charset="utf-8">
</head>
<body>
<?php
	require "functions.php"
	connexionDB();
?>
<?php
$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("jpeg", "jpg", "gif", "png");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {    
    // Copie dans le repertoire du script avec un nom
    // incluant l'heure a la seconde pres 
    $repertoireDestination = dirname(__FILE__)."/screen/";
    $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

    if (move_uploaded_file($_FILES["monfichier"]["tmp_name"],$repertoireDestination.$nomDestination)) {
        echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"]." a été déplacé vers ".$repertoireDestination.$nomDestination;
		/* Ajout dans la DB */
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$insertion = "INSERT INTO gallery(`chemin`) VALUES ('screen/".$nomDestination."')";
		$bdd->exec($insertion);
		/* Fin d'ajout dans la DB */
    } else {
        echo "Le fichier n'a pas été uploadé (trop gros ?) ou "."Le déplacement du fichier temporaire a échoué"." vérifiez l'existence du répertoire ".$repertoireDestination;
    }
}
?>
</body>
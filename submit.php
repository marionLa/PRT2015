<?php

$selection = $_POST['selected'];						//récupération de la valeur du champ 'selected' contenant le contenu survolé
include 'connection.inc.php' ;							//appel du script de connection
$selectionbdd = pg_escape_string($_POST['selected']);	//conversion en chaine de caractère
$image = '/'.$selectionbdd.'.jpg';						//création du chemin de l'image


$sql=pg_query($connection,"DELETE FROM id_user ")or die ('Erreur connexion'. pg_last_error($connection));	//suppression du champ précédent de la table
$sql=pg_query($connection,"INSERT INTO id_user(id_select,images) VALUES ('".$selectionbdd."', '".$image."') ")or die ('Erreur connexion'. pg_last_error($connection));		//insersion des nouveaux champs dans la bdd: objet survolé et image à afficher

$query = "SELECT name FROM selection ";					//selection des champes dans la bdd
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());	//stockage du résultat

	while ($row = pg_fetch_row($result)) {				//tant qu'il y a des résultats dans la table
		$resultat = $row[0];							//stocker la valeur dans la variable $resultat
	}

// Exécution de la requête SQL
$query1 = "SELECT * FROM $resultat, id_user where $resultat.nomid=id_user.id_select  ";		//selection de l'intégralité de la table résultat (qui correspond à l'objet sélectionné)
$result1 = pg_query($query1) or die('Échec de la requête : ' . pg_last_error());			//stockage du résultat dans $resultat1



// Affichage des résultats en HTML

while ($row = pg_fetch_row($result1)) {				//tant qu'il y a des résultats dans la sélection1, afficher:
	echo '							
	<p align="center">
	'.$row[1].'
	 </p>
	';
	echo '
	<p align ="center">
	<img src="./Donnees/Images'. $image .'" width="250" /> 
	</p>
	';
	echo "$row[5]";
}

// Libère le résultat
pg_free_result($result);
pg_free_result($result1);

// Ferme la connexion
pg_close($connection);
    

?>

<?php

include 'connection.inc.php' ;

for ($i=0;$i<count($_POST['objet']);$i++) {			//pour i parcourant le post 'objet'
	$obj = $_POST['objet'][$i];
	$sql=pg_query($connection,"INSERT INTO selection (checked) VALUES ('".$obj."') ")or die ('Erreur connexion'. pg_last_error($connection));							//insérer dans la table selection l'objet
}


$query = "SELECT * FROM selection";				//sélectionner l'intégralité de la table sélection
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());		//stockage du résultat

$i=0;				//initialisation de la variable i 

// Affichage des résultats en HTML
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$i=$i+1;
    	echo "\t<tr>\n";
    		foreach ($line as $col_value) {
        	echo "\t\t<td>$col_value</td>\n";
		$col[$i]=$col_value;
		}
   	echo "\t</tr>\n";
}
echo "</table>\n";

// Libère le résultat
pg_free_result($result);

// Ferme la connexion
pg_close($connection);
if(empty($col)) { 
$col[1]="noselect";
}

?>


		

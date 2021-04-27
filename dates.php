<?php

include 'connection.inc.php' ;								//inclusion du script de connection à la bdd

//----- cette première partie consite à récupérer le site sélectionné par l'utilisateur sur la carte Geomajas, stocké dans la table selection qui comporte 2 colonnes (id et name) et une seule ligne écrasée à chaque sélection ------//

$query = "SELECT name FROM selection ";						//sélectionner la colonne name dans sélection (1 ligne, 1 colonne)
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());	//stockage du résultat de la requête

	while ($row = pg_fetch_row($result)) {					//tant qu'il y a des lignes de résultats
		$resultat = $row[0];								//résultat stocké dans $résultat. 
	}

//----------- récupération des champs pour le menu ----------------------//

$query1 = "SELECT DISTINCT menu FROM $resultat ORDER BY menu ASC ";               //selection des items distincts dans la colonne menu
$result1 = pg_query($query1) or die('Échec de la requête : ' . pg_last_error());  //stockage du résultat dans $result1

$query2 = "SELECT nomid, date_cons, date_des,menu FROM $resultat";		  		  //extraction des noms des bâtiments, leur date de construction, leur date de destruction, le menu
$result2 = pg_query($query2) or die('Échec de la requête : ' . pg_last_error());  //stockage du résultat dans $result2

$query3 = "SELECT DISTINCT date_cons FROM $resultat ";				 			 //selection des dates de constructions distinctes
$result3 = pg_query($query3) or die('Échec de la requête : ' . pg_last_error()); //stockage du résultat dans $result3



//--------- Affichage des résultats --------------------------------------//

$i=0;																	//initialisation de i à 0

	while ($line = pg_fetch_array($result1, null, PGSQL_ASSOC)) {		//tant qu'il y a des lignes de résultat dans $resultat1
		$i=$i+1;														//incrémentation de i
    		foreach ($line as $menutable) {								//pour chaque ligne (alias $menutable)
 			$menu[$i]=$menutable;										//la mettre en ième position du tableau $menutable
		}
 	}


$l=0;															//initialisation de l à 0

while ($line = pg_fetch_array($result3, null, PGSQL_ASSOC)) {	//tant qu'il y a des lignes de résultat dans $resultat3
	$l=$l+1;													//incrémentation de l
    	foreach ($line as $dateunique) {						//pour chaque ligne de résultat
		$date[$l]=$dateunique;									//stockage de la date dans un tableau
	}
}




$j=0;																	//initialisation de la variable j
	while ($line2 = pg_fetch_array($result2, null, PGSQL_ASSOC)){		//tant qu'il y a des résultats
		$j=$j+1;														//incrémentation de j
		$objects[$j]=$line2["nomid"];					//stockage des noms dans un tableau
		$datesobj[$j]=$line2["date_cons"];				//stockage des dates de construction
		$datesobjdes[$j]=$line2["date_des"];			//stockage des dates de destruction
		$menuobj[$j]=$line2["menu"];					//stockage de la colonne menu dans un tableau
}



$m=1;
$k=1;

$counter = count($datesobj);						//initialisation du compteur
//echo $counter;

for ($k=1;$k<=count($menu);$k++){					//pour k parcourant menu
	$arr[$k] = array();								//création d'un tableau arr
	$arrdate[$k] = array();							//création d'un tableau arrdate
	//echo "k={$k}";
		for ($m=1;$m<=$counter;$m++){		   		//pour m parcourant les dates de construction des objets
		//echo "m={$m}";	
			if ($menuobj[$m] == $menu[$k]){			//si le menu sélectionné par l'utilisateur est le même que celui parcouru par la boucle
			array_push($arr[$k],$objects[$m]);		//mettre le nom de l'objet à la fin du tableau
			array_push($arrdate[$k],$datesobj[$m]); //mettre la date de construction de l'objet à la fin du menu
			}
	
		}
	//print_r($datesobj);
	$nomsobj = json_encode($arr[$k]);				//encodage en JSON pour récupération par javascript
	$datesobj2 = json_encode($arrdate[$k]);			
	echo "<script>";								//affichage des résultats
	echo "var ELEMENTS_{$k}= JSON.parse('". $nomsobj."');\n";
	echo "var ELEMENTSDATES_{$k}= JSON.parse('". $datesobj2. "');\n";
	echo "console.log(ELEMENTSDATES_{$k});";
	echo "</script>";
}





//encodage des tableaux de variables en JSON pour récupération par javascript

$objects2= json_encode($objects);
$datesobjcons2=json_encode($datesobj);
$datesobjdes2=json_encode($datesobjdes);
$menu2=json_encode($menu);


echo"<ul id='liste_dates'></ul>";						//création d'un menu appelée liste_dates
echo "<script>";										//ouverture d'une balise javascript pour interprétation du code en html
echo "var DATES = JSON.parse('". $menu2. "');\n";		//interprétation des tableaux JSON
echo "var OBJETS = JSON.parse('". $objects2. "');\n";
echo "var DATE_CONS = JSON.parse('". $datesobjcons2. "');\n";
echo "var DATE_DES = JSON.parse('". $datesobjdes2. "');\n";


echo "createMenu(DATES);";								//appel de la fonction createMenu()


echo "</script>";

// Libère le résultat
pg_free_result($result1);
pg_free_result($result2);
pg_free_result($result3);

// Ferme la connexion
pg_close($connection);


?>





		

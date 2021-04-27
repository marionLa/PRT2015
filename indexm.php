<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
  xml:lang="fr" lang="fr">
  
<head>
	<LINK rel="stylesheet" href="style3.css" type="text/css">
	<font color ="000000">
<font>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>	

<?php
	include 'connection.inc.php' ;								//inclusion du script de connection ˆ la bdd

//----- cette premire partie consite ˆ rŽcupŽrer le site sŽlectionnŽ par l'utilisateur sur la carte Geomajas, stockŽ dans la table selection qui comporte 2 colonnes (id et name) et une seule ligne ŽcrasŽe ˆ chaque sŽlection ------//

$query = "SELECT name FROM selection ";						//sŽlectionner la colonne name dans sŽlection (1 ligne, 1 colonne)
$result = pg_query($query) or die('ƒchec de la requte : ' . pg_last_error());	//stockage du rŽsultat de la requte

	while ($row = pg_fetch_row($result)) {					//tant qu'il y a des lignes de rŽsultats
		$resultat = $row[0];								//rŽsultat stockŽ dans $rŽsultat. 
	}

?>



	<title>
		ConsultationPRT
	</title>
</head>


<body>
	<div id="titre">
		Générateur de requete pour la consultation des données du site : <?php echo $resultat; ?>
		<hr>
		
	</div>

	<div id="formulaire">	
		<form method="post" action="indexm.php">
	
			<p>
			<?php
			if(1==1){
			
				//$query = "SELECT * FROM $resultat ";						//sŽlectionner la colonne name dans sŽlection (1 ligne, 1 colonne)
				//$reponse = pg_query($query) or die('ƒchec de la requte : ' . pg_last_error());	//stockage du rŽsultat de la requte
				//On récupère les données de la table selectionnée de la BDD.
				$reponse = pg_query("SELECT * FROM $resultat");
				//$reponse = $connection->pg_query("SELECT * FROM ".$selection[name]." WHERE NomID LIKE 'b%'");
			
				//On crée un tableau colonne qui contient des tableaux ligne qui contiennt les infos de chaque ligne de la table de la BDD
				$tableau ;
				$index = 0;
				while ($row = pg_fetch_row($reponse)) { 
					$tableau[$index] = $row; 
					$index += 1; 
					
				}
				
				?>
				
				<!-- Combo box de sélection du nom de l'objet -->
				<p>Sélection par nom<br>
					
					<select name="selectN">
					<option value="Tous les éléments" selected>Tous les éléments</option>
				<?php
				$l=0;
				for($l=0;$l<count($tableau);$l++){
				//On affiche pour la j ime ligne du tableau colonne les éléments contenus dans l'objet tableau ligne
				?>
					<option value="<?php echo $tableau[$l][1] ?>"> <?php echo $tableau[$l][1] ?> </option>
				<?php
				}
				?>
				</select>
				</p>
				<!-- FIN Combo box de sélection du nom de l'objet -->
				
				<!-- Sélection sur les dates -->
				<p>Date de construction<br>
					<select name="selectC1">
					<option value="" selected></option>
					<option value="OU">OU</option>
					<option value="ET">ET</option>
					</select>
					Date de construction
					<select name="selectC2">
					<option value="=" selected>=</option>
					<option value="'>'">'>'</option>
					<option value="'<'">'<'</option>
					<option value="entre">entre</option>
					</select>
					<INPUT type="text" value="0" name="DateC1">, 
					<INPUT type="text" value="8888" name="DateC2">
				</p>
				<p>Date de fin de construction<br>
					<select name="selectF1">
					<option value="" selected></option>
					<option value="OU">OU</option>
					<option value="ET">ET</option>
					</select>
					Date de fin de construction
					<select name="selectF2">
					<option value="=" selected>=</option>
					<option value="'<'">'<'</option>
					<option value="'>'">'>'</option>
					<option value="entre">entre</option>
					</select>
					<INPUT type="text" value="0" name="DateF1">, 
					<INPUT type="text" value="8888" name="DateF2">
				</p>
				<p>Date de destruction<br>
					<select name="selectD1">
					<option value="" selected></option>
					<option value="OU">OU</option>
					<option value="ET">ET</option>
					</select>
					Date de destruction
					<select name="selectD2">
					<option value="=" selected>=</option>
					<option value="'<'">'<'</option>
					<option value="'>'">'>'</option>
					<option value="entre">entre</option>
					</select>
					<INPUT type="text" value="0" name="DateD1">, 
					<INPUT type="text" value="8888" name="DateD2">
				</p>
				<!-- FIN Sélection sur les dates -->
				
				<!-- Combo box de sélection du menu -->
				<p>Menu<br>
					<select name="selectM1">
					<option value="" selected></option>
					<option value="OU">OU</option>
					<option value="ET">ET</option>
					</select>
					
					<select name="selectM2">
					<option value="" selected></option>
				<?php
				$l=0;
				for($l=0;$l<count($tableau);$l++){
				?>
					<option value="<?php echo $tableau[$l][6] ?>"> <?php echo $tableau[$l][6] ?> </option>
				<?php
				}
				?>
				</select>
				</p>
				<!-- FIN Combo box de sélection du menu -->
			<?php	
			}
			?>
			<input type="submit" name="Montrer" value="Montrer les éléments" />
			
                        <a href="./index.php"> <img src="./carte.png"  height="40"/> </a> <!-- le clic sur la flèche redirige vers de lien de la consultation de la bdd -->
                            
		</form>
	</div>
	
	<div id="consulation">
		<p>	
				<?php
				// Création de la requête de sélection à partir du générateur		
				if(isset($_POST['Montrer'])){
					$requete = "SELECT * FROM $resultat WHERE";
					$selectN=$_POST['selectN'];
					$selectC1=$_POST['selectC1'];
					$selectC2=$_POST['selectC2'];
					$DateC1=$_POST['DateC1'];
					$DateC2=$_POST['DateC2'];
					$selectF1=$_POST['selectF1'];
					$selectF2=$_POST['selectF2'];
					$DateF1=$_POST['DateF1'];
					$DateF2=$_POST['DateF2'];
					$selectD1=$_POST['selectD1'];
					$selectD2=$_POST['selectD2'];
					$DateD1=$_POST['DateD1'];
					$DateD2=$_POST['DateD2'];
					$selectM1=$_POST['selectM1'];
					$selectM2=$_POST['selectM2'];
					
					if($selectN == 'Tous les éléments'){
						$requete = $requete.' Titre IS NOT NULL';
					}else{
						$requete = $requete.' Titre LIKE \''.$selectN.'\'';
					}
					
					if($selectC1 == ''){
					}else{
						if($selectC1 == 'OU'){
							$requete = $requete.' OR';
						} else {$requete = $requete.' AND';}
						$requete = $requete.' (Date_Cons';
						if($selectC2 == 'entre'){
							$requete = $requete.' BETWEEN \''.$DateC1.'\' AND \''.$DateC2.'\')';
						} else{$requete = $requete.' '.$selectC2.' \''.$DateC1.'\')';}
					}
					
					if($selectF1 == ''){
					}else{
						if($selectF1 == 'OU'){
							$requete = $requete.' OR';
						} else {$requete = $requete.' AND';}
						$requete = $requete.' (Date_Fin_Cons';
						if($selectF2 == 'entre'){
							$requete = $requete.' BETWEEN \''.$DateF1.'\' AND \''.$DateF2.'\')';
						} else{$requete = $requete.' '.$selectF2.' \''.$DateF1.'\')';}
					}
					
					if($selectD1 == ''){
					}else{
						if($selectD1 == 'OU'){
							$requete = $requete.' OR';
						} else {$requete = $requete.' AND';}
						$requete = $requete.' (Date_Des';
						if($selectD2 == 'entre'){
							$requete = $requete.' BETWEEN \''.$DateD1.'\' AND \''.$DateD2.'\')';
						} else{$requete = $requete.' '.$selectD2.' \''.$DateD1.'\')';}
					}
					
					if($selectM1 == ''){
					}else{
						if($selectM1 == 'OU'){
							$requete = $requete.' OR';
						} else {$requete = $requete.' AND';}
						$requete = $requete.' (Menu LIKE \''.$selectM2.'\')';
					}
					// Fin de création de la requête
					
					// Vérification de la requête SQL : on calcule le nombre d'éléments séléctionnés par cette requête. Et visualisation.
					// echo $requete;		// Décommenter pour afficher la requête créée et la vérifier
					?><p>Nombre d'éléments trouvés : <?php
					$reponseTest = pg_query($requete);
					$tableauTest ;
					$indexTest = 0;
					while ($row = pg_fetch_row($reponseTest)) { 
						$tableauTest[$indexTest] = $row;
						$indexTest += 1; 
					}
					echo $indexTest;
					?></p><?php
					// Fin de la vérification de la requête et de la création de la matrice contenant les données.
				
					// Visualisation 
					if($indexTest<>0){
						$l=0;
						for($l=0;$l<count($tableauTest);$l++){
							//On affiche pour la j ième ligne du tableau colonne les éléments contenus dans l'objet tableau ligne
							// Partie commune à toute les sites
							?>
							<p>
							<hr>
							<label for="text">Nom de l'élément :</label>
							<input type="text" value='<?php echo $tableauTest[$l][1]; ?>' />
							</p><p>
							<label for="text">Année de début de construction :</label>
							<input type="text" value='<?php echo $tableauTest[$l][2]; ?>' />
							</p><p>	
							<label for="text">Année de fin de construction :</label>
							<input type="text" value='<?php echo $tableauTest[$l][3]; ?>' />
							</p><p>	
							<label for="text">Année de destruction :</label>
							<input type="text" value='<?php echo $tableauTest[$l][4]; ?>' />
							</p><p>	
							<label for="text">Descrption :</label>
							<input type="text" value='<?php echo $tableauTest[$l][5]; ?>' />
							</p><p>	
							<label for="text">Menu :</label>
							<input type="text" value='<?php echo $tableauTest[$l][6]; ?>' />
							</p>
							<?php
							// Partie supplémentaire
							if (count($tableauTest[$l])/2>7){
								for($i=7;$i<count($tableauTest[$l])/2;$i++){	
								// count/2 car le pg_fetch_row ne crée pas un tableau du nombre de colonnes de la table de la 
								//BDD mais crée un tableau du double du nombre de colonne donc avec la moitié du tableau vide. 
								//On commence par i=1 car le premier élément est laissé à la discrétion du gestionnaire de la BDD.
								?>
								<p>
								<label for="text">Autre critère :</label>
								<input type="text" value='<?php echo $tableauTest[$l][$i]; ?>' />
								</p>
								<?php
								}
							}
						}
					}
				}
				
				?>
                                <p><hr></p>
				
		</p>
	</div>
	
</body>

</html>
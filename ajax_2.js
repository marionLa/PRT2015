function submitForm2() {													//fonction appelée lors du clic sur la flèche
	if(document.getElementById("viewer").style.display == "none"){			//si le viewer 3D n'est pas affiché
		document.getElementById("viewer").style.display = "block";			//l'afficher
		document.getElementById("map").style.display = "none";				//cacher la carte geomajas
		document.getElementById("fleche_maquette").style.display = "none";  //faire disparaitre l'icone chateau 3D
		document.getElementById("fleche_carte").style.display = "block"; 	//faire apparaitre l'icone carte
		document.getElementById("text").value= "Visualisation temporelle";	//afficher "Visualisation temporelle"
		for (var j in objects){	
                                                                            //pour i parcourant le tableau objects (matrice obj 3D)
			scene.remove(objects[j]);										//supprimer l'objet n°j de la scène                                                            
		}
                objects.length = 0; 
	}

 	else{									//sinon
   		document.getElementById("viewer").style.display = "none";			//ne pas afficher le viewer
		document.getElementById("map").style.display = "block";				//afficher la carte geomajas
		document.getElementById("fleche_maquette").style.display = "block"; //faire apparaitre l'icone chateau 3D
		document.getElementById("fleche_carte").style.display = "none"; 	//faire disparaitre l'icone carte
		for (var j in objects){	
                                                                           //pour i parcourant le tableau objects (matrice obj 3D)
			scene.remove(objects[j]);										//supprimer l'objet n°j de la scène                                                            
		}
                objects.length = 0; 
	}




		$.ajax({							//fonction ajax d'actualisation
 		url: 'dates.php',					//executer le script dans dates.php
		success: function(dat){				//si succès, réalisation de la fonction
			$("#menuprinc").html(dat);		//afficher le résultat dans le div menu principal
			
			


			}
		});
}



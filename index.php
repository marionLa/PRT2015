<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
  xml:lang="fr" lang="fr">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		
<!-------------------------------------------LIEN VERS LA FEUILLE DE STYLE----------------------------------------------------------->	
  
		<LINK rel="stylesheet" href="style.css" type="text/css">
		

<!-------------------------------------------DEPENDANCES SCRIPTS/THREE.JS----------------------------------------------------------->
		
		<script src="./three.js/build/three.js"></script>
		<script src="./three.js/build/three.min.js"></script>
		<script src="./three.js/examples/js/renderers/Projector.js"></script>
		<script src="./three.js/examples/js/loaders/DDSLoader.js"></script>
		<script src="./three.js/examples/js/loaders/MTLLoader.js"></script>
		<script src="./three.js/examples/js/controls/OrbitControls.js"></script>
		<script src="./three.js/examples/js/Detector.js"></script>
		<script src="./three.js/examples/js/controls/PointerLockControls.js"></script>	
		<script src="./three.js/examples/js/libs/stats.min.js"></script>
		<script src="./three.js/examples/js/loaders/TGALoader.js"></script>
		<script src="./three.js/examples/js/controls/TrackballControls.js"></script>
		<script src="./three.js/examples/js/loaders/OBJMTLLoader.js"></script>
		<script src="./three.js/examples/js/controls/FirstPersonControls.js"></script>

		<script src="./three.js/examples/js/ImprovedNoise.js"></script>

		<script src="ajax.js"></script>
		<script src='ajax_2.js'></script>		

		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-------------------------------------------FONCTIONS MONTRER/CACHER MENUS----------------------------------------------------------->

<script>


// Cette première fonction concerne le menu de visualisation des informations sémantiques au survol. Lorsque l'on clique sur l'icone masquer, on 'plie' ou 'déplie' de menu.

function show(menu){ 							//lorsque l'on clique sur l'icone masquer
         if(document.getElementById("menu").style.display == "none") {	// si le menu n'est pas affiché
   	 document.getElementById("menu").style.display = "block"; 	// alors afficher le menu
	 }
  	 else	{							//sinon
   	 document.getElementById("menu").style.display = "none";	// masquer le menu
	 }
}
</script>

<script> 

// Cette fonction est la même que la précédente mais concerne le menu latéral de visualisation des objets
 
function show1(menuprinc){								//lorsque l'on clique sur l'icone dérouler
         if(document.getElementById("menuprinc").style.display == "none"){			//si le menu principal n'est pas visible
   	     	document.getElementById("menuprinc").style.display = "block";			//alors afficher le menu pricipal
                document.getElementById("checkboxdiv").style.display = "block";		//alors afficher le menu de sélection du type e visualisation
		 	document.getElementById("derouler").style.right="200px";				//règlage de la marge à droite pour l'affichage
	 	 }
 	 	 else{									//sinon
     	 	document.getElementById("menuprinc").style.display = "none";			//cacher le menu
                document.getElementById("checkboxdiv").style.display = "none";      //cacher la checkbox de visualisation
			document.getElementById("derouler").style.right="0px";					//règlage de la marge à droite
	 	 }
}	

</script>

<script>
//fonction qui sert à purger la scène
function purger(){
    for (var j in objects){																					//j parcourt la matrice objects
			scene.remove(objects[j]);																		//supprimer l'objet n°j de la scène   
                        document.getElementById(objects[j].name).style.backgroundColor = "transparent" ;    //remettre un fond transparent (=déselection)                                                         
    }
    objects.length = 0; 
}
</script>

<!----------------------------------AFFICHAGE DES OBJETS EN FONCTION DU MODE DE VISUALISATION------------------------------------------>


<!-- Vérification de la checkbox/affichage du mode de visualisation à l'utilisateur !-->

<script>

var objects = [];
var loader = new THREE.OBJMTLLoader();	
			
function check(){										//fonction qui vérifie l'état de la checkbox (libre/temps)
	if(checkbox.checked){									//si cochée
                console.log(objects);
				document.getElementById("text").value= "Visualisation temporelle";	        						//afficher "Visualisation temporelle"
		for (var j in objects){	
                        console.log(objects[j]);                                                      				//pour i parcourant le tableau objects (matrice obj 3D)
						scene.remove(objects[j]);																	//supprimer l'objet n°j de la scène   
                        document.getElementById(objects[j].name).style.backgroundColor = "transparent" ;            //remettre un fond transparent (=déselection)                                                         
		}
    objects.length = 0; 
    }
	else{																											//sinon
        document.getElementById("text").value= "Visualisation libre";												//afficher "Visualisation libre"                                                                                             			
    	for (var j in objects){																						//pour j parcourant le tableau objects
                        scene.remove(objects[j]);						//supprimer l'objet n°j de la scène
                        document.getElementById(objects[j].name).style.backgroundColor = "transparent" ;            //remettre un fond transparent (=déselection)       									
		}       
	objects.length = 0;	
    }
        
}																													//fin de la fonction check()
	
//------ Barre de chargement de l'objet qui affiche le % à l'utilisateur ------//

THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );					//chargement de la fonction loader de three.js									
var onProgress = function ( xhr ) {												//définition de la variable onProgress comme une fonction 
	if ( xhr.lengthComputable ) {												//s'il y a un chargement
		var percentComplete = xhr.loaded / xhr.total * 100;						//définition de la variable percentComplete
		var percent = Math.round(percentComplete, 2) + '% downloaded';			//définition de la variable percent comme chaîne de caractère
		
		
		if (percent === "100% downloaded"){
		document.getElementById("loading").style.display = "none";
		}
		else{
		document.getElementById("loading").style.display = "block";
		}

		document.getElementById("percent").innerHTML = percent;					//afficher le % effectué dans le div "loading"
	}
};
var onError = function ( xhr ) {												//définition de la variable onError
	document.getElementById("percent").innerHTML = "Erreur de chargement";		//si erreur lors du chargement alors le dire à l'utilisateur
};


function generateButtonCallback( url_elem, url2,datecons ) {					//fonction exécutée au clic sur un subbutton; url_elem = nom objet
	return function ( event ) {													//exécution immédiate de la fonction 

		
		
		if (document.getElementById(url_elem).style.backgroundColor.indexOf("rgba") != 0) {             		//si l'expression de la couleur de fond du bouton contient l'expression rgba
                    document.getElementById(url_elem).style.backgroundColor = "rgba(0, 255, 255, 0.7)"          // alors changer la couleur en rgba(0,255,255,0.7)
                    }
                else{                                                                                           //sinon
                   document.getElementById(url_elem).style.backgroundColor = "transparent"                      //remettre un fond transparent (=déselection)
                    }
		
                loadObj( url_elem,datecons );																	//exécution de la fonction loadobj() qui affiche les objets
	}
}

//------ Série de fonctions qui gèrent la génération du menu et l'affichage des objets de manière conditionnelle ------//


function loadObj( url_elem,datecons ) {		//fonction qui affiche les objets à l'écran

		
        if(checkbox.checked){																		//si on est en visualisation temporelle
		
            	if (objects.length != 0){                                           				//si la matrice objects n'est pas vide
                    for (var k in objects){                                         				//pour k parcourant objects
                        scene.remove(objects[k])                                        			//on enlève tous les objets de la scène
                        console.log(objects[k]);
                        document.getElementById(objects[k].name).style.backgroundColor = "transparent" ;      	//remettre un fond transparent (=déselection)
                    }
               objects.length = 0 ;                                                								//on réinitialise la matrice
                }
               
                  
		for (var i in OBJETS){																					//pour i parcourant les OBJETS 
                    
			if (parseInt(DATE_CONS[i])<=datecons && parseInt(DATE_DES[i])>=datecons) {  						//si la date de construction de l'objet à afficher est comprise entre les dates de construction et destruction de l'objet i
				
				(function(index){                                               								//fonction dans une boucle -> système asynchrone de javascript
                                    var load_obj = OBJETS[index];                               				//stockage des variables load_obj (noms des objets à charger)
                                    loader.load( './Donnees/OBJ/' + load_obj + '.obj', './Donnees/OBJ/' + load_obj + '.mtl', function ( object ) {  //exécution de la fonction -> chargement des objets 
                                        var load_obj = OBJETS[index]; 
                                        object.name=load_obj;                                                                                   	//on nomme l'objet pour les intersections 
                                        objects.push(object);                                                                                   	//on pousse l'objet à la fin du tableau
                                        scene.add( object );                                                                                    	//on ajoute l'objet  la scène                                      
                                        console.log(load_obj);                                  
                                        document.getElementById(load_obj).style.backgroundColor = "rgba(0, 255, 255, 0.7)"                       	//on change le fond du boutton
                                        console.log(objects);
                                    },  onProgress, onError ); 
                                })(i);
					}	
		
                }
            
           
           
	}
        
	else{	
            
                									//sinon (si la checkbox n'est pas cochée -> visualisation libre)
		var check = "";								//variable check initialisée à null
		for (var j in objects){						//pour j parcourant le tableau des objets 
			if (objects[j].name === url_elem){		//si le nom de l'objet j est égal au nom de l'élément sélectionné
				scene.remove(objects[j])			//supprimer l'objet j de la scène
				objects.splice(j,1);				//supprimer l'objet du tableau objects
				check = "removed";					//attribuer la valeur "removed" à check
			}
		}
		if (check != "removed") {						//si check est différent de "removed"
			loader.load( './Donnees/OBJ/'+url_elem+'.obj','./Donnees/OBJ/'+url_elem+'.mtl', function ( object ) { //charger l'objet url_elem (transmis par la fonction) .obj et sa texture .mtl
				object.name=url_elem;					//on attribue un nom à l'objet
				objects.push(object);					//on "pousse" l'objet dans le taleau des objets			
				scene.remove(object);					//on supprime l'objet de la scène pour se prémunir des superpositions
				scene.add( object );					//on ajoute l'objet
				console.log(objects);
			}, onProgress, onError );					//on affiche les % de chargement et l'erreur si elle survient

		}												//fin du if check différent de "removed"		
	}													//fin du else si visualisation libre
        

}														//fin de la fonction load_obj

//------ Fonction qui génère les boutons principaux du menu (colonne menu de la bdd) ------//

function generateButton( url,url2,i) { 												//fonction qui transmet url=date de construction de l'objet sélectionné, url2=chaine"objet"+n°i,i l'indice de l'objet sélectionné dans le tableau des DATES
	return function ( event ) {														//exécute immédiatment la fonction
		var arr = [].slice.call(document.getElementById( "liste_dates").children);	//création d'un tableau contenant les éléments de la sélection
		
		console.log(arr)
			
		if (document.getElementById(url).style.backgroundColor.indexOf("rgba") != 0) {             	//si l'expression de la couleur de fond du bouton contient l'expression rgba
                    document.getElementById(url).style.backgroundColor = "rgba(0, 255, 255, 0.7)"   // alors changer la couleur en rgba(0,255,255,0.7)
                    }
                else{                                                                               //sinon
                   document.getElementById(url).style.backgroundColor = "transparent"               //remettre un fond transparent (=déselection)
                    }
		console.log(document.getElementById(url).style.backgroundColor.indexOf("rgba"))
		createSubMenu( url,url2,i); //création du sous menu contenant les objets
	}
}

function createMenu(DATES) {								//création du menu principal des dates
	for ( var i in DATES ) {								//pour i parcourant le tableau des dates uniques (colonne menu)
		var button = document.createElement( 'button' );	//création d'un bouton
		var url =  DATES[i] ;								//création de la variable url=ième date du tableau
		var url2 = "objets"+i;								//création de url2 = objet+indice i (ex objets1,objets2...)
		var liste_dates = document.createElement('li');		//création de liste_dates comme un menu html
		var liste_elem = document.createElement('ul')		//création de liste_elem comme un sous menu html
		button.innerHTML = url;								//texte qui apparait sur le bouton
		button.id = url;									//définition de l'identifiant du bouton
		liste_dates.id = url;								//affectation d'un identifiant à liste_dates (nom du menu)
		liste_elem.id = url2								//affectation d'un identifiant à liste_elem (nom du sous menu)
		liste_dates.appendChild( button );					//ajout du bouton à liste_dates
		document.getElementById( "liste_dates").appendChild(liste_dates); 	//ajout de la liste des boutons au div liste_dates
		liste_dates.appendChild(liste_elem);								//ajout du menu liste_elem au menu liste_dates
		button.addEventListener( 'click', generateButton( url,url2,i ), false ); //création d'un 'surveilleur' qui guette le clic sur un bouton date et qui, si cela se produit, déclenchera la fonction generateButton()	
	}
}

function createSubMenu(url,url2,i) {				//fonction qui créée le sous menu des objets
	var check = "";									//initialisation de la variable check à null
	var ELEMENTS = eval("ELEMENTS_"+i);				//définition de la varaible ELEMENTS comme chaine de caractère ELEMENTS_i (ELEMENT_1,ELEMENT_2...) -> référence aux tableaux définis par php (liens.php)
	var ELEMENTSDATE = eval("ELEMENTSDATES_"+i);	//définition de la variable ELEMENTSDATES sur le même princpe ->référence aux tableaux définis dans liens.php
	var menu = eval("objets" + i);	                //définition de la variable menu sur le même principe -> référence au nom du menu supérieur
	var arr = [].slice.call(menu.children);			//définition de la variable arr qui stocke tous les éléments de menu
         
		for ( var n in arr ){						//pour n parcourant arr
			if (menu.id === url2) {					//si le sous-menu est déjà affiché 
				menu.removeChild (arr[n]);			//supprimer le sous-menu
                                    for (var m in objects){     					//pour m parcourant objects
                                        if (objects[m].name===arr[n].textContent){  //si l'un des objets de la matrice est affiché
                                        scene.remove(objects[m]);					//le supprimer de la scène
                                        objects.splice(m,1);	                	//supprimer l'objet du tableau objects
                                        }				
                                    }
			}
			var check='removed';											//valeur "removed" affectée à check
		}
			if (check!='removed'){											//si check est différent de 'removed'
				for ( var m in ELEMENTS ) {									//pour m parcourant le tableau ELEMENTS (qui correspond au tableau contenant les objets constuits à la date sélectionnée)
					var subbutton = document.createElement( 'subbutton' );	//créer un sous bouton
					var datecons = ELEMENTSDATE[m];							//varaible définissant la date de construction de l'élément m
					var url_elem =  ELEMENTS[m] ;							//variable définissant la variable url_elem comme la mième occurence du tableau ELEMENTS
					var liste_elements = document.createElement('li');		//création d'un sous-menu liste_elements
					document.getElementById("info").innerHTML = url + url_elem;	//Affichage dans le div info de la date+nom élément
					subbutton.id = url_elem;									//définition de l'identifiant du sous-bouton
					subbutton.innerHTML = url_elem;								//affichage du nom de l'objet sur le bouton	
					document.getElementById("button_select").value = datecons;	//affichage de la date de construction de l'objet dans le champ caché button_select
					liste_elements.appendChild( subbutton );					//ajout du sous bouton au menu liste_elements
					menu.appendChild(liste_elements);							//ajout du menu liste_elements au menu
					subbutton.addEventListener( 'click', generateButtonCallback( url_elem,url2,datecons ), false );  //création d'un 'surveilleur' qui féclenche la fonction 'generateButtonCallback' au clic sur un élément. 
				}
			}

}
</script>

<!------------------------DESACTIVATION DE LA CAMERA LORSQUE L'UTILISATEUR INTERAGIT DANS LE MENU------------------------------------>

<script>	
		
function help(){														//fonction qui gère l'ouverture/fermeture du menu d'aide
	if (document.getElementById("help_map").style.display == 'none'){	//si help_map n'est pas affiché
	document.getElementById("help_map").style.display = 'block';		//alors l'afficher
	}
	else{																//sinon
	document.getElementById("help_map").style.display = 'none';			//le cacher
	}
}

function close_help(){													//fonction qui ferme le menu d'aide au clic croix rouge
	document.getElementById("help_map").style.display = 'none'			//fermer help_map
}



</script>

</head>

<!--------------------------------------------BLOCS D'AFFICHAGE DE LA PAGE--------------------------------------------------------->

<body >

<!--------- bloc qui contient la flèche qui permet de passer de la visualisation 3D à la carte geomajas ---------------->

<div id="fleche_maquette">
	<img src="./3D.JPG" onclick="submitForm2()" height="50"/> <!-- le clic sur la flèche déclenche la fonction submitForm2() (ajax2.js) -->
</div>	

<div id="fleche_carte">
	<img src="./carte.png" onclick="submitForm2()" height="50"/> <!-- le clic sur la flèche déclenche la fonction submitForm2() (ajax2.js) -->
</div>	

<div id="icone_consultation">
	<a href="./indexm.php"> <img src="./icone_livre.png"  height="50"/> </a> <!-- le clic sur la flèche redirige vers de lien de la consultation de la bdd -->
</div>	
	

<!---------- bloc qui contient la carte de Geomajas lancée en localhost:8080 -------------------------------------->
<div id="map" >
<!--<iframe id="frame_map" src="http://localhost:8080" > </iframe>-->
	<!-- sous bloc qui contient le menu d'aide -->
	<div id="help_map">
	<img src="./quitter.png" onclick= "close_help()" height="15" align="right" /> <br>
	<br>
	<img src="./site.png" height="20"/> Sites disponibles en vue 3D ou contenant des informations <br>
	<br>
	<img src="./menu.png" height="20"/> Menu de calques disponibles <br>
	<br>
	<img src="./info.png" height="20"/> Afficher des informations sur le site <br>
	<br>
	<img src="./zoom_cadre.png" height="20"/> Zoom cadré <br>
	<br>
	<img src="./zoomplusmoins.png" height="20"/> Zoom avant/arrière <br>
	<br>
	<img src="./help.png" height="20"/> Ouvrir/fermer cette fenêtre <br>
	<br>
	<img src="./3D.JPG" height="20"/> Accéder au mode de visulalisation 3D <br>
        <br>
        <img src="./icone_livre.png" height="30"/> Accéder à l'interface de consultation de la base de données <br>
	</div>

	<!-- sous bloc qui contient l'image d'aide -->
	<div id="help_img">
	<img src="./help.png" onclick="help()" height="50"/>
	</div>	
</div>

<!--------- bloc qui contient le visualiseur 3D -------------------------------------------------------------------->

<div id="viewer">

	<!--------- bloc nécessaire à three.js liés aux objets 3D -------------------------------------------------------->
	<div id="container"></div>

			<!--------- bloc où s'affichent différents éléments pour l'utilisateur ---------------------------------->
			<div id="info">
			</div>
		
			<!--------- bloc caché contenant différentes informations pour le transfert de variables --------------->
			<div id="cache">
				<FORM action="submit.php" method='post' id='formulaire' >
				<input type="text" name="champ_select" id="champ_select" value=""/>
				<input type="button" id="searchForm" onclick="SubmitForm();" value="Send"  />
				<input type="text" id="button_select" name="button_select" />
				</FORM>	
			</div>
		
			<!--------- bloc qui contient le bouton de masquage du menu ------------------------>
			<div id="masquer">
				Réduire <img src="./masquer.png" onclick="show(menu)" height="20"/>
			</div>	

			<!--------- bloc qui contient le menu ------------------------------------------------>
			<div id="menu">
			</div>

			<!--------- bloc qui permet de dérouler le menu principal (à droite) ---------------->
			<div id="derouler">
				<img src="./lat.png" onclick="show1(menuprinc)" height="20"/>
			</div>	

			<!--------- bloc qui affiche la checkbox et indique le mode de visualisation -------->
			<div id="checkboxdiv">
				<input type="checkbox" id="checkbox" value="checkbox" onclick="check()" /> 
				<input type="text" id="text" name="text" value="Visualisation libre"/> <br><br>
                                <center><input type="button" id="purge" value="Réinitialiser la scène" onclick="purger()" /></center>
			</div>

			<!--------- bloc menu principal où l'utilisateur sélectionne les objets ------------->
			<div id="menuprinc">
			</div>

			<!--------- bloc qui affiche des informations dynamiques (temps chargement, objet survolé...) ---------------->
			<div id="id">
			</div>	

			<!--------- bloc qui indique le temps de chargement --------------------------------------------------------->
			<div id="loading">
				<div id = "percent">
				</div>
				<div id=" "loader">
				<img src="./loading.gif" height="300px"/>
				</div>
			</div>

</div>	

<!--------- appel du script de scène ------------------------------------------------------------------------------------>
<script src="./scene.js"></script>

</body>
</html>
